<?php
include '../../../connection.php'; 
$limit = 5;
$page = 0;
$display = "";
$strum = "";
$gen = "";
$serv = "";

if (isset($_POST['page'])) {
    $page = $_POST['page'];
}else{
    $page = 1;
}

if (isset($_POST['search'])) {
    $search = $_POST['search'];
}else{
    $search = "";
}

if (isset($_POST['ordine'])) {
    if($_POST['ordine'] == "prezzo"){
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

if(isset($_POST['citta']) AND $_POST['citta'] != NULL) {
    $citta = $_POST['citta'];
    $condition .= " AND id_luogo = '".pg_escape_string($dbconn, $citta )."'";
}
    


$query = "SELECT * FROM ingaggio WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
$query_2 = "SELECT COUNT(id_ingaggio) FROM ingaggio WHERE ". $condition ."";



//echo $query;
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());


if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">
        <img id="foto_profilo" src='. $row['immagine'] .' alt="immagine"  class="flex-shrink-0 me-3" />
        <div class="col-md-4 p-2">
          <h5 class="nome artista"  >'. $row['titolo'] .' </h5>
          <p> '. substr($row['descrizione'],0,100) .' </p>
          <a href="evento.php?id='. $row['id_ingaggio'] .'" class="btn btn-primary"> Partecipa </a>
        </div>
          <div class="col-md-3 p-4">';
            if($row['id_luogo'] != NULL){
                $query_2 = "SELECT nome_citta FROM citta WHERE id_citta = '". $row['id_luogo'] ."'";
                $result_2 = pg_query($dbconn, $query_2) or die('Query failed: ' . pg_last_error());
                $row_2 = pg_fetch_array($result_2);
                $display .= '<h6 class="mb-0" > <i class="bi bi-geo-alt-fill"></i> '. $row_2['nome_citta'] .' </h6>';
                
            }
                // <p class="text-body-secondary small"> '. $row['indirizzo'] .' </p> 
            $display .= '<p class="text-body-secondary small"> '. $row['data_ingaggio'] .' </p>
            
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
        $display .= '<li class="page-item" id="1" ><a class="page-link" > << </a></li>';    
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