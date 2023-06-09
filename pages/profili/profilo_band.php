<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/common/util.php';

#pagina rappresentante il profilo di una band (formata da più artisti)

//controllo che l'id (della band) sia presente
if (!isset($_GET['id'])) {
    echo "id band non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT *
FROM v_profilo_band
WHERE id_band = $1";

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

#controllo che sia presente almeno un risultato
$row = pg_fetch_assoc($result);
if (!$row) {
    echo "band non trovata: " . pg_last_error($dbconn);
    exit;
}

#preparo le variabili da usare nel template

if ($row["valutazione_media"] == NULL)
    $valutazione = 0;
else
    $valutazione = $row["valutazione_media"];
$avatarSrc = $row["foto_profilo"];
$description = $row["descrizione"];
$name = $row["nome_band"];
$infos = [
    $row["sede"] ? '<i class="bi bi-geo-alt-fill" style="margin-right:5px"></i>' . $row["sede"] : "",
    "<h3>{$row["min_prezzo"]} - {$row["max_prezzo"]} €</h3>",
    toStars($valutazione),
    toBadges($row["generi_musicali"], "bg-info"),
    toBadges($row["servizi_forniti"], "bg-danger"),
];
$imgs = array();
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
        }

        @media screen and (min-width: 769px) {
            .search-card {
                max-height: 30vh;
            }
        }
    </style>
</head>

<body>
    <header class="bg-purple">
        <?php include '../common/navbar.php' ?>
    </header>

    <?php
    #invoco il template
    require_once "profilo_template.php";


    #da qui in poi ci si occupa della lista membri della band
    /*query per prendere i membri della band*/
    $query = "
        SELECT *
        FROM v_membro_band
        WHERE id_band = $1";

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


    //pg_close($dbconn); //il risultato ce l'ho, posso anche chiudere :T
    
    ?>

    <h2 style="margin: 0 40px 0 40px "> Membri </h2>
    <div class="lista-membri" style="margin: 30px 10px 50px 10px;">


        <?php
        #controllo che sia presente almeno un risultato        
        $row = pg_fetch_assoc($result);
        if (!$row) {
            echo "nessun membro trovato: " . pg_last_error($dbconn);
            exit;
        }

        #stampo i dati per ogni risultato trovato nel database
        while ($row) {

            #preparo le variabili da usare nel template
            $title = $row["nome"];
            $img = $row["foto_profilo"] ?? "../../site_images/placeholder_profile.jpg";
            $infos1 = [
                isset($row["valutazione_media"]) ?
                toStars($row["valutazione_media"]) : (
                    isset($row["id_profilo"]) ?
                    "<div class='text-grey' style='font-weight:50'> nessuna valutazione </div>" :
                    "<div class='text-grey' style='font-weight:50'> membro non registrato </div>"
                ),
                toBadges("[{$row['ruolo']}]", "bg-secondary")
            ];
            $infos2 = [];
            if (isset($row["id_profilo"])) {
                array_push(
                    $infos2,
                    "<a href='/pages/profili/profilo.php?id=" . $row["id_profilo"] . "' class='btn btn-primary'> Vedi profilo </a>"
                );
            }

            #invoco il template        
            include("searchcard_template.php");

            #faccio il fetch del prossimo risultato
            $row = pg_fetch_array($result);
        }
        ?>
    </div>
    
    <?php
    #sezione recensioni
    include $_SERVER['DOCUMENT_ROOT'] . '/pages/recensioni/recensioni_band.php';
    ?>

    <footer class="bg-purple">
        <?php include '../common/footer.php' ?>
    </footer>


</body>

</html>