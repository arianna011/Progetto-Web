<?php
    if ($_SERVER["REQUEST_METHOD"] != "POST") 
    {
        header("Location: /");
    }
    else 
    {
        include './../../connection.php';
    }

    #dati form
    $email = $_POST["inputEmail"];
    $password = $_POST["inputPassword"];
    $controlla = $_POST["controlla"];

    #errori
    $erroreCaratteri = 0;
    $erroreMail = 0;
    $erroreDati = 0;

    if($controlla == "si") 
    {
        foreach($_POST as $key=>$value)
        {
            if (preg_match("([<>&(),%'?+])", $value) || preg_match('/"/', $value)){ $erroreCaratteri = 1; }
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { $erroreMail = 1; }
    }

    if ($erroreCaratteri==0 && $erroreMail==0)
    {
        $queryUtente = "SELECT univoco FROM profilo_utente WHERE mail = '$email' AND passwd = '$password'";
        $result = pg_query($dbconn, $queryUtente);
        $num = pg_num_rows($result);
        if ($num < 1) $erroreDati = 1;
        else
        {
            $univoco = pg_fetch_row($result)[0];
            
            setcookie("univoco", $univoco,  time() + 86400, "/");
            if(isset($_POST["back"])) { header("Location: ../recensioni/recensioni.php?id=".$_POST["back"]);
            echo $_POST["back"]; }
            else
            header("Location: ../homepage/index.php");
        }
    }
    
    if($erroreCaratteri == 1) header("Location: ./login.php?erroreCaratteri=1");
    if($erroreMail == 1) header("Location: ./login.php?erroreMail=1");
    if($erroreDati == 1) header("Location: ./login.php?erroreDati=1");
?>

    

