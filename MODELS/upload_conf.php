<?php

include_once ("includes/constants.php");
require_once ('includes/token.class.php');
include_once ("includes/GIFDecoders.class.php");
include_once ("includes/identifiants.php");
include_once ('includes/securite.class.php');
include_once 'check_grade.php';

/*
ERREURS RETOURNEES:

notlogged
captcha
size
format
titre
pseudo

*/

function retrieve_remote_file_size ($url)
{
    $ch = curl_init ($url);

    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt ($ch, CURLOPT_HEADER, TRUE);
    curl_setopt ($ch, CURLOPT_NOBODY, TRUE);
    curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, true);

    $data = curl_exec ($ch);
    $size = curl_getinfo ($ch, CURLINFO_CONTENT_LENGTH_DOWNLOAD);

    curl_close ($ch);
    return ($size / 10);
}

function addToFiles ($key, $url)
{
    $tempName = tempnam (PHP_DOSSIER_TMP, 'php');
    $originalName = basename (parse_url ($url, PHP_URL_PATH));

    $imgRawData = file_get_contents ($url);
    file_put_contents ($tempName, $imgRawData);

    $_FILES[$key] = array(
        'name' => $originalName,
        'type' => mime_content_type ($tempName),
        'tmp_name' => $tempName,
        'error' => 0,
        'size' => strlen ($imgRawData),
    );
}
function setTransparency($new_image,$image_source)
{

    $transparencyIndex = imagecolortransparent($image_source);
    $transparencyColor = array('red' => 255, 'green' => 255, 'blue' => 255);

    if ($transparencyIndex >= 0) {
        $transparencyColor    = imagecolorsforindex($image_source, $transparencyIndex);
    }

    $transparencyIndex    = imagecolorallocate($new_image, $transparencyColor['red'], $transparencyColor['green'], $transparencyColor['blue']);
    imagefill($new_image, 0, 0, $transparencyIndex);
    imagecolortransparent($new_image, $transparencyIndex);

}

/*
$framegif = ('/var/www/html/melenshack/images/frames/frame01.gif');
if (is_file ($framegif)) {
    chmod ($framegif, 0777);
    if (unlink ($framegif)) {
        echo 'File deleted';
    } else {
        echo 'Cannot remove that file';
    }
} else {
    echo 'Ce nest pas fichier remove that file';
} */

if (!isset($_SESSION)) {
    session_start ();
}

$id_user = $_SESSION['id'];
if (!$id_user) header ('Location:../upload.php?erreur=notlogged');

$pseudo = $_SESSION['pseudo'];
if (!$pseudo) header ('Location:../upload.php?erreur=pseudo');

if((Token::verifier(3600, 'upload')) == false) {
    header ('Location:../upload.php?erreur=token');
    exit();
}
/*
$referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
$domaine= parse_url(SITE_DOMAINE, PHP_URL_HOST);
echo $referer.'</br>';
echo $domaine.'</br>';
if ($referer != $domaine) {
    header ('Location:../upload.php?erreur=referer');
    exit();
    echo'lol';
} */

$captcha = $_POST['g-recaptcha-response'];
if (!$captcha) {
    header ('Location:../upload.php?erreur=captcha');
    exit();
}

$req = $bdd->prepare ('SELECT id FROM ban WHERE id_user = :id_user');
$req->execute ([
    'id_user' => $id_user,
]);
$resultat = $req->fetch ();

if ($resultat) {
    //La marteau du ban a frappé :)
    header ('Location:../upload.php?erreur=banned');
    exit();
}


// Verification de la validité du captcha
$response = file_get_contents ("https://www.google.com/recaptcha/api/siteverify?secret=6LeKlhgUAAAAAJGHPPA35YtfqvOHfH89BB9xvipi&response=" . $captcha);
$decoded_response = json_decode ($response);
if ($decoded_response->success == false) {
    header ('Location:../upload.php?erreur=captcha');
    exit();
}

