<?php
    include "../../connection.php";
    $query = "SELECT nick_datore, immagine, titolo, descrizione, data_ingaggio, compenso_indicativo, nome_locale,
              AGE(data_ingaggio, CURRENT_DATE) AS data_diff
              FROM v_ingaggio
              WHERE data_ingaggio > CURRENT_DATE
              ORDER BY data_diff";
    
    $result = pg_query($dbconn, $query);
    if (!$result) {
        echo "Si è verificato un errore nella ricerca eventi\n";
        exit;
      }
    
    $event1 = pg_fetch_array($result, null, PGSQL_ASSOC);
    $event2 = pg_fetch_array($result, null, PGSQL_ASSOC);
    $event3 = pg_fetch_array($result, null, PGSQL_ASSOC);
    $event4 = pg_fetch_array($result, null, PGSQL_ASSOC);

    $events = array($event1, $event2, $event3, $event4 );

    $no_descr = '<span class="text-grey mb-3"> <i> Nessuna descrizione </i> </span>';
    $descr_events = array($no_descr,$no_descr,$no_descr);
    $max_descr = 200;
    foreach ($events as $i => $e)
    {
      $descr = $events[$i]["descrizione"];
      if ($descr) 
      {
        if (strlen($descr) > $max_descr)
        {
          $descr_events[$i] = '<span class="showcase-descr mb-3">' . substr($descr, 0, $max_descr) . '</span> <span class="text-grey"> ... </span>';
        }
        else $descr_events[$i] = '<span class="showcase-descr mb-3">' . $descr . '</span>';
      }
    }


    
   
?>