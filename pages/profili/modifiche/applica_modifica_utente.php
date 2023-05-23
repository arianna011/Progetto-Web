<?php

    $id = $_GET["id"];

    #dati form
    $nome = $_POST['nome'];
    $cognome = $_POST['cognome'];
    $data_nascita = $_POST['datanascita'];
    $id_citta =  $_POST['citta'];

    $nick = $_POST['nickname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $bio =  $_POST['bio'];
    $controlla = $_POST['controlla'];

    #variabili errore
    $erroreVuoto = 0;
    $erroreCaratteri = 0;
    $errorePassword = 0;
    $erroreMail = 0;
    $erroreData = 0;
    
    $mailUsata = 0;
    $nickUsato = 0;


    if($controlla == "si") {
        foreach($_POST as $key=>$value)
        {
            #controllo presenza caratteri pericolosi
            if (preg_match("([<>&(),%'?+])", $value) || preg_match('/"/', $value)){ $erroreCaratteri = 1; }
        }
        #controllo presenza campi obbligatori
        if (empty($nome) || empty($cognome) || empty($data_nascita) || empty($nick) || empty($email) || empty($password))
        {
            $erroreVuoto = 1;
        }

        #controllo validità email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erroreMail = 1; }
        
        $data_corrente = new DateTime(date('Y/m/d'));
        $data_nascita_d = new DateTime(date('Y/m/d', strtotime($data_nascita)));

        if ($data_nascita_d > $data_corrente) { $erroreData = 1; }

        #controllo validità password
        if (strlen($password)<8) $errorePassword = 1;

    }

    if ($erroreCaratteri != 1 && $erroreVuoto != 1 && $errorePassword != 1 && $erroreMail != 1 && $erroreData != 1 && $controlla == "si") 
    {
        include '../../../connection.php';

        $queryEmail = "SELECT id_utente FROM profilo_utente WHERE mail = '$email'";
        $resultEmail = pg_query($dbconn, $queryEmail) or die('Query failed: ' . pg_last_error());
        $numEmail = pg_num_rows($resultEmail);
        if ($numEmail>0) $idEmail = pg_fetch_row($resultEmail)[0];

        $queryNick = "SELECT * FROM profilo_utente WHERE nickname = '$nick'";
        $resultNick = pg_query($dbconn, $queryNick) or die('Query failed: ' . pg_last_error());
        $numNick = pg_num_rows($resultNick);
        if ($numNick>0) $idNick = pg_fetch_row($resultNick)[0];

        if ($numEmail > 0 && $idEmail != $id) $mailUsata = 1; #è possibile lasciare inalterati email e nickname
        if ($numNick > 0 && $idNick != $id) $nickUsato = 1;

        if ($mailUsata==0 && $nickUsato==0)
        {
           echo "dentro";
           $data = date('Y/m/d', strtotime($data_nascita));

           if ($id_citta==0) $id_citta = "NULL";

           $update="UPDATE profilo_utente SET nome = '" . $nome . "', cognome = '" . $cognome . "', datan='" . $data . "',
             nickname = '" . $nick . "', id_citta = " . $id_citta . ", mail = '" . $email . "', passwd = '" . $password . "', descrizione = '" . $bio . "' WHERE id_utente = " . $id . ";"; }
          
           $resultUpdate = pg_query($dbconn, $update) or die('Query failed: ' . pg_last_error());
          
           if (empty($bio) || strlen(trim($bio)) == 0)
           {
                $resetBio = "UPDATE profilo_utente SET descrizione = NULL WHERE id_utente =" . $id . ";";
                $resultReset =  pg_query($dbconn, $resetBio) or die('Query failed: ' . pg_last_error()); 
           }

        header("Location: ../profilo.php?update=1&ptype=1&id=". $id);           
    }
      
 
    if($erroreVuoto == 1) header("Location: modifica_profilo_utente.php?erroreVuoto=1&&id=".$id);
    if($erroreCaratteri == 1) header("Location: modifica_profilo_utente.php?erroreCaratteri=1&&id=".$id);
    if($erroreMail == 1) header("Location: modifica_profilo_utente.php?erroreMail=1&&id=".$id);
    if($errorePassword == 1) header("Location: modifica_profilo_utente.php?errorePassword=1&&id=".$id);
    if($erroreData == 1) header("Location: modifica_profilo_utente.php?erroreData=1&&id=".$id);
    if($mailUsata == 1) header("Location: modifica_profilo_utente.php?mailUsata=1&&id=".$id);
    if($nickUsato == 1) header("Location: modifica_profilo_utente.php?nickUsato=1&&id=".$id);
   
?>