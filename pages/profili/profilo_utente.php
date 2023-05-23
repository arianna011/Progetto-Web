<?php
$isProfiloUtente = true;

require_once  $_SERVER['DOCUMENT_ROOT'].'/connection.php'; 
require_once  $_SERVER['DOCUMENT_ROOT'].'/pages/common/util.php'; 

//controllo che l'id sia presente
if (!isset($_GET['id'])) 
{
    echo "id utente non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT id_utente, nickname, descrizione, foto_profilo, nome_citta, mail
FROM v_profilo_utente
WHERE id_utente = $1";

$result = pg_prepare($dbconn, "usr", $query);
if (!$result) { echo pg_last_error($dbconn); exit; }

$result = pg_execute($dbconn, "usr", array($id));
if (!$result) { echo pg_last_error($dbconn); exit; }

$utente = pg_fetch_assoc($result);
if (!$utente) { echo "utente non trovato; ".pg_last_error($dbconn); exit; }

//controlli per verificare che l'utente abbia fatto il login
if (isset($_COOKIE["univoco"])) $univoco = $_COOKIE["univoco"];
else $univoco = "";

$check_utente = "select * from profilo_utente where id_utente = ".$id." and univoco = '".$univoco."'";
$result = pg_fetch_row(pg_query($dbconn, $check_utente));

if ($result) $isUtente = true;
else $isUtente = false;

pg_close($dbconn);

$id = $utente["id_utente"];
$avatarSrc = $utente["foto_profilo"];
if(!str_starts_with($utente["foto_profilo"], "http" ) ){
    $avatarSrc = "/user_data/$utente[foto_profilo]";
}
if ($utente["foto_profilo"]==NULL) $avatarSrc = NULL;
$description = $utente["descrizione"];
$name = $utente["nickname"];
$infos = array(
    $utente["nome_citta"] ? '<i class="bi bi-geo-alt-fill" style="margin-right:5px"></i>'.$utente["nome_citta"] : "",
    '<i class="bi bi-envelope-fill" style="margin-right:5px""></i>'.$utente["mail"]
);
$imgs = array();
    
  


require_once "profilo_template.php";
?>