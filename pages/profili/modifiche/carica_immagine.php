<?php
$target_dir = "../../user_data/";
$target_file = $target_dir . basename($_FILES["profiloUtente"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Controllo se il file è un'immagine
if(isset($_POST["caricaProfiloUtente"])) {
  $check = getimagesize($_FILES["profiloUtente"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  } 
}
?>