$titre = htmlspecialchars($_POST['titre']);
if (strlen ($titre) > 255 || strlen ($titre) == 0) {
    header ('Location:../upload.php?erreur=titre');
    exit();
}
if (!empty($_POST['tags'])) {
    $nb_id = 0;
    $tagsstr = "";

    foreach ($_POST['tags'] as $id => $tag) {
        if ($id == 0) {
            $tagsstr = htmlspecialchars ($tag);
        } else
        	$tagsstr = $tagsstr . ',' . htmlspecialchars ($tag);
        $nb_id = $id;
    }

    $nbtags = $nb_id + 1;

    if ($nbtags > 10 OR strlen ($tagsstr) > 255) {
        header ('Location:../upload.php?erreur=tags');
        exit();
    }
} else {
    $tagsstr = "";
}

if (!empty($_POST['url'])) {
    $url = htmlspecialchars ($_POST['url']);

    $a = retrieve_remote_file_size ($url); // Vérification de la taille de l'image
    if ($a > MAX_SIZE) {
        header ('Location:../upload.php?erreur=size');
        exit();
    }

    if(strlen($url) >= 250) {
        header("Location:../upload.php?erreur=url");
        exit();
    }

    addToFiles ('file', $url);
    $image_type = htmlspecialchars($_FILES['file']["type"]);
    
    if (in_array ($image_type, array("image/png", "image/jpeg","image/jpg", "image/gif"))) {
        //Good !
        if ($image_type =="image/png") {
            $extension_image = "png";
        } elseif ($image_type =="image/gif") {
            $extension_image = "gif";
        } elseif ($image_type =="image/jpeg" OR $image_type =="image/jpg") {
            $extension_image = "jpg";
        }
    } else {
       header ('Location:../upload.php?erreur=notimage');
        exit();
    }

    $req = $bdd->prepare ('SELECT id FROM images WHERE url = :url AND supprime = :supprime');
    $req->execute ([
        ':url' => $url,
        ':supprime' => 0,
    ]);
    $resultat = $req->fetch ();

    if ($resultat) {
        header ('Location:../upload.php?erreur=existe'); // Image existe déja.
        exit();
    }


    $req = $bdd->prepare ('INSERT INTO images(titre, id_user, url, genre, tags, date_creation) VALUES(:titre, :id_user, :url, :genre, :tags, NOW())');
    $req->execute ([
        ':titre' => htmlspecialchars ($_POST['titre']),
        ':id_user' => $id_user,
        ':url' => $url,
        ':genre' => "url",
        ':tags' => $tagsstr,
    ]);

    $idbase = $bdd->lastInsertId ();
    $id = sha1 ($idbase . SALT_ID);

    $req = $bdd->prepare ('UPDATE images SET nom_hash = :nom_hash  WHERE id = :id ');
    $req->execute ([
        'nom_hash' => $id,
        'id' => $idbase,
    ]);
} elseif (!empty($_POST['url']) AND !empty($_FILES['file'])) {
    header ('Location:../upload.php?erreur='); // Soit url, soit image, pas les 2 en meme temps
    exit();
} else {
    if (empty($_FILES['file'])) {
        header ('Location:../upload.php?erreur=image'); //pas d'image
        exit();
    }
    $img = $_FILES['file'];

    $extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
    $extension_image = strtolower (substr (strrchr ($img['name'], '.'), 1));
    if (!in_array ($extension_image, $extensions_valides)) {
        header ('Location:../upload.php?erreur=format');
        exit();
    }
    if ($extension_image == "gif") {
        if ($img['size'] > (MAX_SIZE+5000000)) { // 5 Mo en + pour les gifs
            header ('Location:../upload.php?erreur=size');
            exit();
        }
    } else {
        if ($img['size'] > MAX_SIZE) {
            header ('Location:../upload.php?erreur=size');
            exit();
        }
    }

    $req = $bdd->prepare ('INSERT INTO images(titre, id_user, nom_original, format, genre, tags, date_creation) VALUES(:titre, :id_user, :nom_original, :format, :genre, :tags, NOW())');
    $req->execute ([
        ':titre' => htmlspecialchars ($_POST['titre']),
        ':id_user' => $id_user,
        ':nom_original' => htmlspecialchars ($img['name']), // A FAIRE ! : Verifier que < 255
        ':genre' => "image",
        ':format' => $extension_image,
        ':tags' => $tagsstr,
    ]);

    $idbase = $bdd->lastInsertId ();
    $id = sha1 ($idbase . SALT_ID);

    $req = $bdd->prepare ('UPDATE images SET nom_hash = :nom_hash  WHERE id = :id ');
    $req->execute ([
        'nom_hash' => $id,
        'id' => $idbase,
    ]);
}

