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
   <div class="col-12 position-relative" style="background: url('../../../site_images/login.jpg') no-repeat; background-size: cover; height:300px;">
     <h1 class="text-center text-white position-absolute start-50 translate-middle-x bottom-0 big " >Accedi a NotaMi</h1>
   </div>
    <br>
    <h2 class="text-purple text-center m-3"> <i class="bi bi-person-lines-fill"></i> Registrazione </h2>
        <p class="text-center">Registrati per creare un profilo host, band o artista e ottenere la possibilità di scrivere recensioni.</p>

    <br>

    <form class="row g-3 px-3" method="POST">
        <h4 class="text-orange">Dati personali </h4>
        <div class="col-md-6">
            <label for="inputName" class="form-label">Nome</label>
            <input type="text" class="form-control" id="inputName" name="nome" maxlength="20" placeholder="Inserisci il tuo nome">
        </div>
        <div class="col-md-6">
            <label for="inputSurname" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="inputSurname" name="cognome" maxlength="20" placeholder="Inserisci il tuo cognome">
        </div>
        <div class="col-md-6">
            <label for="inputBirthdate" class="form-label">Data di nascita</label>
            <input type="date" class="form-control" id="inputBirthdate" name="datanascita">
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Città di residenza</label>
            <select class="form-select" name="citta" id="inputCity">
                <option selected>Seleziona la tua città</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
        </select>
        </div>
        <h4 class="text-orange mt-4">Dati account </h4>
       
        <div class="col-12"> 
            <label for="inputNick" class="form-label">Nickname</label>
            <div class="input-group">
            <span class="input-group-text">@</span>
            <input type="text" class="form-control" id="inputNick" name="nickname" placeholder="Nickname" maxlength="15">
            </div>
            <div class="form-text">Scegli un nickname non ancora in uso</div>
        </div>
        <div class="col-md-6">
            
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="inputEmail" maxlength="64" placeholder="Inserisci la tua email">
        </div>
        <div class="col-md-6">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword" minlength="8" maxlength="15" placeholder="Crea una password">
            <div class="form-text">La password deve contenere almeno 8 caratteri</div>
        </div>
    
        foto profilo
        bio
  
  <div class="col-12">
    <button type="submit" class="btn btn-primary">Invia</button>
  </div>
</form>
 
  
  <br>

  <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include '../common/footer.php' ?>
  </footer>

</body>

</html>