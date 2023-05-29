<!DOCTYPE html>
<html lang="en">
<head>
    <!-- questa pagina raccoglie le informazioni delle due pagine "ingaggi_per_utente.php" e "locali_per_utente.php" -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script>
        //le due pagine vengono caricate in maniera asincrona dentro appositi div
        $(document).ready(function () {
            $(".locali").load("locali_per_utente.php?id=<?php echo $_GET['id'] ?>", function (responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });
            $(".ingaggi").load("ingaggi_per_utente.php?id=<?php echo $_GET['id'] ?>", function (responseTxt, statusTxt, xhr) {
                if (statusTxt == "error")
                    alert("Error: " + xhr.status + ": " + xhr.statusText);
            });
        });

    </script>
</head>
<body>
    <div class="locali">

    </div>
    <div class="ingaggi">

    </div>
    
</body>
</html>