
<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/connection.php';
?>
<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NotaMi</title>
  
  <link rel="stylesheet" href="/bootstrap/scss/bootstrap.css" />
  <link rel="stylesheet" href="/bootstrap-icons-1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/pages/common/style.css" />
  <script src="/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  </head>

<body class="bg-beige">

   <header class="bg-purple">
     <?php include '../../common/navbar.php' ?>
   </header>



<form class="container mb-5" id="caricaProfiloUtente"  method="POST" enctype="multipart/form-data" action="./carica_immagine.php?id=<?=$_GET["id"]?>&ptype=<?=$_GET["ptype"]?>">
  <h4 class="text-orange mt-4 mb-4">Modifica immagine </h4>
  <div class="col-md-6"> 
  <label class="form-label" for="profiloUtente"> Immagine Profilo Utente </label>
      <div class="input-group">
      <input type="file" class="form-control" id="profiloUtente" name="profiloUtente">
      <input type="submit" class="btn btn-outline-secondary" name="caricaProfiloUtente">
      </div>
      <div class="form-text">Scegli un'immagine di dimensione minima 200 x 200 pixel</div>
          
  </div>
</form>

<footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include '../../common/footer.php' ?>
</footer>

</body>