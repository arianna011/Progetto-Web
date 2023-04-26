<?php
include 'connection.php'; 
$limit = 10;
$page = 0;
$display = "";

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



$start = ($page - 1) * $limit;

$condition = '';

$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(nome) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);

$query = "SELECT * FROM v_profilo_artista WHERE ". $condition ." ORDER BY id_artista LIMIT $limit OFFSET $start" ;
$query_2 = "SELECT COUNT(id_artista) FROM v_profilo_artista WHERE ". $condition;


$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());


if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">
        <img id="foto_profilo" src='. $row['foto_profilo'] .' alt="foto profilo" class="flex-shrink-0 me-3" />
        <div class="col-md-4 p-2">
          <h5 class="nome artista" >'. $row['nome'] .' </h5>
          <p> '. $row['descrizione'] .' </p>
        </div>
      </div>';
    }
}

$total_pages = ceil($count_artisti / $limit);


$display .= '    <nav aria-label="Page navigation">
                    <ol class="pagination justify-content-end">';
    if($page > 1) {
        $previous = $page - 1;  
        $display .= '<li class="page-item" id="1" ><a class="page-link" > 1 </a></li>';    
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
        $display .= '<li class="page-item" id="'.$total_pages.'" ><a class="page-link" > '.$total_pages.' </a></li>';
   }

   $display .='</ol> </nav>';

   echo $display;



?>