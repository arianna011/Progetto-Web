<!DOCTYPE html>
<html lang="it">
<html>

<head>
    <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>Prova</title>
  
  <link rel="stylesheet" href="/bootstrap/scss/bootstrap.css" />
  <link rel="stylesheet" href="/bootstrap-icons-1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/pages/common/style.css" />
  <link rel="stylesheet" href="/pages/homepage/homepage.css" />
  <script src="/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/pages/homepage/jquery.js"></script>
  <script src="/pages/homepage/animations.js"></script>
</head>

<body>

<form action="modifica_immagine.php" method="post" enctype="multipart/form-data">
  Select image to upload:
  <input type="file" name="fileToUpload" id="fileToUpload">
  <input type="submit" value="Upload Image" name="submit">
</form>


</body>

</html>