$direction = '/images/' . $id . "." . $extension_image;
//$imagebase = __DIR__ . $direction;
$imagebase = '/var/www/html/melenshack'.$direction;

//var_dump($_FILES['file']);

if (is_uploaded_file($_FILES['file']['tmp_name'])) {
   move_uploaded_file ($_FILES['file']['tmp_name'], $imagebase);
} else {
    //echo "Vous ne passerez pas ! </br>";
    rename ($_FILES['file']['tmp_name'], $imagebase);
    //unlink($_FILES['file']['tmp_name']);
}

if ($extension_image != "gif") {
    list($width, $height) = getimagesize ($imagebase);
} elseif ($extension_image == "gif") {
    $gifDecoder = new GIFDecoder (fread (fopen ($imagebase, "rb"), filesize ($imagebase)));
    $i = 1;
    foreach ($gifDecoder->GIFGetFrames () as $frame) {
        if ($i < 2) {
            fwrite (fopen ("/var/www/html/melenshack/images/frames/frame0$i.gif", "a+"), $frame);
        }
        $i++;
    }
    $direction = '/../images/frames/frame01.gif';
    $imagebase = __DIR__ . $direction;
    list($width, $height) = getimagesize ($imagebase);
}

if (($extension_image == "jpg") OR ($extension_image == "jpeg")) {
    $source = imagecreatefromjpeg ($imagebase);
} elseif ($extension_image == "png") {
    $source = imagecreatefrompng ($imagebase);
} elseif ($extension_image == "gif") {
    $source = imagecreatefromgif ($imagebase);
}

if ($width >= $height) {
    $ratio = $width / VIGNETTE_WIDTH;
} else {
    $ratio = $height / VIGNETTE_HEIGHT;
}
$newwidth = $width / $ratio;
$newheight = $height / $ratio;
$thumb = imagecreatetruecolor ($newwidth, $newheight);
if($extension_image == "png") {
    setTransparency ($thumb, $source);
}
imagecopyresized ($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


if (($extension_image == "jpg") OR ($extension_image == "jpeg")) {
    imagejpeg ($thumb, __DIR__ . '/../vignettes/' . $id . '.jpg');
} elseif ($extension_image == "png") {
    imagepng ($thumb, __DIR__ . '/../vignettes/' . $id . '.png');
} elseif ($extension_image == "gif") {
    imagegif ($thumb, __DIR__ . '/../vignettes/' . $id . '.gif');
}
if (!empty($_POST['url'])) {
    $req = $bdd->prepare ('UPDATE images SET format = :format  WHERE id = :id ');
    $req->execute ([
        'format' => $extension_image,
        'id' => $idbase,
    ]);
    unlink(__DIR__ .'/../images/'. $id .'.'.$extension_image);
}
if ($extension_image == "gif") {
$framegif = ('/var/www/html/melenshack/images/frames/frame01.gif');
    if (is_file ($framegif)) {
        chmod ($framegif, 0777);
        if (unlink ($framegif)) {
           // echo 'File deleted';
        } else {
           // echo 'Cannot remove that file';
        }
    } else {
       // echo 'Ce nest pas fichier remove that file';
    }
}

header ('Location:../view.php?id=' . $id);
?>
