<?php
include '../../../connection.php'; 
require_once  $_SERVER['DOCUMENT_ROOT'].'/pages/common/util.php';
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
    if($_GET['ordine'] == "migliori"){
        $ordine = "valutazione_media DESC";
    }else {
        $ordine = "id_locale DESC";
    }
}else{
    $ordine = "id_locale DESC";
}


$start = ($page - 1) * $limit;

$condition = '';

$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(nome_locale) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);

if(isset($_GET['citta']) AND $_GET['citta'] != NULL) {
    $citta = $_GET['citta'];
    $condition .= " AND id_citta = '".pg_escape_string($dbconn, $citta )."'";
}
    


$query = "SELECT * FROM v_profilo_locale WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
$query_2 = "SELECT COUNT(id_locale) FROM v_profilo_locale WHERE ". $condition ."";



//echo $query;
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());


if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">';
        if((str_starts_with($row['foto_profilo'], "https://") || str_starts_with($row['foto_profilo'], "http://" )|| $row['foto_profilo'] == NULL)){
            //$display .= '<img id="foto_profilo" src='. $row['foto_profilo'] .' alt="foto profilo"  class="flex-shrink-0 me-3" />';
            $display .= '<img id="foto_profilo" src="../../../site_images/placeholder-image.webp" alt="foto profilo"  class="img-fluid" />';
        }else{
            $display .= '<img id="foto_profilo" src="../../../user_data/'.$row['foto_profilo'] .'" alt="foto profilo"  class="img-fluid" />';
        }
        $display .= '
        <div class="col-md-4 p-4">
          <h5 class="nome artista"  >'. $row['nome_locale'] .' </h5>';
            if($row['valutazione_media']){
                $display .= '<h6 class="valutazione" style="color:#fd7e14">';
                 for ($i=1; $i < $row['valutazione_media']; $i+=2) { 
                    $display .= '<i class="bi bi-star-fill"></i>';
                 }
                 if($row['valutazione_media'] % 2 != 0){
                    $display .= '<i class="bi bi-star-half"></i>';
                 }
                 if($row['valutazione_media'] < 9){
                    for ($i=1; $i < 10 - $row['valutazione_media']; $i+=2) { 
                        $display .= '<i class="bi bi-star"></i>';
                     }
                 }
                $display .= ' </h6>';
            }else{
                $display .= '<h6 class="valutazione" style="color:#fd7e14"> nessuna valutazione </h6>';
            }

            if(strlen($row['descrizione_locale'])> 80) {
                $display .= ' <p> '. substr($row['descrizione_locale'],0, 80) .'... </p> ';
            } else {
                $display .= '<p> '. $row['descrizione_locale'] .' </p> '; 
            }
        
        $display .= '
          <a href="/pages/profili/profilo_locale.php?id='. $row['id_locale'] .'" class="btn btn-primary"> Vedi profilo </a>
        </div>
          <div class="col-md-3 p-4">
           <h6 class="mb-0" > <i class="bi bi-geo-alt-fill"></i> '. $row['nome_citta'] .' </h6>
                 <p class="text-body-secondary small"> '. $row['indirizzo'] .' </p> 
            
        </div>
      </div>';
    }
} else {
    $display .= '<h3 style="text-align:center;"> Nessun host trovato </h3>';
}

$total_pages = ceil($count_artisti / $limit);

// funzione che crea la paginazione si trova in pages/common/util.php
$display .= pagination($page, $total_pages);

echo $display;



?>