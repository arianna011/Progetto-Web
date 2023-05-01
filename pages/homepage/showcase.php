<?php
    include "../../connection.php";
    
    #band
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
    
    $band = array($band1, $band2, $band3);
    $stars_band = array("", "", "");

    foreach ($band as $x => $b)
    {
      if($b['valutazione_media'])
      {
         $stars_band[$x] .= '<h6 class="valutazione" style="color:#fd7e14">';
         
         for ($i=1; $i < $b['valutazione_media']; $i+=2) 
         { 
           $stars_band[$x] .= '<i class="bi bi-star-fill"></i>';
         }

         if($b['valutazione_media'] % 2 != 0)
         {
           $stars_band[$x] .= '<i class="bi bi-star-half"></i>';
         }
         
         if($b['valutazione_media'] < 9)
         {
            for ($i=1; $i < 10 - $b['valutazione_media']; $i+=2) 
            { 
              $stars_band[$x] .= '<i class="bi bi-star"></i>';
            }
         }
        
        $stars_band[$x] .= ' </h6>';
    } else
     {
       $stars_band[$x] .= '<h6 class="valutazione" style="color:#fd7e14"> nessuna valutazione </h6>';
     }
    }

    $genres_band = array("","","");
    foreach ($band as $x => $b)
    {
      $s = explode(",",substr($b['generi_musicali'],1,-1));
      foreach($s as $str) 
      {
        if ($str != "") 
          {
              if($str[0] == '"' && $str[-1] =='"') $str = substr($str,1,-1);
              $genres_band[$x] .= '<span class="badge bg-info text-wrap mx-1"> '. $str .' </span>';
          }
        else
        {
          $genres_band[$x] .= '<span class="text-grey"> <i> Genere musicale non specificato </i> </span>';
          break;
        }
      }
    }

    $prices_band = array("","","");
    foreach ($band as $x => $b)
    {
      $prices_band[$x] .= '<span class="showcase-price">' . $band[$x]["min_prezzo"] . ' € - ' . $band[$x]["max_prezzo"] . ' €' . '</span>';
    }

    #artisti
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

    $artist = array($art1, $art2, $art3);
    $stars_artist = array("", "", "");
  
    foreach ($artist as $x => $a)
    {
      if($a['valutazione_media'])
      {
        $stars_artist[$x] .= '<h6 class="valutazione" style="color:#fd7e14">';
           
          for ($i=1; $i < $a['valutazione_media']; $i+=2) 
          { 
             $stars_artist[$x] .= '<i class="bi bi-star-fill"></i>';
          }
  
          if($a['valutazione_media'] % 2 != 0)
          {
            $stars_artist[$x] .= '<i class="bi bi-star-half"></i>';
          }
           
          if($a['valutazione_media'] < 9)
          {
            for ($i=1; $i < 10 - $a['valutazione_media']; $i+=2) 
            { 
                $stars_artist[$x] .= '<i class="bi bi-star"></i>';
            }
          }
          
          $stars_artist[$x] .= ' </h6>';
      } else
       {
         $stars_artist[$x] .= '<h6 class="valutazione" style="color:#fd7e14"> nessuna valutazione </h6>';
       }
      }

?>