<?php
if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: /");
}
else {
    include 'connection.php';
}
?>
<!DOCTYPE html>
<html>
    <head></head>
    <body>
        <?php
            if ($dbconn) {
                $email = $_POST['inputEmail'];
                $q1 = "select * from profilo_utente where mail= $1";
                $result = pg_query_params($dbconn, $q1, array($email));
                if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                    echo "<h1> Non esiste un account con questa email </h1>
                        <a href=../registrazione/index.html> Registrati </a>";
                }
                else {
                    $password = password_hash($_POST['inputPassword']);
                    $q2 = "select * from profilo_utente where mail = $1 and passwd = $2";
                    $result = pg_query_params($dbconn, $q2, array($email,$password));
                    if (!($tuple=pg_fetch_array($result, null, PGSQL_ASSOC))) {
                        echo "<h1> La password è sbagliata! </h1>
                            <a href=./login.php> Clicca qui per loggarti </a>";
                    }
                    else {
                        $nome = $tuple['nome'];
                        echo "<a href=../index.php?name=$nome> Premi qui </a>
                            per inziare a usare il sito";
                    }
                }
            }
        ?> 
    </body>
</html>