<?php
    include "connection.php";
    
    $query1 = "SELECT foto_profilo, nome_band, valutazione_media, generi_musicali, sede, min_prezzo, max_prezzo 
              FROM v_profilo_band 
              ORDER BY valutazione_media DESC;";
    
    $result1 = pg_query($dbconn, $query1);
    
    $band1 = pg_fetch_array($result1, null, PGSQL_ASSOC);
    $band2 = pg_fetch_array($result1, null, PGSQL_ASSOC);
    $band3 = pg_fetch_array($result1, null, PGSQL_ASSOC);

    if (!$band1 || !$band2 || !$band3) {
        echo "Si è verificato un errore nella ricerca band\n";
        exit;
      }

    $query2 = "SELECT foto_profilo, nome, valutazione_media, generi_musicali, nome_citta, min_prezzo, max_prezzo 
              FROM v_profilo_artista 
              ORDER BY valutazione_media DESC;";
    
    $result2 = pg_query($dbconn, $query2);

    $art1 = pg_fetch_array($result2, null, PGSQL_ASSOC);
    $art2 = pg_fetch_array($result2, null, PGSQL_ASSOC);
    $art3 = pg_fetch_array($result2, null, PGSQL_ASSOC);

    if (!$art1 || !$art2 || !$art3) {
        echo "Si è verificato un errore nella ricerca artisti\n";
        exit;
      }

?>