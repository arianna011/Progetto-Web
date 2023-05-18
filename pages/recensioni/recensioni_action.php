<?php
include '../../connection.php';
$valutazione = $_POST['rating'];
$testo = $_POST['recensione'];
$id_oggetto = $_POST['id_oggetto'];
$id_utente = $_POST['id_utente'];

if($valutazione == NULL || $testo == NULL) {
    header("Location: recensioni.php?id=$id_oggetto");
    exit;
}

if(isset($_POST['elimina']) || isset($_POST['modifica']) ) {
    $delete = "DELETE FROM recensione_artista WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
    $result = pg_query($dbconn, $delete) or die('Query failed: ' . pg_last_error());
}

if(!isset($_POST['elimina'])) {
$insert = "INSERT INTO recensione_artista (id_utente, id_oggetto, valutazione, testo, data_recensione) VALUES ($id_utente, $id_oggetto, $valutazione, '$testo', CURRENT_DATE)";
$result = pg_query($dbconn, $insert) or die('Query failed: ' . pg_last_error());
}


header("Location: recensioni.php?id=$id_oggetto");


?>