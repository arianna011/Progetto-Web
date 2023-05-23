<?php
include '../../../connection.php';
$target_dir = "../../../user_data/";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    $id = "";
}
$name = basename("$id".$_FILES["profiloUtente"]["name"]);
$target_file = $target_dir . $name;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Controllo se il file è un'immagine
if(isset($_POST["caricaProfiloUtente"])) {
  $check = getimagesize($_FILES["profiloUtente"]["tmp_name"]);
  if($check !== false) {
    $upload = move_uploaded_file($_FILES["profiloUtente"]["tmp_name"], $target_file);
    if ($upload) {
      $query = " INSERT INTO immagine(src) VALUES ('$name') RETURNING id_immagine";
      $result = pg_query($dbconn, $query);
      $id_immagine = pg_fetch_row($result)[0];
      if($_GET['ptype'] == 1){
      $query = "UPDATE profilo_utente SET foto_profilo = ".$id_immagine." WHERE id_utente = ".$id;
      $result = pg_query($dbconn, $query);
      header("Location: ../profilo_utente.php?id=".$id."&ptype=1");  
      }else if($_GET['ptype'] == 2){
        $query = "UPDATE profilo_artista SET foto_profilo = ".$id_immagine." WHERE id_artista = ".$id;
        $result = pg_query($dbconn, $query);
        header("Location: ../profilo_utente.php?id=".$id."&ptype=2");  
      } else if($_GET['ptype'] == 6){
        $get_raccolta = "SELECT galleria_artista FROM profilo_artista WHERE id_artista = ".$id;
        $id_raccolta = pg_fetch_row(pg_query($dbconn, $get_raccolta))[0];
        $query = "INSERT INTO immagine_appartiene_raccolta(id_immagine, id_raccolta) VALUES (".$id_immagine.", ".$id_raccolta.")";
        $result = pg_query($dbconn, $query);
        header("Location: ../profilo_utente.php?id=".$id."&ptype=2");          
      }
    }

  } else {
    echo "File is not an image.";
  } 
}


?>