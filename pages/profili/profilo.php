<?php include('../../connection.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profilo</title>

    <style>
        .bookmarks,
        .bookmarks * {
            margin: 10px;
            padding: 10px;
        }

        /*segnalibri*/
        .bookmarks {

            display: flex;
            flex-direction: row;
            align-items: stretch;
            padding: 0;
            margin-bottom: 0;
        }

        .bookmarks>div {
            background-color: #b37cb28e;

            margin-bottom: 0;
            margin-left: 0;
            margin-right: 3px;
            margin-top: 30px;


            flex: 1 0 0;
            /*permetti agli item di crescere/decrescere perchè abbiano tutti stessa grandezza*/
            border-radius: 10px 10px 0 0;

            cursor: pointer;

            transition: margin-top .2s ease-in-out;
            /*tutte le transizioni sull'elemento margin-top hanno 2 secondi di tempo e quel tipo di animazione*/
        }

        .bookmarks>div:last-child {
            margin-right: 0;
        }

        .bookmarks>div:hover {
            margin-top: 0px;
        }

        .bookmarks>div.active-tab {
            background-color: whitesmoke;
        }

        .badge {
            margin-right: 2px;
        }
    </style>

    <link rel="stylesheet" href="/bootstrap/scss/bootstrap.css" />
    <link rel="stylesheet" href="/pages/common/style.css" />
    <link rel="stylesheet" href="../../../bootstrap-icons-1.10.4/font/bootstrap-icons.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>

        function loadInPage(navSelector, pathToLoad) {
            $("#nav-tab-content").load(pathToLoad, function (responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });
            $(".bookmarks>div").removeClass("active-tab");
            $(navSelector).addClass("active-tab");
        }


        $(document).ready(function () {

            //in php è facilissimo ottenere i parametri in query string, con jquery è un po più verboso, anche se lato client
            id = <?php echo $_GET['id'] ?>;
            initialTabId = <?php echo $_GET['ptype']  ?? 1; ?> - 1; //se ptype non è specificato, carica il proflo utente per default


            //Aggiungere azioni qui vvvvv
            let actionLookup = new Map([
                ["#nav-utente", 'profilo_utente.php?id=' + id],
                ["#nav-artista", 'profilo_artista.php?id=' + id],
                ["#nav-band", 'band_per_utente.php?id=' + id],
                ["#nav-locali", 'locali_per_utente.php?id=' + id]
            ]);

            for (const [selector, action] of actionLookup) {
                $(selector).click(function () {
                    loadInPage(selector, action)
                });
            }

            initialTab = Array.from(actionLookup.keys())[initialTabId];

            loadInPage(initialTab, actionLookup.get(initialTab));
        });


    </script>
</head>

<body class="bg-beige">

    <header class="bg-purple">
        <?php include '../common/navbar.php' ?>
    </header>

    <div class="bookmarks">
        <div id="nav-utente">Profilo utente</div>
        <div id="nav-artista">Profilo artista</div>
        <div id="nav-band">Band</div>
        <div id="nav-locali">Locali</div>
    </div>

    <div id="nav-tab-content" style="background-color: whitesmoke; margin: 0 10px 10px 10px">
        <h3 style='padding: 30px; font-size=large;'>Link non valido :T</h3> 
    </div>
    <footer class="bg-purple">
        <?php include '../common/footer.php' ?>
    </footer>


</body>

</html>