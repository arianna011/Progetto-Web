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
    <title>Host</title>

</head>
<body class="bg-beige">
 <header>
  <?php include '../../common/navbar.php'; ?>
  </header>
  <div class="col-12" id="cover"  style="background: url('../../../site_images/vetrina-host.jpg') no-repeat; background-size: cover; height:500px;">
          <h1 class="text-center align-bottom text-white " > Host </h1>
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
          <div class="ratio ratio-1x1 m-2" id="iframe-container">
            <iframe src="https://www.google.com/maps/d/embed?mid=1vOuy-wYqzy1Yro3Jtp78XFdKmWWrXpU&hl=it&ehbc=2E312F" ></iframe>
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
    url:"./fetch_host.php",
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

</script>
    

</body>
</html>