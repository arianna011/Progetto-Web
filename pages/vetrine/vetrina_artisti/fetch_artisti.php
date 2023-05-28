<?php
include '../../../connection.php'; 
require_once  $_SERVER['DOCUMENT_ROOT'].'/pages/common/util.php'; 
$limit = 5;
$page = 0;
$display = "";
$strum = "";
$gen = "";
$serv = "";

/*
    controllo quali parametri sono stati passati e li salvo nelle variabili
*/

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
// se non è specificato l'ordine allora è per id_artista decrescente (dal più recente)
if (isset($_GET['ordine'])) {
    if($_GET['ordine'] == "prezzo"){
        $ordine = "min_prezzo";
    } else if($_GET['ordine'] == "migliori"){
        $ordine = "valutazione_media DESC";
    }else {
        $ordine = "id_artista DESC";
    }
}else{
    $ordine = "id_artista DESC";
}
// se vengono specificati gli strumenti scrivo la parte di query per gli strumenti
if(isset($_GET['strumenti'])) {
    $strumenti = $_GET['strumenti'];
    $strum = '';
    foreach($strumenti as $str) {
        $strum .= " '".pg_escape_string($dbconn, $str )."' = any(strumenti_musicali) OR ";
    }
    $strum = substr($strum, 0, -4);
}

// se vengono specificati i generi scrivo la parte di query per i generi
if(isset($_GET['generi'])) {
    $generi = $_GET['generi'];
    $gen = 'OR ';
    foreach($generi as $genere) {
        $gen .= " '".pg_escape_string($dbconn, $genere )."' = any(generi_musicali) OR ";
    }
    $gen = substr($gen, 0, -4);
}
// se vengono specificati i servizi scrivo la parte di query per i servizi
if(isset($_GET['servizi'])) {
    $servizi = $_GET['servizi'];
    $serv = 'OR ';
    foreach($servizi as $servizio) {
        $serv .= " '".pg_escape_string($dbconn, $servizio )."' = any(servizi_forniti) OR ";
    }
    $serv = substr($serv, 0, -4);
}

// calcolo l'offset per la query in base alla pagina
$start = ($page - 1) * $limit;

// scrivo la condizione della query in base al contenuto della ricerca
$condition = '';
$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(nome) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);
// se è specificata la città la aggiungo alla condizione
if(isset($_GET['citta']) AND $_GET['citta'] != NULL) {
    $citta = $_GET['citta'];
    $condition .= " AND id_citta = '".pg_escape_string($dbconn, $citta )."'";
}
    
// scrivo query diverse perché in alcuni casi inserendo stringhe vuote nella query non funziona perché non è più una sintassi SQL valida
if(isset($_GET['strumenti'])){
    $query = "SELECT * FROM v_profilo_artista WHERE ". $condition ." AND (".$strum." ".$gen." ".$serv.") ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_artista) FROM v_profilo_artista WHERE ". $condition ." AND (".$strum." ".$gen." ".$serv.")";
}else if (isset($_GET['generi'])){  
    $gen = substr($gen, 3);
    $query = "SELECT * FROM v_profilo_artista WHERE ". $condition ." AND (".$gen." ".$serv.") ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_artista) FROM v_profilo_artista WHERE ". $condition ." AND (".$gen." ".$serv.")";
}else if (isset($_GET['servizi'])){
    $serv = substr($serv, 3);
    $query = "SELECT * FROM v_profilo_artista WHERE ". $condition ." AND (".$serv.") ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_artista) FROM v_profilo_artista WHERE ". $condition ." AND (".$serv.")";
}else{
    $query = "SELECT * FROM v_profilo_artista WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
    $query_2 = "SELECT COUNT(id_artista) FROM v_profilo_artista WHERE ". $condition ."";
}

// serve per la paginazione e per controllare se ci sono artisti
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());

// se ci sono artisti scrivo il contenuto html della pagina, utilizzando i dati della query
if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">';
        // immagine profilo
        if((str_starts_with($row['foto_profilo'], "https://") || str_starts_with($row['foto_profilo'], "http://" )) || $row['foto_profilo'] == NULL){
            $display .= '<img id="foto_profilo" src="../../../site_images/placeholder-image.webp" alt="foto profilo"  class="img-fluid" />';
        }else{
            $display .= '<img id="foto_profilo" src="../../../user_data/'.$row['foto_profilo'] .'" alt="foto profilo"  class="img-fluid" />';
        }
        // nome artista
        $display .= 
        '<div class="col-md-4 p-4">
          <h5 class="nome artista"  >'. $row['nome'] .' </h5>';
          // stelle valutazione media
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
                $display .= '  </h6>';
            }else{
                $display .= '<h6 class="valutazione" style="color:#fd7e14"> nessuna valutazione </h6>';
            }
        // città e descrizione
        $display .= '
        <h6 class="mb-0" > <i class="bi bi-geo-alt-fill"></i> '. $row['nome_citta'] .' </h6>'; 
        if(strlen($row['descrizione'])> 80) {
            $display .= ' <p> '. substr($row['descrizione'],0, 80) .'... </p> ';
        } else {
            $display .= '<p> '. $row['descrizione'] .' </p> '; 
        }
        // bottone per vedere il profilo
        $display .= '
          <a href="/pages/profili/profilo.php?id='. $row['id_artista'] .'&ptype=2" class="btn btn-primary"> Vedi profilo </a>
        </div>
        <div class="col-md-3 p-4">
            <h5 style="color:#fd7e14; margin-top:5%; text-align:end"> '. $row['min_prezzo'] .' - '. $row['max_prezzo'] .' € </h5>';
        // funzione che crea i badge per strumenti, generi e servizi si trova in /pages/common/util.php
        $display .= toBadges($row["strumenti_musicali"], "bg-secondary");
        $display .= toBadges($row["generi_musicali"], "bg-info");
        $display .= toBadges($row["servizi_forniti"], "bg-danger");

        $display .= '
        </div>
      </div>';
    }
} else {
    // se non ci sono artisti scrivo un messaggio
    $display .= '<h3 style="text-align:center;"> Nessun artista trovato </h3>';
}
// calcolo il numero di pagine necessarie per la paginazione
$total_pages = ceil($count_artisti / $limit);

// funzione che crea la paginazione si trova in /pages/common/util.php
$display .= pagination($page, $total_pages);
// adesso $display contiene la lista degli artisti e la paginazione e viene stampato 
echo $display;



?>