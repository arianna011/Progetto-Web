<?php
#pagina rappresentante il profilo artista di un utente (contiene tutte le informazioni relative alla sua attività artistica)
$isProfiloArtista = true;
require_once $_SERVER['DOCUMENT_ROOT'] . '/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/common/util.php';

//controllo che l'id sia presente
if (!isset($_GET['id'])) {
    echo "id utente non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

#NB: profilo utente e profilo artista condividono lo stesso id sul database!

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT *
FROM v_profilo_artista
WHERE id_artista = $1";

$result = pg_prepare($dbconn, "", $query);
if (!$result) {
    echo pg_last_error($dbconn);
    exit;
}

$result = pg_execute($dbconn, "", array($id));
if (!$result) {
    echo pg_last_error($dbconn);
    exit;
}

#controllo che ci sia effettivamente un profilo artista associato all'id utente corrente. Se assente mostra un bottone per crearne uno
$row = pg_fetch_assoc($result);
if (!$row) {
    echo '<div class="mt-0 p-4 bg-grey"> <a class="btn btn-primary" href="/pages/profili/modifiche/crea_profilo_artista.php?id=' . $id . '" type="button"> <i class="bi bi-pencil-square"></i> Crea profilo artista </a> </div> </div>';
    exit;
}

//controlli per verificare che l'utente abbia fatto il login
if (isset($_COOKIE["univoco"]))
    $univoco = $_COOKIE["univoco"];
else
    $univoco = "";

$check_utente = "select * from profilo_utente where id_utente = " . $row["id_artista"] . " and univoco = '" . $univoco . "'";
$result = pg_fetch_row(pg_query($dbconn, $check_utente));

if ($result)
    $isUtente = true;
else
    $isUtente = false;


pg_close($dbconn);

#preparo le variabili da usare nel template (con appositi nullcheck)
$id = $row["id_artista"];
$avatarSrc = $row["foto_profilo"];
if (!str_starts_with($row["foto_profilo"], "http")) {
    $avatarSrc = "/user_data/$row[foto_profilo]";
}
if ($row["foto_profilo"] == NULL)
    $avatarSrc = NULL;
$description = $row["descrizione"];
$name = $row["nome"];
if ($row["valutazione_media"] == NULL)
    $valutazione = 0;
else
    $valutazione = $row["valutazione_media"];
$infos = [
    $row["nome_citta"] ? '<i class="bi bi-geo-alt-fill" style="margin-right:5px"></i>' . $row["nome_citta"] : "",
    "<h3>{$row["min_prezzo"]} - {$row["max_prezzo"]} €</h3>",
    toStars($valutazione),
    toBadges($row["strumenti_musicali"], "bg-secondary"),
    toBadges($row["generi_musicali"], "bg-info"),
    toBadges($row["servizi_forniti"], "bg-danger"),
];
$imgs = fromPgArray($row["foto_galleria"]);


#invoco il template
require_once "profilo_template.php";

#recensioni utente
include $_SERVER['DOCUMENT_ROOT'] . '/pages/recensioni/recensioni.php';
?>