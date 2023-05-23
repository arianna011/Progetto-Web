<?php 
    include '../../../connection.php';
    $id = $_GET["id"];
    $query = "INSERT INTO profilo_artista (id_artista) VALUES (".$id.");";
    $result = pg_query($dbconn, $query);
    if (!$result) echo "Errore: inserimento non riuscito";
    else header("Location: modifica_profilo_artista.php?id=".$id);


?>




      