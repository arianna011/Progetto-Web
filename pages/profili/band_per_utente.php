<?php
#pagina rappresentante l'elenco delle band di cui un certo utente è membro

require_once $_SERVER['DOCUMENT_ROOT'] . '/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/common/util.php';



//controllo che l'id sia presente
if (!isset($_GET['id'])) {
    echo "id utente non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

#prendo tutte le band aventi l'id specificato in query string
//uso di prepared statement per prevenire SQL injection
$query = "
SELECT *
FROM v_band_per_artista
WHERE id_profilo = $1";

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Band per utente</title>
</head>
<style>
    .band-list {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .search-card {
        margin: 20px;
    }

    @media screen and (min-width: 769px) {
        .search-card {
            max-height: 30vh;
        }
    }
</style>

<body>
    <div class="main" style="padding: 30px">
        <h1 style="margin: 40px 40px 0px 0px">Band di cui faccio parte</h1>
        <div class="band-list" style="margin: 30px 10px 50px 10px">
            <?php
            #controllo che sia presente almeno un risultato
            $row = pg_fetch_assoc($result);
            if (!$row) {
                echo "nessuna band trovata " . pg_last_error($dbconn);
                exit;
            }

            #stampo i dati per ogni risultato trovato nel database
            while ($row) {
                #preparo le variabili da usare nel template
                $title = $row["nome_band"];
                $img = $row["foto_profilo"] ?? "../../site_images/placeholder-image.jpg";
                $infos1 = [
                    isset($row["valutazione_media"]) ?
                    toStars($row["valutazione_media"]) :
                    "<div class='text-grey' style='font-weight:50'> nessuna valutazione </div>",
                    toBadges("[{$row['ruolo']}]", "bg-secondary")
                ];
                $infos2 = [
                    "<a href='/pages/profili/profilo_band.php?id=" . $row["id_band"] . "' class='btn btn-primary'> Vedi profilo </a>"
                ];

                #invoco il template
                include("searchcard_template.php");
                
                #faccio il fetch del prossimo risultato
                $row = pg_fetch_array($result);
            }
            ?>
        </div>
    </div>
</body>

</html>