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
    <title>Eventi</title>

</head>
<body class="bg-beige">
 <header>
  <?php include '../../common/navbar.php'; ?>
  </header>
  <div class="col-12" id="cover"  style="background: url('../../../site_images/vetrina-host.jpg') no-repeat; background-size: cover; height:500px;">
          <h1 class="text-center align-bottom text-white " > Eventi </h2>
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
          <div class="col-10 calendar bg-primary mt-4 pt-2 text-center"  >
          <div class="row">
            <div class="col-auto">
            <i class="bi bi-chevron-left" id="prev" style="color:white;"></i> 
            </div>
            <div class="col-auto">
            <h5 class="text-center text-white " id="year" >2023</h5>  
            </div>
            <div class="col-auto">
            <i class="bi bi-chevron-right" id="next" style="color:white;"></i>    
            </div>     
            </div> 
          </div>
          <div class="col-10 calendar bg-primary">
              <div class="row">
              <div class="col-auto">
              <i class="bi bi-chevron-left" id="prev1" style="color:white;"></i> 
              </div>
              <div class="col-auto">
              <h5 class="text-center text-white pb-2" id="month" >Gennaio</h5>  
              </div>
              <div class="col-auto">
              <i class="bi bi-chevron-right" id="next1" style="color:white;"></i>    
              </div>  
            </div>       
          </div>
          <div class= "col-10 calendar bg-light">
            <ul class="list-inline">
              <?php for($i=1; $i<=7; $i++) {  ?>
                <li class="list-inline-item px-2 pt-2 day" id="<?= $i ?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline">
              <li class="list-inline-item px-2 pt-2 day" id="8">8</li>
              <li class="list-inline-item p-2 day" id="9">9</li>
              <?php for($i=10; $i<=14; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?= $i ?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <?php for($i=15; $i<=21; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?= $i ?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <?php for($i=22; $i<=28; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?= $i ?>"><?=$i?></li>
              <?php } ?>
            </ul>
            <ul class="list-inline ">
              <li class="list-inline-item p-1 day" id="<?= $i ?>">29</li>
              <?php for($i=30; $i<=31; $i++) {  ?>
                <li class="list-inline-item p-1 day" id="<?= $i ?>"><?=$i?></li>
              <?php } ?>
            </ul>
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
let search;
let citta;


function fetch_data(page){
  $.ajax({
    url:"./fetch_eventi.php",
    method:"POST",
    data:{page:page, search:search, ordine:ordine, citta:citta},
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
    fetch_data(1);
  });
});




$(document).on('click', '#next1', function(){
  let year = parseInt($("#year").text());
  //let month = $("#month").innerHTML;
  let month = $("#month").text();
  if(month == "Gennaio"){
    $("#month").text("Febbraio");
    $("#29").hide();
    $("#30").hide();
    $("#31").hide();
  }else if(month == "Febbraio"){
    $("#month").text("Marzo");
    $("#29").show();
    $("#30").show();
    $("#31").show();
  }else if(month == "Marzo"){
    $("#month").text("Aprile");
    $("#31").hide();
  }else if(month == "Aprile"){
    $("#month").text("Maggio");
    $("#31").show();
  }
  else if(month == "Maggio"){
    $("#month").text("Giugno");
    $("#31").hide();
  }
  else if(month == "Giugno"){
    $("#month").text("Luglio");
    $("#31").show();
  }
  else if(month == "Luglio"){
    $("#month").text("Agosto");
  }
  else if(month == "Agosto"){
    $("#month").text("Settembre");
    $("#31").hide();
  }
  else if(month == "Settembre"){
    $("#month").text("Ottobre");
    $("#31").show();
  }
  else if(month == "Ottobre"){
    $("#month").text("Novembre");
    $("#31").hide();
  }
  else if(month == "Novembre"){
    $("#month").text("Dicembre");
    $("#31").show();
  }
  else if(month == "Dicembre"){
    $("#month").text("Gennaio");
    $("#year").text(year+1);
  }
  


});

$(document).on('click', '#prev1', function() {
  let year = parseInt($("#year").text());
  let month = $("#month").text();
  if(month == "Gennaio"){
    $("#year").text(year-1);
    $("#month").text("Dicembre");
  }else if(month == "Febbraio"){
    $("#month").text("Gennaio");
    $("#29").show();
    $("#30").show();
    $("#31").show();
  }else if(month == "Marzo"){
    $("#month").text("Febbraio");
    $("#29").hide();
    $("#30").hide();
    $("#31").hide();
  }else if(month == "Aprile"){
    $("#month").text("Marzo");
    $("#31").show();
  }else if(month == "Maggio"){
    $("#month").text("Aprile");
    $("#31").hide();
  }else if(month == "Giugno"){
    $("#month").text("Maggio");
    $("#31").show();
  }else if(month == "Luglio"){
    $("#month").text("Giugno");
    $("#31").hide();
  }else if(month == "Agosto"){
    $("#month").text("Luglio");
    $("#31").show();
  }else if(month == "Settembre"){
    $("#month").text("Agosto");
  }else if(month == "Ottobre"){
    $("#month").text("Settembre");
    $("#31").hide();
  }else if(month == "Novembre"){
    $("#month").text("Ottobre");
    $("#31").show();
  }else if(month == "Dicembre"){
    $("#month").text("Novembre");
  }
});



</script>
</body>
</html>