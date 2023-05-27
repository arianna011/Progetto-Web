<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/pages/common/util.php';



//controllo che l'id sia presente
if (!isset($_GET['id'])) {
    echo "id utente non presente. Assicurati di aver raggiunto questa pagina tramite un link valido";
    exit;
}
$id = $_GET['id'];

//uso di prepared statement per prevenire SQL injection (si spera)
$query = "
SELECT *
FROM v_ingaggio
LEFT JOIN Citta USING(id_citta)
WHERE id_datore = $1
";


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
    .lista-ingaggi {
        display: flex;
        flex-direction: column;
        align-items: stretch;
    }

    .search-card {
        margin: 20px;
    }

    @media screen and (min-width: 769px) {
        .search-card {
            max-height: none;
        }
        .s-info1>div{
            margin-bottom: 10px;
        }
    }
</style>

<link rel="stylesheet" href="../homepage/homepage.css" >

<body>
    <div class="main" style="padding: 30px">
        <h1 style="margin: 40px 40px 0px 0px">Ingaggi disponibili</h1>
        <div class="lista-ingaggi" style="margin: 30px 10px 50px 10px">
            <?php
            $row = pg_fetch_assoc($result);
            if (!$row) {
                echo "nessun ingaggio trovato; " . pg_last_error($dbconn);
                exit;
            }

            while ($row) {
                $title = '<div class="text-purple">' . $row["titolo"] . '</div>';

                $img = $row["immagine"] ?? "../../site_images/placeholder-image.jpg";
                $infos1 = [
                    '<p class="card-text showcase-date mx-2">' . $row["data_ingaggio"] . ($row["ora_inizio"] ? "," . $row["ora_inizio"] . " - " . $row["ora_fine"] : "")  . '</p>',
                    $row["compenso_indicativo"] ? '<span class = "showcase-retr mb-3">' . $row["compenso_indicativo"] . " € </span>" : "<span class='text-grey' style = 'font-style: italic;'> compenso non specificato </span>",
                    
                    $row["indirizzo"] && $row["nome_citta"] ? 
                        $row["indirizzo"] . ", " . $row["nome_citta"]
                    : $row["nome_citta"] ?? "",

                    $row["descrizione"]
                ];
                $infos2 = [
                    "<a href='/pages/profili/profilo_locale.php?id=" . $row["id_ingaggio"] . "' class='btn btn-primary'> Vedi profilo </a>"
                ];

                include("searchcard_template.php");
                $row = pg_fetch_array($result);
            }
            ?>
        </div>
    </div>
</body>

</html>