<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/common/util.php';



//controllo che l'id sia presente
if (!isset($_GET['id'])) {
    echo "id locale non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT *
FROM v_profilo_locale
WHERE id_locale = $1";

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

$row = pg_fetch_assoc($result);
if (!$row) {
    echo "locale non trovato: " . pg_last_error($dbconn);
    exit;
}


$avatarSrc = $row["foto_profilo"];
$description = $row["descrizione_locale"];
$name = $row["nome_locale"];

$indirizzo =$row["indirizzo"];
$citta = $row["nome_citta"];

$infos = [
    isset($indirizzo) || isset($citta) ? "<i class='bi bi-geo-alt-fill' style='margin-right:5px'></i>" . ($citta ?? "") . ", " . ($indirizzo ?? "") : "",
    toStars($row["valutazione_media"]),
    "<i class='bi bi-person-circle'style='margin-right:5px'></i>
     <a href = 'profilo.php?id={$row['id_titolare']}'>{$row['titolare']} </a>"
];
$imgs = fromPgArray($row["foto_galleria"]);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .search-card {
            margin: 20px;
            max-height: 30vh;
        }
    </style>
</head>

<body>
    <header class="bg-purple">
        <?php include '../common/navbar.php' ?>
    </header>

    <?php
    require_once "profilo_template.php";

    /*     include $_SERVER['DOCUMENT_ROOT'] . '/pages/recensioni/recensioni_locale.php'; */
    ?>

    <footer class="bg-purple">
        <?php include '../common/footer.php' ?>
    </footer>


</body>

</html>