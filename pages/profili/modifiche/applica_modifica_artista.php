<?php

    $id = $_GET["id"];

    #dati form
    $nomeArte = $_POST['nickname'];
    $descr = $_POST['bio'];
    if (isset($_POST['strumenti'])) $strumenti = $_POST['strumenti'];
    
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
        if ($minPrezzo != NULL ) {$update = "UPDATE profilo_artista SET nomedarte = '" . $nomeArte . "', descrizione = '" . $descr . "', range_prezzo = '[". $minPrezzo . "," . $maxPrezzo ."]' WHERE id_artista = " . $id . ";"; } 
        else $update = "UPDATE profilo_artista SET nomedarte = '" . $nomeArte . "', descrizione = '" . $descr . "' WHERE id_artista = " . $id . ";"; 
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
        
        #aggiungo gli strumenti

        #aggiungo i generi

        #aggiungo i servizi
        
        header("Location: ../profilo.php?update=1&ptype=2&id=". $id);   
    }
      
    if($erroreCaratteri == 1) header("Location: modifica_profilo_artista.php?erroreCaratteri=1&&id=".$id);
    if($errorePrezzi1 == 1) header("Location: modifica_profilo_artista.php?errorePrezzi1=1&&id=".$id);
    if($errorePrezzi2 == 1) header("Location: modifica_profilo_artista.php?errorePrezzi2=1&&id=".$id);
   
?>