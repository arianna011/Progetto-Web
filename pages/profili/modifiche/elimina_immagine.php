<?php 
    include '../../../connection.php';
    $target_dir = "../../../user_data/";
    $target_file = $target_dir.$_GET['del'];
    $id = $_GET['id'];


    if (file_exists($target_file)) {
        unlink($target_file);
    }

    
        $get_raccolta = "SELECT galleria_artista FROM profilo_artista WHERE id_artista = ".$id;
        $id_raccolta = pg_fetch_row(pg_query($dbconn, $get_raccolta))[0];
        $get_immagine = "SELECT id_immagine FROM immagine WHERE src = '".$_GET['del']."'";
        $id_imm = pg_fetch_row(pg_query($dbconn, $get_immagine))[0];
        $query = "DELETE FROM immagine_appartiene_raccolta WHERE id_immagine=".$id_imm." AND id_raccolta=".$id_raccolta."";
        $result = pg_query($dbconn, $query);        
        $query = "DELETE FROM immagine WHERE id_immagine=".$id_imm."";
        $result = pg_query($dbconn, $query);

    header("Location: ../profilo.php?id=".$id."&ptype=2");    




?>