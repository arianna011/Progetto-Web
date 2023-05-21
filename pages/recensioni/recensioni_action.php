<?php
include '../../connection.php';
$valutazione = $_POST['rating'];
$testo = $_POST['recensione'];
$id_oggetto = $_POST['id_oggetto'];
$id_utente = $_POST['id_utente'];
$tipo = $_POST['tipo'];

if($valutazione == NULL || $testo == NULL) {
    header("Location: /pages/profili/profilo.php?id=$id_oggetto&tipo=$tipo");
    exit;
}

if(isset($_POST['elimina'])) {
    switch($tipo) {
        case 2:
            $delete = "DELETE FROM recensione_artista WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $delete) or die('Query failed: ' . pg_last_error());
            break;
        case 3:
            $delete = "DELETE FROM recensione_band WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $delete) or die('Query failed: ' . pg_last_error());
            break;
        case 4:
            $delete = "DELETE FROM recensione_locale WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $delete) or die('Query failed: ' . pg_last_error());
            break;

    }
}

if(isset($_POST['modifica'])) {
    switch($tipo) {
        case 2:
            $update = "UPDATE recensione_artista SET valutazione = $valutazione, testo = '$testo', data_recensione = CURRENT_DATE WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $update) or die('Query failed: ' . pg_last_error());
            break;
        case 3:
            $update = "UPDATE recensione_band SET valutazione = $valutazione, testo = '$testo', data_recensione = CURRENT_DATE WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $update) or die('Query failed: ' . pg_last_error());
            break;
        case 4:
            $update = "UPDATE recensione_locale SET valutazione = $valutazione, testo = '$testo', data_recensione = CURRENT_DATE WHERE id_utente = $id_utente AND id_oggetto = $id_oggetto";
            $result = pg_query($dbconn, $update) or die('Query failed: ' . pg_last_error());
            break;

    }
}

if(!isset($_POST['elimina']) && !isset($_POST['modifica'])) {
    switch($tipo) {
        case 2:
            $insert = "INSERT INTO recensione_artista (id_utente, id_oggetto, valutazione, testo, data_recensione) VALUES ($id_utente, $id_oggetto, $valutazione, '$testo', CURRENT_DATE)";
            $result = pg_query($dbconn, $insert) or die('Query failed: ' . pg_last_error());
            break;
        case 3:
            $insert = "INSERT INTO recensione_band (id_utente, id_oggetto, valutazione, testo, data_recensione) VALUES ($id_utente, $id_oggetto, $valutazione, '$testo', CURRENT_DATE)";
            $result = pg_query($dbconn, $insert) or die('Query failed: ' . pg_last_error());
            break;
        case 4:
            $insert = "INSERT INTO recensione_locale (id_utente, id_oggetto, valutazione, testo, data_recensione) VALUES ($id_utente, $id_oggetto, $valutazione, '$testo', CURRENT_DATE)";
            $result = pg_query($dbconn, $insert) or die('Query failed: ' . pg_last_error());
            break;
    }
}


header("Location: /pages/profili/profilo.php?id=$id_oggetto&ptype=$tipo");


?>