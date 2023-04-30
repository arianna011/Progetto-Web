<?php 
    $dbconn = pg_connect("host=localhost user=postgres password=federica port=5432 dbname=NotaMi") 
                or die("Errore di connessione: " . pg_last_error());
?>