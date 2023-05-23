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
     <?php include '../common/navbar.php' ?>
   </header>

   <?php
        if(isset($GET_["id"])) {
            $id = $_GET["id"];
            $query = "SELECT * FROM v_profilo_utente WHERE id_utente = $id";
            }
        
   ?>
   <div class="container">
    <h2 class="text-purple text-center m-3 mt-4"> <i class="bi bi-pencil-square"></i> Modifica profilo </h2>
    <div class="mt-2 mb-2 p-3">
    
    <form id="modifica_profilo" class="row g-4 px-3 needs-validation" method="POST" action="./applica_modifica.php" novalidate>
        <h4 class="text-orange"> Dati utente </h4>
        <div class="col-md-6">
            <label for="inputName" class="form-label">Nome</label>
            <input type="text" class="form-control" id="inputName" name="nome" maxlength="20" placeholder="Inserisci il tuo nome" required>
            <div class="invalid-feedback">Campo obbligatorio </div>
        </div>
        <div class="col-md-6">
            <label for="inputSurname" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="inputSurname" name="cognome" maxlength="20" placeholder="Inserisci il tuo cognome" required>
            <div class="invalid-feedback">Campo obbligatorio </div>
        </div>
        <div class="col-md-6">
            <label for="inputBirthdate" class="form-label">Data di nascita </label>
            <input type="date" class="form-control" id="inputBirthdate" name="datanascita" required>
            <div class="invalid-feedback">Campo obbligatorio</div>
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label">Città di residenza <i class="text-grey"> Opzionale </i> </label>
            <select class="form-select" name="citta" id="inputCity">
                <option value='0' selected>Seleziona la tua città</option>
                <?php
                  $query = "SELECT * FROM citta Order by nome_citta ASC";
                  $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                  $citta = pg_fetch_all($result);
                  foreach ($citta as $c) {
                  echo '<option value = "', $c['id_citta'], '">', $c['nome_citta'], '</option>';
                  } ?>
        </select>
        </div>

        <div class="col-md-6"> 
            <label for="inputNick" class="form-label">Nickname</label>
            <div class="input-group has-validation">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control" id="inputNick" name="nickname" placeholder="Nickname" maxlength="15" required>
              <div class="invalid-feedback">Campo obbligatorio</div>
            </div>
            <div class="form-text">Scegli un nickname non ancora in uso</div>
           
        </div>
        <div class="col-md-6">
          
        </div>
        <div class="col-md-6">
            
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="inputEmail" maxlength="64" placeholder="Inserisci la tua email" required>
            <div class="invalid-feedback">Email non valida</div>
        </div>
        <div class="col-md-6">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword" minlength="8" maxlength="15" placeholder="Crea una password"  required>
            <div class="invalid-feedback">Password non valida </div>   
            <div class="form-text">La password deve contenere almeno 8 caratteri</div>   
        </div>
        <div class="col-12">
            <label for="inputBio" class="form-label">Bio  <i class="text-grey"> Opzionale </i> </label>
            <textarea class="form-control" name="bio" id="inputBio" maxlength="1024" placeholder="Scrivi qualcosa su di te..."></textarea>
        </div>
        <input id="controlla" name="controlla" type="hidden" value="si"/>
        <h4 class="text-orange mt-4">Dati artista </h4>
       
        <div class="col-md-6"> 
            <label for="inputNick" class="form-label">Nickname</label>
            <div class="input-group has-validation">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control" id="inputNick" name="nickname" placeholder="Nickname" maxlength="15" required>
              <div class="invalid-feedback">Campo obbligatorio</div>
            </div>
            <div class="form-text">Scegli un nickname non ancora in uso</div>
           
        </div>
        <div class="col-md-6">
          
        </div>
        <div class="col-md-6">
            
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="inputEmail" maxlength="64" placeholder="Inserisci la tua email" required>
            <div class="invalid-feedback">Email non valida</div>
        </div>
        <div class="col-md-6">
            <label for="inputPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="inputPassword" minlength="8" maxlength="15" placeholder="Crea una password"  required>
            <div class="invalid-feedback">Password non valida </div>   
            <div class="form-text">La password deve contenere almeno 8 caratteri</div>   
        </div>
        <div class="col-12">
            <label for="inputBio" class="form-label"> Descrizione  <i class="text-grey"> Opzionale </i> </label>
            <textarea class="form-control" name="bio" id="inputBio" maxlength="1024" placeholder="Scrivi qualcosa su di te..."></textarea>
        </div>
        <input id="controlla" name="controlla" type="hidden" value="si"/>
      
      <div class="col-12 text-center">
        <button type="submit" name="applica" class="btn btn-primary">Applica modifiche</button>
        <button type="submit" name="annulla" class="btn btn-secondary">Annulla modifiche</button>
      </div>
    </form>
    <script src="formValidation.js"></script> 

    <?php include './modifica_immagine.php' ?>

    <?php 
      if (isset($_GET["erroreCaratteri"]))
        echo '<script> alert ("Sono stati usati caratteri non permessi"); </script>';
      if (isset($_GET["erroreMail"]))
          echo '<script> alert ("La mail inserita non è valida"); </script>';
      if (isset($_GET["erroreData"]))
        echo '<script> alert ("La data di nascita inserita non è valida"); </script>';
      if (isset($_GET["errorePropic"]))
          echo '<script> alert ("L\'immagine profilo fornita non è valida"); </script>';
      if (isset($_GET["mailUsata"]))
        echo '<script> alert ("Esiste già un account registrato con l\'email fornita"); </script>';
      if (isset($_GET["nickUsato"]))
        echo '<script> alert ("Il nickname fornito è già in uso"); </script>';
    ?>
    </div>
    </div>
  <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include '../common/footer.php' ?>
  </footer>

</body>

</html>