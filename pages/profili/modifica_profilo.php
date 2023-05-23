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

  <style>
    @media screen and (max-width: 767px) {
      .section-checkboxes {
        grid-template-columns: 1fr 1fr;
      }
    }

  </style>

</head>

<body class="bg-beige">

   <header class="bg-purple">
     <?php include '../common/navbar.php' ?>
   </header>

   <?php
        if(!isset($_GET["id"])) {
          exit("Errore: id non specificato");
        }else {
            $id = $_GET["id"];
            $query = "SELECT * FROM v_profilo_utente WHERE id_utente = $id";
            $row = pg_fetch_assoc(pg_query($dbconn, $query));
        }
        
   ?>
   <div class="container">
    <h2 class="text-purple text-center m-3 mt-4"> <i class="bi bi-pencil-square"></i> Modifica profilo </h2>
    <div class="mt-2 mb-2 p-3">
    
    <form id="modifica_profilo" class="row g-4 px-3 needs-validation" method="POST" action="./applica_modifica.php" novalidate>
        <h4 class="text-orange"> Dati utente </h4>
        <div class="col-md-6">
            <label for="inputName" class="form-label">Nome</label>
            <input type="text" class="form-control" id="inputName" name="nome" maxlength="20" placeholder="Inserisci il tuo nome" value="<?=$row["nome"]?>" required>
            <div class="invalid-feedback">Campo obbligatorio </div>
        </div>
        <div class="col-md-6">
            <label for="inputSurname" class="form-label">Cognome</label>
            <input type="text" class="form-control" id="inputSurname" name="cognome" maxlength="20" placeholder="Inserisci il tuo cognome" value="<?=$row["cognome"]?>" required>
            <div class="invalid-feedback">Campo obbligatorio </div>
        </div>
        <div class="col-md-6">
            <label for="inputBirthdate" class="form-label">Data di nascita </label>
            <input type="date" class="form-control" id="inputBirthdate" name="datanascita" value="<?=$row["datan"]?>" required>
            <div class="invalid-feedback">Campo obbligatorio</div>
        </div>
        <div class="col-md-6">
            <label for="inputCity" class="form-label" >Città di residenza <i class="text-grey"> Opzionale </i> </label>
            <select class="form-select" name="citta" id="inputCity">
                 <?php if($row["id_citta"] != null) { ?> 
                <option value="<?=$row["id_citta"]?>" selected> <?=$row["nome_citta"]?> </option>
                <?php } else { ?>
                <option value="0" selected> Seleziona la tua città </option>
                <?php } ?>
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
            <label for="inputNick" class="form-label" >Nickname</label>
            <div class="input-group has-validation">
              <span class="input-group-text">@</span>
              <input type="text" class="form-control" id="inputNick" name="nickname" placeholder="Nickname" maxlength="15" value="<?= $row["nickname"]?>" required>
              <div class="invalid-feedback">Campo obbligatorio</div>
            </div>
            <div class="form-text">Scegli un nickname non ancora in uso</div>
           
        </div>
        <div class="col-md-6">
          
        </div>
        <div class="col-md-6">
            
            <label for="inputEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="inputEmail" maxlength="64" placeholder="Inserisci la tua email" value="<?= $row["mail"]?>" required>
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
            <textarea class="form-control" name="bio" id="inputBio" maxlength="1024" placeholder="Scrivi qualcosa su di te..."> <?= $row["descrizione"] ?> </textarea>
        </div>
        <input id="controlla" name="controlla" type="hidden" value="si"/>


        <?php
            $query_2 = "SELECT * FROM profilo_artista WHERE id_artista = $id";
            $row_art = pg_fetch_assoc(pg_query($dbconn, $query_2));
            $query_3 = "SELECT * FROM v_profilo_artista WHERE id_artista = $id";
            $row_art_2 = pg_fetch_assoc(pg_query($dbconn, $query_3));
        ?>
        <h4 class="text-orange mt-4">Dati artista </h4>
       
        <div class="col-md-6"> 
            <label for="inputNomedarte" class="form-label">Nome d'arte</label>
            <div class="input-group has-validation">
              <span class="input-group-text"> <i class="bi bi-music-note-beamed"></i> </span>
              <input type="text" class="form-control" id="inputNomedarte" name="nickname" placeholder="Nome d'arte" maxlength="15"  value="<?= $row_art["nomedarte"]?>" >
            </div>
            <div class="form-text">Scegli un nome non ancora in uso, in alternativa saranno utilizzati nome e cognome o il tuo nickname </div>
           
        </div>
        <div class="col-12">
          <p class="mb-1"> Strumenti musicali </p>
          <div class="form-text"> Seleziona gli strumenti che suoni </div>
          <div class="section-checkboxes">
          <?php
                            $query = "SELECT * FROM strumento_musicale";
                            $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                            $strumenti = pg_fetch_all($result);
                            foreach ($strumenti as $strumento) {
                              ?> 
                              <div class="form-check form-check-inline" >
                              <input class="form-check-input" type="checkbox" name="strumento" id="<?= $strumento['id_strumento']; ?>" value="<?= $strumento['nome_strumento']; ?>" 
                              <?php if(str_contains($row_art_2["strumenti_musicali"], $strumento['nome_strumento']))echo "checked";?>/>
                              <label class="form-check-label" for="<?= $strumento['id_strumento']; ?>"> <?= $strumento['nome_strumento']; ?> </label>
                              </div>
                              <?php
                            }
                        
                        ?>

          </div>
        </div>

        <div class="col-12">
        <p class="mb-1"> Generi musicali </p>
          <div class="form-text"> Seleziona i generi che suoni </div>
          <div class="section-checkboxes">
          <?php
                          $query = "SELECT * FROM genere_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $generi = pg_fetch_all($result);
                          foreach ($generi as $genere) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="genere" id="<?= $genere['id_genere']; ?>" value="<?= $genere['nome_genere']; ?>"
                            <?php if(str_contains($row_art_2["generi_musicali"], $genere['nome_genere']))echo "checked";?>/>
                            <label class="form-check-label" for="<?= $genere['id_genere']; ?>"> <?= $genere['nome_genere']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>


          </div>
        </div>

        <div class="col-12">
        <p class="mb-1"> Servizi offerti </p>
          <div class="form-text"> Seleziona i servizi che vuoi offrire </div>
          <div class="section-checkboxes">
          <?php
                          $query = "SELECT * FROM servizio_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $servizi = pg_fetch_all($result);
                          foreach ($servizi as $servizio) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="servizio" id="<?= $servizio['id_servizio'] ?>" value="<?= $servizio['nome_servizio']; ?>" 
                            <?php if(str_contains($row_art_2["servizi_forniti"], $servizio['nome_servizio']))echo "checked";?>/>
                            <label class="form-check-label" for="<?= $servizio['id_servizio']; ?>"> <?= $servizio['nome_servizio']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>
          </div>
        </div>

        <p class="mb-0"> Range Prezzo </p>
        <div class="col-md-3 mt-1">
          <div class="form-text"> Prezzo minimo </div>
          <div class="input-group">
            <input type="number" class="form-control" id="minPrezzo" value="<?= $row_art_2["min_prezzo"]?>" name="minPrezzo" placeholder="Prezzo minimo" min="0" max="9999" aria-describedby="euro"/>
            <span class="input-group-text" id="euro"> <i class="bi bi-currency-euro"></i> </span>
          </div>
        </div>
        
        <div class="col-md-3 mt-1">
        <div class="form-text"> Prezzo massimo </div>
        <div class="input-group">
          <input type="number" class="form-control" id="maxPrezzo" value="<?= $row_art_2["max_prezzo"]?>" name="maxPrezzo" placeholder="Prezzo massimo" min="0" max="9999" aria-describedby="euro" />
          <span class="input-group-text" id="euro"> <i class="bi bi-currency-euro"></i> </span>
        </div>
        </div>

        

        <div class="col-12">
            <label for="inputDescrizione" class="form-label"> Descrizione  <i class="text-grey"> Opzionale </i> </label>
            <textarea class="form-control" name="bio" id="inputDescrizione" maxlength="1024" placeholder="Scrivi qualcosa su di te..."> <?= $row_art["descrizione"]?></textarea>
        </div>
        <input id="controlla" name="controlla" type="hidden" value="si"/>
      
      <div class="col-12 text-center">
        <button type="submit" name="applica" class="btn btn-primary m-2">Applica modifiche</button>
        <button type="submit" name="annulla" class="btn btn-secondary m-2">Annulla modifiche</button>
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