<?php
include '../../../connection.php'; 
$limit = 5;
$page = 0;
$display = "";
$strum = "";
$gen = "";
$serv = "";

if (isset($_GET['page'])) {
    $page = $_GET['page'];
}else{
    $page = 1;
}

if (isset($_GET['search'])) {
    $search = $_GET['search'];
}else{
    $search = "";
}

if (isset($_GET['ordine'])) {
    if($_GET['ordine'] == "prezzo"){
        $ordine = "min_prezzo";
    }else {
        $ordine = "id_ingaggio DESC";
    }
}else{
    $ordine = "id_ingaggio DESC";
}


$start = ($page - 1) * $limit;

$condition = '';

$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(titolo) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);

/*
if(isset($_GET['citta']) AND $_GET['citta'] != NULL) {
    $citta = $_GET['citta'];
    $condition .= " AND id_luogo = '".pg_escape_string($dbconn, $citta )."'";
}
*/
    
if(isset($_GET['anno']) AND $_GET['anno'] != NULL) {
    $anno = $_GET['anno'];
    $condition .= " AND EXTRACT(YEAR FROM data_ingaggio) = '".pg_escape_string($dbconn, $anno )."'";
}

if(isset($_GET['mese']) AND $_GET['mese'] != NULL) {
    $mese = $_GET['mese'];
    $condition .= " AND EXTRACT(MONTH FROM data_ingaggio) = '".pg_escape_string($dbconn, $mese )."'";
}

if(isset($_GET['giorni']) AND $_GET['giorni'] != NULL) {
    $giorni = $_GET['giorni'];
    $condition .= " AND (";
    foreach ($giorni as $giorno){
        $condition .= "EXTRACT(DAY FROM data_ingaggio) = '".pg_escape_string($dbconn, $giorno )."' OR ";}
    $condition = substr($condition, 0, -4);
    $condition .= ")";
}


$query = "SELECT * FROM v_ingaggio WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
$query_2 = "SELECT COUNT(id_ingaggio) FROM ingaggio WHERE ". $condition ."";


//echo $query;
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());


if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">';
        if(str_starts_with($row['immagine'], "https://") || str_starts_with($row['immagine'], "http://")){
            $display .= '<img id="foto_profilo" src='. $row['immagine'] .' alt="foto profilo"  class="flex-shrink-0 me-3" />';
        }else{
            $display .= '<img id="foto_profilo" src="../../../data/'.$row['immagine'] .'" alt="foto profilo"  class="img-fluid" />';
        }
        $display .= '
        <div class="col-md-4 p-4">
          <h5 class="nome artista"  >'. $row['titolo'] .' </h5>';
          if(strlen($row['descrizione'])> 80) {
            $display .= ' <p> '. substr($row['descrizione'],0, 80) .'... </p> ';
        } else {
            $display .= '<p> '. $row['descrizione'] .' </p> '; 
        }
        $display .= '
          <a href="evento.php?id='. $row['id_ingaggio'] .'" class="btn btn-primary"> Partecipa </a>
        </div>
          <div class="col-md-3 p-4">';
            if($row["compenso_indicativo"] != NULL){
                $display .= '<h5 class=" text-secondary" style="margin-top:5%; text-align:end" > '. $row['compenso_indicativo'] .' € </h5>';
            }
            if($row["nome_locale"] != NULL){
                $query_2 = "SELECT nome_citta FROM v_profilo_locale WHERE nome_locale = '". $row["nome_locale"] ."'";
                $display .= '<h5 class="mb-0 text-secondary" > '. $row['nome_locale'] .' </h5>';
                $result_2 = pg_query($dbconn, $query_2) or die('Query failed: ' . pg_last_error());
                $row_2 = pg_fetch_array($result_2);
                $display .= '<h6 class="mb-0" > <i class="bi bi-geo-alt-fill"></i> '. $row_2['nome_citta'] .' </h6>';
                
            }
                // <p class="text-body-secondary small"> '. $row['indirizzo'] .' </p> 
           // $display .= '<p class="text-body-secondary small"> '. $row['data_ingaggio'] .' </p>
           $s = explode("-",$row['data_ingaggio']);
                $display .= '<h4 class="text-end mt-2"> '. $s[2] .' ';
                switch($s[1]) {
                    case "01":
                        $mese = "Gennaio";
                        break;
                    case "02":
                        $mese = "Febbraio";
                        break;
                    case "03":
                        $mese = "Marzo";
                        break;
                    case "04":
                        $mese = "Aprile";
                        break;
                    case "05":
                        $mese = "Maggio";
                        break;
                    case "06":
                        $mese = "Giugno";
                        break;
                    case "07":
                        $mese = "Luglio";
                        break;
                    case "08":
                        $mese = "Agosto";
                        break;
                    case "09":
                        $mese = "Settembre";
                        break;
                    case "10":
                        $mese = "Ottobre";
                        break;
                    case "11":
                        $mese = "Novembre";
                        break;
                    case "12":
                        $mese = "Dicembre";
                        break;
                }
                //$display .= '<h5 class="text-center text-secondary"> '. $mese .' </h5>
                $display .= ' '.$mese.' '.$s[0].' </h4>';
                if($row['ora_inizio'] != NULL){
                    if($row['ora_fine'] != NULL) {
                 $display .= '<h5 class="text-end" style="color:#C0C0C0;"> '.substr($row['ora_inizio'],0, -3).'-'.substr($row['ora_fine'],0, -3).' </h5>';
                } else {
                    $display .= '<h5 class="text-end "> '.substr($row['ora_inizio'],0, -3).' </h5>';
                }}

        $display .= '
        </div>
      </div>';
    }
} else {
    $display .= '<h3 style="text-align:center;"> Nessun host trovato </h3>';
}

$total_pages = ceil($count_artisti / $limit);


$display .= '    <nav aria-label="Page navigation">
                    <ol class="pagination justify-content-end">';
    if($page > 1) {
        $previous = $page - 1;  
        $display .= '<li class="page-item" id="1" ><a class="page-link" target="_top" > << </a></li>';    
        $display .='  <li class="page-item" id="'.$previous.'" ><a class="page-link" > < </a></li>';
    }
   for($i=1; $i<= $total_pages; $i++) {
        $active_class = "";
        if($i == $page) {
            $active_class = "active";
        }
        if($i == $page-1 || $i == $page || $i == $page+1 || $i == $page+2 || $i == $page-2) {
            $display .= '<li class="page-item '.$active_class.'" id="'.$i.'" ><a class="page-link" >'.$i.'</a></li>';
        }
   }
   if($page < $total_pages) {
        $page++;
        $display .= '<li class="page-item"  id="'.$page.'"><a class="page-link" > > </a></li>';
        $display .= '<li class="page-item" id="'.$total_pages.'" ><a class="page-link" > >> </a></li>';
   }

   $display .='</ol> </nav>';

   echo $display;



?>