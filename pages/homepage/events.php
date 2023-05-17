<?php
   
    $query = "SELECT nick_datore, immagine, titolo, descrizione, data_ingaggio, compenso_indicativo, nome_locale, indirizzo,
              AGE(data_ingaggio, CURRENT_DATE) AS data_diff, to_char(data_ingaggio, 'dd/mm/yyyy') as stringa_data
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
    $descr_events = array($no_descr,$no_descr,$no_descr,$no_descr);
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

    $no_loc = '<span class="text-grey mb-3"> <i> Luogo non specificato </i> </span>';
    $locations = array($no_loc,$no_loc,$no_loc,$no_loc);

    foreach ($events as $i => $e)
    {
      $nome_loc = $events[$i]["nome_locale"];
      $indirizzo = $events[$i]["indirizzo"];
      
      if ($nome_loc) 
      {
        $locations[$i] = '<i class="bi bi-building"> <span class="ms-1">' . $nome_loc . '</span> </i>';
        if ($indirizzo)
          $locations[$i] .= '&nbsp &nbsp &nbsp' ;
      } 
      
      if ($indirizzo)
      {
        $locations[$i] .= '<i class="bi bi-geo-alt-fill"> <span class="ms-1">' . $indirizzo . '</span> </i>';
      }
    }

    $no_retr = '<span class="text-grey mb-3"> <i> Compenso non specificato </i> </span>';
    $retributions = array($no_retr,$no_retr,$no_retr,$no_retr);

    foreach ($events as $i => $e)
    {
      $retr = $events[$i]["compenso_indicativo"];
      if ($retr) 
      {
        $retribution[$i] = '<span class="showcase-retr mb-3"> ' . $retr . ' € </span>';
      }
    }
   
?>