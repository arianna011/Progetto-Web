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
    } else if($_POST['ordine'] == "migliori"){
        $ordine = "valutazione_media DESC";
    }else {
        $ordine = "id_band DESC";
    }
}else{
    $ordine = "id_band DESC";
}


if(isset($_POST['generi'])) {
    $generi = $_POST['generi'];
    $gen = 'OR ';
    foreach($generi as $genere) {
        $gen .= " '".pg_escape_string($dbconn, $genere )."' = any(generi_musicali) OR ";
    }
    $gen = substr($gen, 0, -4);
}

if(isset($_POST['servizi'])) {
    $servizi = $_POST['servizi'];
    $serv = 'OR ';
    foreach($servizi as $servizio) {
        $serv .= " '".pg_escape_string($dbconn, $servizio )."' = any(servizi_forniti) OR ";
    }
    $serv = substr($serv, 0, -4);
}


$start = ($page - 1) * $limit;

$condition = '';

$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(nome_band) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);

if(isset($_POST['citta']) AND $_POST['citta'] != NULL) {
    $citta = $_POST['citta'];
    $condition .= " AND id_citta = '".pg_escape_string($dbconn, $citta )."'";
}
    


if (isset($_POST['generi'])){  
    $gen = substr($gen, 3);
    $query = "SELECT * FROM v_profilo_band WHERE ". $condition ." AND (".$gen." ".$serv.") ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_band) FROM v_profilo_band WHERE ". $condition ." AND (".$gen." ".$serv.")";
}else if (isset($_POST['servizi'])){
    $serv = substr($serv, 3);
    $query = "SELECT * FROM v_profilo_band WHERE ". $condition ." AND (".$serv.") ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_band) FROM v_profilo_band WHERE ". $condition ." AND (".$serv.")";
}else{
    $query = "SELECT * FROM v_profilo_band WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_band) FROM v_profilo_band WHERE ". $condition ."";
}


//echo $query;
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());


if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">
        <img id="foto_profilo" src='. $row['foto_profilo'] .' alt="foto profilo"  class="flex-shrink-0 me-3" />
        <div class="col-md-4 p-2">
          <h5 class="nome artista"  >'. $row['nome_band'] .' </h5>';
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
        $display .= '
          <a href="profilo_band.php?id='. $row['id_band'] .'" class="btn btn-primary  style="padding:2%;"> Vedi profilo </a>
        </div>
        <div class="col-md-3 p-4">
            <h5 style="color:#fd7e14; margin-top:5%; text-align:end"> '. $row['min_prezzo'] .' - '. $row['max_prezzo'] .' € </h5>';

          $s = explode(",",substr($row['generi_musicali'],1,-1));
            foreach($s as $str) {
                if ($str != "") {
                    if($str[0] == '"' && $str[-1] =='"')
                    $str = substr($str,1,-1);
                    $display .= '<span class="badge bg-info text-wrap"> '. $str .' </span>';
                }
          }

            $s = explode(",",substr($row['servizi_forniti'],1,-1));
            foreach($s as $str) {
                if ($str != ""){
                    if($str[0] == '"' && $str[-1] =='"')
                    $str = substr($str,1,-1);
                    $display .= '<span class="badge bg-primary text-wrap"> '. $str .' </span>';
                }
            }


        $display .= '
        </div>
      </div>';
    }
} else {
    $display .= '<h3 style="text-align:center;"> Nessuna band trovata </h3>';
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