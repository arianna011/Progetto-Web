
<?php 
  include '../../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../bootstrap/scss/bootstrap.css" >
    <link rel="stylesheet" href="../../../bootstrap-icons-1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../common/style.css">
    <link rel="stylesheet" href="../style_vetrine.css">
    <script src="../../../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Artisti</title>

</head>
<body class="bg-beige">
 <header>
  <?php include '../../common/navbar.php'; ?>
  </header>
  <div class="col-12" id="cover"  style="background: url('../../../site_images/guitar.jpg') no-repeat; background-size: cover; height:500px;">
          <h1 class="text-center align-bottom text-white " >Artisti</h2>
  </div>
  <div class="container-fed">

    <div class= "row align-items-start" id="row2">
        <div class="col-3">
        <form class="row g-2" method="post" id="search-form">
        <div class="col-auto">
          <input type="search" class="form-control" id="inputsearch" placeholder="Cerca" name="search">
        </div>
        <div class="col-auto">
          <button type="submit" id='search' class="btn btn-secondary mb-3">
          <i class="bi bi-search" style="color: #640062" ></i>
          </button>
        </div>
        </form>
          <select class="form-select" id="citta">
          <option value="0" selected>Seleziona una città</option>
          <?php
            $query = "SELECT * FROM citta";
            $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
            $citta = pg_fetch_all($result);
            foreach ($citta as $c) {
              ?> 
              <option value="<?= $c['id_citta']; ?>"> <?= $c['nome_citta']; ?> </option>
              <?php
            }
          ?>
          </select>
          <div class="form-check m-2">
            <input class="form-check-input" type="radio" name="ordine" id="radio1"  value="recenti" checked>
            <label class="form-check-label" for="radio1"> Più recenti </label>
          </div>
          <div class="form-check m-2">
            <input class="form-check-input" type="radio" name="ordine" id="radio2"  value="migliori">
            <label class="form-chekc-label" for="radio2"> Migliori valutazioni</label>
          </div>
          <div class="form-check m-2">
            <input class="form-check-input" type="radio" name="ordine" id="radio3"  value="prezzo">
            <label class="form-chekc-label" for="radio3"> Più economici </label>
          </div>
          <div class="accordion" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    Filtra per strumento
                </button>
                </h2>
                <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="section-fed" id="sez_1">
                      <?php
                          $query = "SELECT * FROM strumento_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $generi = pg_fetch_all($result);
                          foreach ($generi as $genere) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="strumento" id="<?= $genere['id_strumento']; ?>" value="<?= $genere['nome_strumento']; ?>" />
                            <label class="form-check-label" for="<?= $genere['id_strumento']; ?>"> <?= $genere['nome_strumento']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>
                    </div>
                  </div>
                </div>
              </div>
           </div>

            <div class="accordion" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseOne">
                    Filtra per genere
                  </button>
                </h2>
                <div id="flush-collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="section-fed" >
                      <?php
                          $query = "SELECT * FROM genere_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $generi = pg_fetch_all($result);
                          foreach ($generi as $genere) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="genere" id="<?= $genere['id_genere']; ?>" value="<?= $genere['nome_genere']; ?>" />
                            <label class="form-check-label" for="<?= $genere['id_genere']; ?>"> <?= $genere['nome_genere']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>
                    </div>
                  </div>  
                </div>
              </div>
            </div>
            <div class="accordion" id="accordionFlushExample">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseOne">
                    Filtra per servizi offerti
                  </button>
                </h2>
                <div id="flush-collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <div class="section-fed" >
                      <?php
                          $query = "SELECT * FROM servizio_musicale";
                          $result = pg_query($dbconn, $query) or die('Query failed: ' . pg_last_error());
                          $servizi = pg_fetch_all($result);
                          foreach ($servizi as $servizio) {
                            ?> 
                            <div class="form-check form-check-inline" >
                            <input class="form-check-input" type="checkbox" name="servizio" id="<?= $servizio['id_servizio'] ?>" value="<?= $servizio['nome_servizio']; ?>" />
                            <label class="form-check-label" for="<?= $servizio['id_servizio']; ?>"> <?= $servizio['nome_servizio']; ?> </label>
                            </div>
                            <?php
                          }
                      
                      ?>
                    </div>
                  </div>  
                </div>
              </div>
            </div>

         </div>
        <div class="col-9" id="pull_data"></div>
    </div>
  </div>


<footer>
<?php include('../../common/footer.php'); ?>
</footer>

<script>

let ordine ;
let strumenti = new Array();
let generi = new Array();
let search;
let citta;
let servizi = new Array();


function fetch_data(page){
  $.ajax({
    url:"./fetch_artisti.php",
    method:"POST",
    data:{page:page, search:search, ordine:ordine, strumenti:strumenti, generi:generi, citta:citta, servizi:servizi},
    success:function(data){
      $('#pull_data').html(data);
    }
  })
};

fetch_data();

$(document).on('click', '.page-item', function(){
  let page = $(this).attr("id");
  //let search = $('#inputsearch').val();
  fetch_data(page);
});

$("#search-form").submit(function(event) {
  search = $('#inputsearch').val();
  fetch_data(1);
  event.preventDefault();
});

$(".form-select").change(function() {
  if($(this).val() == "Seleziona una città"){
    citta = NULL;
  }else {
  citta = $(this).val();
  }
  fetch_data(1);
});

document.getElementsByName("ordine").forEach(function(element) {
  element.addEventListener('click', function() {
    ordine = $(this).val();
    //let search = $('#inputsearch').val();
    fetch_data(1);
  });
});

document.getElementsByName("strumento").forEach(function(element) {
  element.addEventListener('change', function() {
    //let search = $('#inputsearch').val();
    if(this.checked){
    strumenti.push($(this).val());
    fetch_data(1);
    }
    else{
      strumenti.splice(strumenti.indexOf($(this).val()), 1);
      fetch_data(1);
    }
  });
});


document.getElementsByName("genere").forEach(function(element) {
  element.addEventListener('change', function() {
    if(this.checked) {
      generi.push($(this).val());
      fetch_data(1);
    } else {
      generi.splice(generi.indexOf($(this).val()), 1);
      fetch_data(1);
    }
  });
});

document.getElementsByName("servizio").forEach(function(element) {
  element.addEventListener('change', function() {
    if(this.checked) {
      servizi.push($(this).val());
      fetch_data(1);
    } else {
      servizi.splice(servizi.indexOf($(this).val()), 1);
      fetch_data(1);
    }
  });
});

</script>
    

</body>
</html>