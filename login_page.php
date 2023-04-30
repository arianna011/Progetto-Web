<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NotaMi</title>
  
  <link rel="stylesheet" href="bootstrap/scss/bootstrap.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <script src="./bootstrap/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body class="bg-beige">

  <header class="bg-purple">
    <?php include 'navbar.php' ?>
  </header>

  <div class="row">
    <div class="col m-3">
      <form name="login" action="login.php" method="POST" class="form-signin m-auto" >
      
      <h2 class="text-purple mb-3">Login</h2>
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
    
    <div class="d-none d-md-block col m-3 p-3 purple-box" style="background: url('icons/login.png');">
    <h2 class="text-purple mb-3">Non hai ancora un account?</h2>
        <span>Registrati per gestire un profilo host, band o artista e ottenere la possibilità di scrivere recensioni.</span>

        <br><br>
        
        <a href="" class="btn btn-primary">Registrati</a>
    </div>
  </div>
  
  <div class="d-block d-md-none col m-3 p-3 purple-box" style="background: url('icons/login.png');">
    <h2 class="text-purple mb-3">Non hai ancora un account?</h2>
        <span>Registrati per gestire un profilo host, band o artista e ottenere la possibilità di scrivere recensioni.</span>

        <br><br>
        
        <a href="" class="btn btn-primary">Registrati</a>
  </div>
  
  <br>

  <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include 'footer.php' ?>
  </footer>

</body>

</html>