<?php

    $id = $_GET["id"];

    #dati form
    $nomeArte = $_POST['nickname'];
    $descr = $_POST['bio'];
    $strumenti = array();
    $generi = array();
    $servizi = array();
    if (isset($_POST['strumenti'])) $strumenti = $_POST['strumenti'];
    if (isset($_POST['genere'])) $generi = $_POST['genere'];
    if (isset($_POST['servizio'])) $servizi = $_POST['servizio'];
    
    $minPrezzo = $_POST['minPrezzo'];
    $maxPrezzo = $_POST['maxPrezzo'];

    $controlla = $_POST['controlla'];

    #variabili errore
    $erroreCaratteri = 0;
    $errorePrezzi1 = 0;
    $errorePrezzi2 = 0;


    if($controlla == "si") {
        
        #controllo presenza caratteri pericolosi
            if (preg_match("([<>&(),%'?+])", $nomeArte) || preg_match('/"/', $nomeArte)){ $erroreCaratteri = 1; }
            if (preg_match("([<>&(),%'?+])", $descr) || preg_match('/"/', $descr)){ $erroreCaratteri = 1; }

        #controllo che il prezzo minimo sia minore o uguale al prezzo massimo
        if ($minPrezzo > $maxPrezzo) $errorePrezzi1 = 1;

        #controllo che venga specificato sia prezzo minimo che masssimo (oppure nessuno dei due)
        if (($minPrezzo == NULL && $maxPrezzo != NULL) || ($minPrezzo != NULL && $maxPrezzo == NULL)) $errorePrezzi2 = 1;

    }

    if ($erroreCaratteri != 1 && $errorePrezzi1 != 1 && $errorePrezzi2 != 1 && $controlla == "si") 
    {
        include '../../../connection.php';

        #modifica di nome d'arte, descrizione e prezzi
        if ($minPrezzo != NULL ) {$update = "UPDATE profilo_artista SET nomedarte = '" . $nomeArte . "', descrizione = '".$descr."', range_prezzo = '[". $minPrezzo . "," . $maxPrezzo ."]' WHERE id_artista = " . $id . ";"; } 
        else $update = "UPDATE profilo_artista SET nomedarte = '" . $nomeArte . "', descrizione = '".$descr."' WHERE id_artista = " . $id . ";"; 
        $resultUpdate = pg_query($dbconn, $update);

        #setto a NULL i valori non impostati
        if (strlen(trim($nomeArte)) == 0) 
        {
            $resetNome = "UPDATE profilo_artista SET nomedarte = NULL WHERE id_artista =" . $id . ";";
            $resultResetNome =  pg_query($dbconn, $resetNome) or die('Query failed: ' . pg_last_error()); 
        }

        if (strlen(trim($descr)) == 0)
        {
            $resetDescr = "UPDATE profilo_artista SET descrizione = NULL WHERE id_artista =" . $id . ";";
            $resultResetDescr =  pg_query($dbconn, $resetDescr) or die('Query failed: ' . pg_last_error()); 
        }

        echo print_r($strumenti)."  STRUMENTI <br>";
        echo print_r($generi)." GENERI <br>";
        echo print_r($servizi)." SERVIZI <br>";
        #aggiungo gli strumenti
        $old_strumenti = "SELECT id_strumento FROM strumento_artista_lookup WHERE id_artista = " . $id . ";";
        $resultOldStrumenti = pg_query($dbconn, $old_strumenti);
        $old_strumenti_array = pg_fetch_all_columns($resultOldStrumenti, 0);
        echo print_r($old_strumenti_array)." OLD STRUMENTI <br>";
        foreach ($old_strumenti_array as $old_strumento) {
            if(!in_array($old_strumento, $strumenti)) {
            $delete_strumento = "DELETE FROM strumento_artista_lookup WHERE id_artista = " . $id . " AND id_strumento = " . $old_strumento . ";";
            $resultDeleteStrumento = pg_query($dbconn, $delete_strumento);
            } 
        }
        foreach($strumenti as $strumento){
            if(!in_array($strumento, $old_strumenti_array)) {
            $add_strumento = "INSERT INTO strumento_artista_lookup (id_artista, id_strumento) VALUES (" . $id . ", " . $strumento . ");";
            $resultAddStrumento = pg_query($dbconn, $add_strumento);
            }
        }
        #aggiungo i generi
        $old_generi = "SELECT id_genere FROM genere_artista_lookup WHERE id_artista = " . $id . ";";
        $resultOldGeneri = pg_query($dbconn, $old_generi);
        $old_generi_array = pg_fetch_all_columns($resultOldGeneri,0);
        foreach ($old_generi_array as $old_genere) {
            if(!in_array($old_genere, $generi)) {
            $delete_genere = "DELETE FROM genere_artista_lookup WHERE id_artista = " . $id . " AND id_genere = " . $old_genere . ";";
            $resultDeleteGenere = pg_query($dbconn, $delete_genere);
            } 
        }
        foreach($generi as $genere){
            if(!in_array($genere, $old_generi_array)) {
            $add_genere = "INSERT INTO genere_artista_lookup (id_artista, id_genere) VALUES (" . $id . ", " . $genere . ");";
            $resultAddGenere = pg_query($dbconn, $add_genere);
            }
        }
        #aggiungo i servizi
        $old_servizi = "SELECT id_servizio FROM servizio_artista_lookup WHERE id_artista = " . $id . ";";
        $resultOldServizi = pg_query($dbconn, $old_servizi);
        $old_servizi_array = pg_fetch_all_columns($resultOldServizi, 0);
        foreach ($old_servizi_array as $old_servizio) {
            if(!in_array($old_servizio, $servizi)) {
            $delete_servizio = "DELETE FROM servizio_artista_lookup WHERE id_artista = " . $id . " AND id_servizio = " . $old_servizio . ";";
            $resultDeleteServizio = pg_query($dbconn, $delete_servizio);
            } 
        }
        foreach($servizi as $servizio){
            if(!in_array($servizio, $old_servizi_array)) {
            $add_servizio = "INSERT INTO servizio_artista_lookup (id_artista, id_servizio) VALUES (" . $id . ", " . $servizio . ");";
            $resultAddServizio = pg_query($dbconn, $add_servizio);
            }
        }
        
        header("Location: ../profilo.php?update=1&ptype=2&id=". $id);   
    }
      
    if($erroreCaratteri == 1) header("Location: modifica_profilo_artista.php?erroreCaratteri=1&&id=".$id);
    if($errorePrezzi1 == 1) header("Location: modifica_profilo_artista.php?errorePrezzi1=1&&id=".$id);
    if($errorePrezzi2 == 1) header("Location: modifica_profilo_artista.php?errorePrezzi2=1&&id=".$id);
   
?>