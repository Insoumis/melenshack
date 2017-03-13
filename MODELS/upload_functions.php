<?php
include_once ("includes/constants.php");
include_once ("includes/GIFDecoders.class.php");
include_once ("includes/identifiants.php");

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

function createImagesVignettes($file, $id, $fromurl = false) {

	global $bdd;

	$image_type = htmlspecialchars($file["type"]);
    
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
		return ('?erreur=format');
    }
	$direction = '/images/' . $id . "." . $extension_image;
	$imagebase = __DIR__.'/..'.$direction;


	if (is_uploaded_file($file['tmp_name'])) {
		move_uploaded_file ($file['tmp_name'], $imagebase);
	} else {
		rename ($file['tmp_name'], $imagebase);
	}

	if ($extension_image != "gif") {
		list($width, $height) = getimagesize ($imagebase);
	} elseif ($extension_image == "gif") {
		$gifDecoder = new GIFDecoder (fread (fopen ($imagebase, "rb"), filesize ($imagebase)));
		$i = 1;
		foreach ($gifDecoder->GIFGetFrames () as $frame) {
			if ($i < 2) {
				fwrite (fopen (__DIR__."/../images/frames/frame0$i.gif", "w+"), $frame);

			}
			$i++;
		}
		$direction = '/../images/frames/frame01.gif';
		$imagebase = __DIR__ . $direction;
		list($width, $height) = getimagesize ($imagebase);
	}

	if (($extension_image == "jpg")) {
		$source = imagecreatefromjpeg ($imagebase);
	} elseif ($extension_image == "png") {
		$source = imagecreatefrompng ($imagebase);
	} elseif ($extension_image == "gif") {
		$source = imagecreatefromgif ($imagebase);
	}
    if (!$source) {
        header ('Location:../upload.php?erreur=image');
        exit();
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


	if (($extension_image == "jpg")) {
		imagejpeg ($thumb, __DIR__ . '/../vignettes/' . $id . '.jpg');
	} elseif ($extension_image == "png") {
		imagepng ($thumb, __DIR__ . '/../vignettes/' . $id . '.png');
	} elseif ($extension_image == "gif") {
		imagegif ($thumb, __DIR__ . '/../vignettes/' . $id . '.gif');
	}
	if ($fromurl) {
		$req = $bdd->prepare ('UPDATE images SET format = :format  WHERE nom_hash = :id ');
		$req->execute ([
				'format' => $extension_image,
				'id' => $id,
		]);
		unlink(__DIR__ .'/../images/'. $id .'.'.$extension_image);
	}
	if ($extension_image == "gif") {
		$framegif = ('__DIR__./../images/frames/frame01.gif');
		if (is_file ($framegif)) {
			chmod ($framegif, 755);
			unlink ($framegif);
		}		
	}

	return "redirect";

}

function insertImageFromFile($img, $id_user, $titre, $tagsstr, $pseudo) {
	global $bdd;

	$image_type = htmlspecialchars($img["type"]);
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
		return ('?erreur=format');
    }
    if ($extension_image == "gif") {
        if ($img['size'] > (MAX_SIZE+5000000)) { // 5 Mo en + pour les gifs
            return ('?erreur=size');
        }
    } else {
        if ($img['size'] > MAX_SIZE) {
            return ('?erreur=size');
        }
    }

    $req = $bdd->prepare ('INSERT INTO images(titre, id_user, pseudo_author, format, genre, tags, date_creation) VALUES(:titre, :id_user, :pseudo_author, :format, :genre, :tags, NOW())');
    $req->execute ([
        ':titre' => htmlspecialchars ($titre),
        ':id_user' => $id_user,
        ':pseudo_author' => $pseudo,
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

	return $id;
}

function insertImageFromUrl($url, $id_user, $titre, $tagsstr, $pseudo) {
	global $bdd;

	$a = retrieve_remote_file_size ($url); // Vérification de la taille de l'image
    if ($a > MAX_SIZE) {
        return ('?erreur=size');
    }

    if(strlen($url) >= 250) {
        return ("?erreur=url");
    }

    addToFiles ('file', $url);

    $req = $bdd->prepare ('SELECT id FROM images WHERE url = :url AND supprime = :supprime');
    $req->execute ([
        ':url' => $url,
        ':supprime' => 0,
    ]);
    $resultat = $req->fetch ();

    if ($resultat) {
        return ('?erreur=existe'); // Image existe déja.
    }


    $req = $bdd->prepare ('INSERT INTO images(titre, id_user, pseudo_author, url, genre, tags, date_creation) VALUES(:titre, :id_user, :pseudo_author, :url, :genre, :tags, NOW())');
    $req->execute ([
        ':titre' => htmlspecialchars ($titre),
        ':id_user' => $id_user,
        ':pseudo_author' => $pseudo,
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

	return $id;
}
