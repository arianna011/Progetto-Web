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
    <script src="../vetrine.js"></script>
    <title>Host</title>

</head>
<body class="bg-beige">
 <header>
  <?php include '../../common/navbar.php'; ?>
  </header>
  <!-- immagine copertina -->
  <div class="col-12 position-relative" id="cover"  style="background: url('../../../site_images/vetrina-host.jpg') no-repeat; background-size: cover; height:500px;">
          <h1 class="text-center text-white position-absolute start-50 translate-middle-x bottom-0 big " > Host </h1>
  </div>
  <div class="container cont-event p-3">

    <div class= "row align-items-start mt-4" id="row2">
        <!-- Colonna con i filtri di ricerca  -->
        <div class="col-3 width-100">
          <form class="row g-2" method="post" id="search-form">
          <div class="col-9">
            <input type="search" class="form-control" id="inputsearch" placeholder="Cerca" name="search">
          </div>
          <div class="col-3">
            <button type="submit" id='search' class="btn btn-secondary mb-3">
            <i class="bi bi-search" style="color: #640062" ></i>
            </button>
          </div>
          </form>
            <select class="form-select" id="citta">
            <option value="0" selected>Seleziona una città</option>
            <?php
              // estrazione delle città dal database
              $query = "SELECT * FROM citta Order by nome_citta ASC";
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
            <!-- mappa di google my maps per vedere i locali -->
            <div class="ratio ratio-1x1 m-2 mt-4 " id="iframe-container">
              <iframe src="https://www.google.com/maps/d/embed?mid=1vOuy-wYqzy1Yro3Jtp78XFdKmWWrXpU&hl=it&ehbc=2E312F" ></iframe>
            </div>
         </div>
         <!-- fine colonna filtri -->
         <!-- colonna risultati che saranno presi con la funzione fetch_data() definita nello script-->
        <div class="col-9 width-100" id="pull_data"></div>
    </div>
  </div>


<footer>
<?php include('../../common/footer.php'); ?>
</footer>

<script>
// inizializzo le variabili che serviranno per la ricerca
let ordine ;
let search;
let citta;

//funzione per prendere i dati da visualizzare 
function fetch_data(page){
  $.ajax({
    url:"./fetch_host.php",
    method:"GET",
    data:{page:page, search:search, ordine:ordine, citta:citta},
    success:function(data){
      $('#pull_data').html(data);
    }
  })
};
// chiamo una prima volta la funzione per visualizzare i risultati
fetch_data();
// questa funzione è definita in vetrine.js e serve per paginare i risultati
get_page();
// quando viene cliccato il bottone di ricerca assengno il valore dell'input alla variabile search e chiamo la funzione fetch_data() 
$("#search-form").submit(function(event) {
  search = $('#inputsearch').val();
  fetch_data(1);
  event.preventDefault();
});
// quando viene cambiata la select per la città assengno il valore dell'input alla variabile citta e chiamo la funzione fetch_data()
$(".form-select").change(function() {
  if($(this).val() == "0"){
    citta = "";
  }else {
  citta = $(this).val();
  }
  fetch_data(1);
});

// quando viene selezionato un bottone radio per l'ordine assengno il valore dell'input alla variabile ordine e chiamo la funzione fetch_data()
document.getElementsByName("ordine").forEach(function(element) {
  element.addEventListener('click', function() {
    ordine = $(this).val();
    fetch_data(1);
  });
});

</script>
    

</body>
</html>