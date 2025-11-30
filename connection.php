<?php 
    $dbconn = pg_connect("host=localhost user=postgres password=password port=5432 dbname=NotaMi") 
                or die("Errore di connessione: " . pg_last_error());
?>
