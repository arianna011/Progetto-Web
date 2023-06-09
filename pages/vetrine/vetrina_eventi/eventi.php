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
    <title>Eventi</title>

</head>
<body class="bg-beige">
 <header>
  <?php include '../../common/navbar.php'; ?>
  </header>
    <!-- immagine copertina -->
  <div class="col-12 position-relative" id="cover"  style="background: url('../../../site_images/vetrina-evento-01.jpg') no-repeat; background-size: cover; height:500px;">
          <h1 class="text-center text-white position-absolute start-50 translate-middle-x bottom-0 big" > Eventi </h2>
  </div>
  <div class="container cont-event p-3">

    <div class= "row align-items-start mt-4" id="row2">
        <div class="col-3 width-100">
          <form class="row" method="post" id="search-form">
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
          <!-- calendario per selezionare le date -->
          <div class="col-10 calendar bg-primary mt-4 pt-2 text-center"  >
          <div class="row">
            <!-- freccia per tornare all'anno precedente -->
            <div class="col-auto">
            <i class="bi bi-chevron-left" id="prev" style="color:white;"></i> 
            </div>
            <div class="col-auto">
            <h5 class="text-center text-white " id="year" >2023</h5>  
            </div>
            <!-- freccia per andare all'anno successivo -->
            <div class="col-auto">
            <i class="bi bi-chevron-right" id="next" style="color:white;"></i>    
            </div>     
            </div> 
          </div>
          <div class="col-10 calendar bg-primary">
              <div class="row">
              <div class="col-1">
              <!-- freccia per andare al mese precedente -->
              <i class="bi bi-chevron-left" id="prev1" style="color:white;"></i> 
              </div>
              <div class="col-5">
              <h5 class="text-center text-white pb-2" id="month" >Gennaio</h5>  
              </div>
              <!-- freccia per andare al mese successivo -->
              <div class="col-2">
              <i class="bi bi-chevron-right" id="next1" style="color:white;"></i>    
              </div>  
            </div>       
          </div>
          <!-- giorni del mese -->
          <div class= "col-10 calendar">
            <ul class="list-inline">
              <?php for($i=1; $i<=7; $i++) {  ?>
                <li class="list-inline-item px-2 py-1 day" id="0<?=$i?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline">
              <li class="list-inline-item px-2 py-1 day" id="08">8</li>
              <li class="list-inline-item px-2 py-1 day" id="09">9</li>
              <?php for($i=10; $i<=14; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?=$i?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <?php for($i=15; $i<=21; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?=$i?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <?php for($i=22; $i<=28; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?=$i?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <li class="list-inline-item p-1 day" id="<?=$i?>">29</li>
              <?php for($i=30; $i<=31; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?=$i?>"><?=$i?></li>
              <?php } ?>
            </ul>
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
let anno;
let mese;
let giorni = new Array();

//funzione per prendere i dati da visualizzare 
function fetch_data(page){
  $.ajax({
    url:"./fetch_eventi.php",
    method:"GET",
    data:{page:page, search:search, ordine:ordine, citta:citta, anno:anno, mese:mese, giorni:giorni},
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

// visualizzo anno precedente e chiamo la funzione fetch_data()
$("#prev").on('click',function() {
  anno = (parseInt($("#year").text())) - 1;
  $("#year").text(anno);
  fetch_data(1);
})
// visualizzo anno successivo e chiamo la funzione fetch_data()
$("#next").on('click',function() {
  anno = (parseInt($("#year").text())) + 1;
  $("#year").text(anno);
  fetch_data(1);
})

// quando si cambia mese si cambiano anche i giorni che vengono visualizzati in base al mese selezionato e chiamo la funzione fetch_data()
$("#next1").on('click', function(){
  let year = parseInt($("#year").text());
  anno = year;
  let month = $("#month").text();
  if(month == "Gennaio"){
    $("#month").text("Febbraio");
    $("#29").hide();
    $("#30").hide();
    $("#31").hide();
    mese = "02";
  }else if(month == "Febbraio"){
    $("#month").text("Marzo");
    $("#29").show();
    $("#30").show();
    $("#31").show();
    mese = "03";
  }else if(month == "Marzo"){
    $("#month").text("Aprile");
    $("#31").hide();
    mese = "04";
  }else if(month == "Aprile"){
    $("#month").text("Maggio");
    $("#31").show();
    mese = "05";
  }
  else if(month == "Maggio"){
    $("#month").text("Giugno");
    $("#31").hide();
    mese = "06";
  }
  else if(month == "Giugno"){
    $("#month").text("Luglio");
    $("#31").show();
    mese = "07";
  }
  else if(month == "Luglio"){
    $("#month").text("Agosto");
    mese = "08";
  }
  else if(month == "Agosto"){
    $("#month").text("Settembre");
    $("#31").hide();
    mese = "09";
  }
  else if(month == "Settembre"){
    $("#month").text("Ottobre");
    $("#31").show();
    mese = "10";
  }
  else if(month == "Ottobre"){
    $("#month").text("Novembre");
    $("#31").hide();
    mese = "11";
  }
  else if(month == "Novembre"){
    $("#month").text("Dicembre");
    $("#31").show();
    mese = "12";
  }
  else if(month == "Dicembre"){
    $("#month").text("Gennaio");
    $("#year").text(year+1);
    anno = year+1;
    mese = "01";
  }
  fetch_data(1);

});

$("#prev1").on('click', function() {
  let year = parseInt($("#year").text());
  let month = $("#month").text();
  if(month == "Gennaio"){
    $("#year").text(year-1);
    anno = year-1;
    $("#month").text("Dicembre");
    mese = "12";
  }else if(month == "Febbraio"){
    $("#month").text("Gennaio");
    $("#29").show();
    $("#30").show();
    $("#31").show();
    mese = "01";
  }else if(month == "Marzo"){
    $("#month").text("Febbraio");
    $("#29").hide();
    $("#30").hide();
    $("#31").hide();
    mese = "02";
  }else if(month == "Aprile"){
    $("#month").text("Marzo");
    $("#31").show();
    mese = "03";
  }else if(month == "Maggio"){
    $("#month").text("Aprile");
    $("#31").hide();
    mese = "04";
  }else if(month == "Giugno"){
    $("#month").text("Maggio");
    $("#31").show();
    mese = "05";
  }else if(month == "Luglio"){
    $("#month").text("Giugno");
    $("#31").hide();
    mese = "06";
  }else if(month == "Agosto"){
    $("#month").text("Luglio");
    $("#31").show();
    mese = "07";
  }else if(month == "Settembre"){
    $("#month").text("Agosto");
    mese = "08";
  }else if(month == "Ottobre"){
    $("#month").text("Settembre");
    $("#31").hide();
    mese = "09";
  }else if(month == "Novembre"){
    $("#month").text("Ottobre");
    $("#31").show();
    mese = "10";
  }else if(month == "Dicembre"){
    $("#month").text("Novembre");
    mese = "11";
  }
  fetch_data(1);
});

// è possibile selezionare uno o più giorni per la ricerca
$(".day").on('click', function() {
  if ($(this).css("background-color") == "rgb(255, 165, 0)") {
    $(this).css("background-color", "white");
    giorni.splice(giorni.indexOf($(this).attr("id")), 1);
    fetch_data(1);
  }else {
  $(this).css("background-color", "orange");
  giorni.push($(this).attr("id"));
  fetch_data(1);
  }
});

</script>
</body>
</html>