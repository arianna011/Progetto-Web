<?php 
    $dbconn = pg_connect("host=localhost port=5432 dbname=NotaMi user=postgres password=federica")
    or die('Could not connect: ' . pg_last_error());
?>