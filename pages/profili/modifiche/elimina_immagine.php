<?php 
    include '../../../connection.php';
    $target_dir = "../../../user_data/";
    
    $target_file = $target_dir.$_GET['del'];
    $id = $_GET['id'];

        //eliminio l'immagine dalla raccolta dell'artista 
        $get_raccolta = "SELECT galleria_artista FROM profilo_artista WHERE id_artista = ".$id;
        $id_raccolta = pg_fetch_row(pg_query($dbconn, $get_raccolta))[0];
        $get_immagine = "SELECT id_immagine FROM immagine WHERE src = '".$_GET['del']."'";
        
        $id_imm = pg_fetch_all(pg_query($dbconn, $get_immagine));
        foreach($id_imm as $imm ) {
        $query = "DELETE FROM immagine_appartiene_raccolta WHERE id_immagine=".$imm["id_immagine"]." AND id_raccolta=".$id_raccolta."";
        $result = pg_query($dbconn, $query);  
        }
        
        /*  meglio non cancellare l'immagine perché potrebbe essere un duplicato, si potrebbe fare un controllo batch ogni tot tempo
            per vedere se ci sono immagini non utilizzate e cancellarle

        if (file_exists($target_file)) {
            unlink($target_file);
        }
        */

    header("Location: ../profilo.php?id=".$id."&ptype=2");    




?>