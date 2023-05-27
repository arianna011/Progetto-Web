<?php

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
    $erroreCaratteri = 0;
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
        #controllo validità email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erroreMail = 1; }
        
        #controllo validità data
        $data_corrente = new DateTime(date('Y/m/d'));
        $data_nascita_d = new DateTime(date('Y/m/d', strtotime($data_nascita)));

        if ($data_nascita_d > $data_corrente) { $erroreData = 1; }

    }

    if ($erroreCaratteri != 1 && $erroreMail != 1 && $erroreData != 1 && $controlla == "si") 
    {
        include '../../connection.php';

        $queryEmail = "SELECT * FROM profilo_utente WHERE mail = '$email'";
        $resultEmail = pg_query($dbconn, $queryEmail) or die('Query failed: ' . pg_last_error());
        $numEmail = pg_num_rows($resultEmail);

        $queryNick = "SELECT * FROM profilo_utente WHERE nickname = '$nick'";
        $resultNick = pg_query($dbconn, $queryNick) or die('Query failed: ' . pg_last_error());
        $numNick = pg_num_rows($resultNick);
        
        #controllo presenza di email o nick duplicati
        if ($numEmail > 0) $mailUsata = 1;
        if ($numNick > 0) $nickUsato = 1;

        if ($mailUsata==0 && $nickUsato==0)
        {
           include './generaUnivoco.php';
           $data = date('Y/m/d', strtotime($data_nascita));

           if ($id_citta==0) $id_citta = "NULL";

           if (!empty($bio)) { $insert="INSERT INTO profilo_utente (nome, cognome, datan, nickname, id_citta, foto_profilo, descrizione, mail, passwd, univoco) VALUES ('$nome','$cognome','$data','$nick',$id_citta,NULL,'$bio','$email','$password','$univoco')"; }
           else { $insert="INSERT INTO profilo_utente (nome, cognome, datan, nickname, id_citta, foto_profilo, descrizione, mail, passwd, univoco) VALUES ('$nome','$cognome','$data','$nick',$id_citta,NULL,NULL,'$email','$password','$univoco')";}
           $resultInsert = pg_query($dbconn, $insert) or die('Query failed: ' . pg_last_error());
            header("Location: login.php?reg=ok");           
        }
      
    }

    #impostazione delle variabili di errore in $_GET
    if($erroreCaratteri == 1) header("Location: registration.php?erroreCaratteri=1");
    if($erroreMail == 1) header("Location: registration.php?erroreMail=1");
    if($erroreData == 1) header("Location: registration.php?erroreData=1");
    if($mailUsata == 1) header("Location: registration.php?mailUsata=1");
    if($nickUsato == 1) header("Location: registration.php?nickUsato=1");
   
?>