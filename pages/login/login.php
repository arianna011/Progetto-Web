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
    <?php include '../common/navbar.php' ?>
  </header>
  <div class="position-relative" style="background: url('../../../site_images/login.jpg') no-repeat; background-size: cover; height:300px;">
    <h1 class="text-center text-white position-absolute start-50 translate-middle-x bottom-0 big " >Accedi a NotaMi</h1>
  </div>

  <div class="container">
  <div class="row m-2">
    <div class="col m-3 p-3">
      <form name="login" action="login.php" method="POST" class="form-signin m-auto" >
      
      <h2 class="text-purple mb-3"><i class="bi bi-person-circle"></i> <span class="ms-1"> Login </span></h2>
      <span>Inserisci i tuoi dati per accedere al profilo personale.</span>

      <br><br>
        
      <input type="email" placeholder="Indirizzo e-mail" name="inputEmail" max-length="80"
            class="form-control" required autofocus>
    
      <input type="password" placeholder="Password" name="inputPassword"
            class="form-control" required>
        
      <br>
      <button type="submit" class="btn btn-primary">Accedi</button>
  
    </form>
    </div>
    
    <div class="d-none d-md-block col m-3 p-3">
    <h2 class="text-purple mb-3"> <i class="bi bi-person-exclamation"></i> Non hai ancora un account?</h2>
      <div class="mb-4">Registrati per gestire un profilo host, band o artista e ottenere la possibilità di scrivere recensioni.</div>
        <a href="/pages/login/registration.php" class="btn btn-primary">Registrati</a>
    </div>
  </div>
  
  <div class="d-block d-md-none col m-3 p-3">
    <h2 class="text-purple mb-3"><i class="bi bi-person-exclamation"></i> Non hai ancora un account?</h2>
        <div class="mb-2">Registrati per gestire un profilo host, band o artista e ottenere la possibilità di scrivere recensioni.</div>
        <br>
        <a href="/pages/login/registration.php" class="btn btn-primary">Registrati</a>
  </div>
  
 </div>

  <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include '../common/footer.php' ?>
  </footer>

</body>

</html>