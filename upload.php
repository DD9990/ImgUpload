

<?php
$target_dir = "images/"; // folder za slike
$target_datoteka = $target_dir . basename($_FILES["fileToUpload"]["name"]); // ful path za spremanje slike
$valjano = 1; // Flag to track if the upload is successful
$imageFileType = strtolower(pathinfo($target_datoteka, PATHINFO_EXTENSION)); // vrsta slike tj file extension

// provjerava radi li se o slici ili o drugom fileu
if (isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check !== false) {
        echo "File je slika, točnije - " . $check["mime"] . ".";
        $valjano = 1;
    } else {
        echo "File nije slika, javi se upravi vodovoda.";
        $valjano = 0;
    }
}

// Ako je već u folderu ista slika
if (file_exists($target_datoteka)) {
    echo "Ova slika već postoji (isto ime).";
    $valjano = 0;
}

// ograničenje slike na 5mb
if ($_FILES["fileToUpload"]["size"] > 5000000) {
    echo "Slika veća od 5mb.";
    $valjano = 0;
}

// dopušta samo kompatibilne formate
$allowedExtensions = ["jpg", "jpeg", "png", "gif"];
if (!in_array($imageFileType, $allowedExtensions)) {
    echo "samo JPG, JPEG, PNG, and GIF su dopušteni.";
    $valjano = 0;
}

// Move the uploaded file to the specified directory
if ($valjano == 1) { // jesu li prošle inicijalne provjere
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_datoteka)) { //ako uspije sami upload
	    echo " Upload je potpuno uspješan :)";

        // učitavanje opisa
        $desc = $_POST['desc'];

        // xml učitavanje
        $xmlPath = 'metadata.xml'; // Adjust the path to your actual file
        $xml = simplexml_load_file($xmlPath);

        // dodavanje slike
        $newImage = $xml->images->addChild('image');
        $newImage->addChild('name', basename($_FILES["fileToUpload"]["name"]));
        $newImage->addChild('description', $desc);
        $newImage->addChild('date', date("Y-m-d"));

        // xml spremanje
        $xml->asXML($xmlPath);



    } else { //nešto je pošlo jako po krivu
	    echo "Isprike, desila se neočekivana greška, probajte drugu sliku.";
    }
}
?>

<a href="index.php">Nazad!</a>


