<?php
include '../../../connection.php'; 
require_once  $_SERVER['DOCUMENT_ROOT'].'/pages/common/util.php';
$limit = 5; // limita il numero di risultati per pagina
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
    }else {
        $ordine = "id_ingaggio DESC";
    }
}else{
    $ordine = "id_ingaggio DESC";
}

// calcolo l'offset per la query in base alla pagina
$start = ($page - 1) * $limit;
// scrivo la condizione della query in base al contenuto della ricerca
$condition = '';
$q = explode(" ", $search);
foreach($q as $text) {
    $condition .= "lower(titolo) LIKE '%".pg_escape_string($dbconn, $text )."%' OR ";
}
$condition = substr($condition, 0, -4);

/*
    se sono stai modificati dati riguardanti la data aggiungo le condizioni alla query
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

if(isset($_GET['citta']) AND $_GET['citta'] != NULL) {
    $citta = $_GET['citta'];
    $condition .= " AND id_citta = '".pg_escape_string($dbconn, $citta )."'";
}

$query = "SELECT * FROM v_ingaggio WHERE ". $condition ." ORDER BY ".$ordine." LIMIT $limit OFFSET $start" ;
$query_2 = "SELECT COUNT(id_ingaggio) FROM v_ingaggio WHERE ". $condition ."";


// serve per la paginazione e per controllare se ci sono artisti
$count_artisti = pg_fetch_row(pg_query($dbconn, $query_2))[0];

$result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());

// se ci sono artisti scrivo il contenuto html della pagina, utilizzando i dati della query
if($count_artisti> 0) {
    while($row = pg_fetch_array($result)) {
        $display .= '<div class="item-list-fed">';
        if((str_starts_with($row['immagine'], "https://") || str_starts_with($row['immagine'], "http://") )|| $row['immagine'] == NULL){
            $display .= '<img id="foto_profilo" src="../../../site_images/placeholder-image.webp" alt="foto profilo"  class="flex-shrink-0 me-3" />';
        }else{
            $display .= '<img id="foto_profilo" src="../../../user_data/'.$row['immagine'] .'" alt="foto profilo"  class="img-fluid" />';
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
                $display .= '<h5 class="mb-0 text-secondary" style="text-align:end" > '. $row['nome_locale'] .' </h5>';
                $result_2 = pg_query($dbconn, $query_2) or die('Query failed: ' . pg_last_error());
                $row_2 = pg_fetch_array($result_2);
                $display .= '<h6 class="mb-0" style="text-align:end"> <i class="bi bi-geo-alt-fill"></i> '. $row_2['nome_citta'] .' </h6>';
                
            }
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
// calcolo il numero di pagine necessarie per la paginazione
$total_pages = ceil($count_artisti / $limit);

// funzione che crea la paginazione si trova in /pages/common/util.php
$display .= pagination($page, $total_pages);
// adesso $display contiene la lista degli eventi e la paginazione e viene stampato 
echo $display;



?>