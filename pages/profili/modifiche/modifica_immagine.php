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



<h4 class="text-orange mt-4 mb-4">Immagini </h4>

<form id="caricaProfiloUtente"  method="POST" enctype="multipart/form-data">
  <div class="col-md-6"> 
  <label class="form-label" for="profiloUtente"> Immagine Profilo Utente </label>
      <div class="input-group">
      <input type="file" class="form-control" id="profiloUtente" name="profiloUtente">
      <input type="submit" class="btn btn-outline-secondary" name="caricaProfiloUtente">
      </div>
      <div class="form-text">Scegli un'immagine di dimensione minima 200 x 200 pixel</div>
          
  </div>
</form>

