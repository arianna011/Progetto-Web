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
     <?php include '../../common/navbar.php' ?>
   </header>

<?php
            
    $id = $_GET["id"];        
            $query_2 = "SELECT * FROM profilo_artista WHERE id_artista = $id";
            $row_art = pg_fetch_assoc(pg_query($dbconn, $query_2));
            $query_3 = "SELECT * FROM v_profilo_artista WHERE id_artista = $id";
            $row_art_2 = pg_fetch_assoc(pg_query($dbconn, $query_3));
        ?>
        <div class="container">
        <h2 class="text-purple text-center m-3 mt-4"> <i class="bi bi-pencil-square"></i> Modifica profilo artista </h2>
        <div class="mt-2 mb-2 p-3">
        
        <?php echo '<form id="modifica_profilo_artista" class="row g-4 px-3" method="POST" action="./applica_modifica_artista.php?id=', $id, '">' ?>
        <h4 class="text-orange">Dati artista </h4>
        <div class="col-md-6"> 
            <label for="inputNomedarte" class="form-label">Nome d'arte</label>
            <div class="input-group">
              <span class="input-group-text"> <i class="bi bi-music-note-beamed"></i> </span>
              <input type="text" class="form-control" id="inputNomedarte" name="nickname" placeholder="Nome d'arte" maxlength="15"  value="<?= $row_art["nomedarte"]?>" >
            </div>
            <div class="form-text">Scegli un nome non ancora in uso, in alternativa saranno utilizzati nome e cognome o il tuo nickname </div>
           
        </div>
        <div class="col-12">
          <p class="mb-1 text-purple"> Strumenti musicali </p>
          <div class="form-text"> Seleziona gli strumenti che suoni </div>
          <div class="section-checkboxes pt-3">
          <?php
                            $query = "SELECT * FROM strumento_musicale";
                            $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                            $strumenti = pg_fetch_all($result);
                            foreach ($strumenti as $strumento) {
                              ?> 
                              <div class="form-check form-check-inline" >
                              <input class="form-check-input" type="checkbox" name="strumenti[]" id="<?= $strumento['id_strumento']; ?>" value="<?= $strumento['id_strumento']; ?>" 
                              <?php if(str_contains($row_art_2["strumenti_musicali"], $strumento['nome_strumento']))echo "checked";?>/>
                              <label class="form-check-label" for="<?= $strumento['id_strumento']; ?>"> <?= $strumento['nome_strumento']; ?> </label>
                              </div>
                              <?php
                            }
                        
                        ?>

          </div>
        </div>

        <div class="col-12">
        <p class="mb-1 text-purple"> Generi musicali </p>
          <div class="form-text"> Seleziona i generi che suoni </div>
          <div class="section-checkboxes pt-3">
          <?php
                          $query = "SELECT * FROM genere_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $generi = pg_fetch_all($result);
                          foreach ($generi as $genere) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="genere[]" id="<?= $genere['id_genere']; ?>" value="<?= $genere['id_genere']; ?>"
                            <?php if(str_contains($row_art_2["generi_musicali"], $genere['nome_genere']))echo "checked";?>/>
                            <label class="form-check-label" for="<?= $genere['id_genere']; ?>"> <?= $genere['nome_genere']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>


          </div>
        </div>

        <div class="col-12">
        <p class="mb-1 text-purple"> Servizi offerti </p>
          <div class="form-text"> Seleziona i servizi che vuoi offrire </div>
          <div class="section-checkboxes pt-3">
          <?php
                          $query = "SELECT * FROM servizio_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $servizi = pg_fetch_all($result);
                          foreach ($servizi as $servizio) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="servizio[]" id="<?= $servizio['id_servizio'] ?>" value="<?= $servizio['id_servizio']; ?>" 
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
        <?php echo '<a href="../profilo.php?ptype=2&id=', $id,'"type="submit" name="annulla" class="btn btn-secondary m-2">Annulla modifiche</a>' ?>
      </div>
    </form>
                        </div>
                        </div>
    <script src="formValidation.js"></script> 
    <?php if (isset($_GET["erroreCaratteri"]))
        echo '<script> alert ("Sono stati usati caratteri non permessi"); </script>'; 
        if (isset($_GET["errorePrezzi1"]))
        echo '<script> alert ("Il prezzo minimo deve essere minore o uguale al prezzo massimo"); </script>';
        if (isset($_GET["errorePrezzi2"]))
        echo '<script> alert ("Specificare sia il prezzo minimo che il prezzo massimo"); </script>'; ?>

    <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include '../../common/footer.php' ?>
  </footer>

</body>

</html>