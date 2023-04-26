
<?php 
  include 'connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./bootstrap/scss/bootstrap.css" >
    <link rel="stylesheet" href="./bootstrap-icons-1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/pagination.css">
    <link rel="stylesheet" href="./css/accordion.css">
    <script src="/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <title>Artisti</title>

    <style>

        #foto_profilo {
            padding : 5px;
            border-radius: 10px;
            width: 300px;
            height: 200px;
        }

          @media screen and (max-width: 600px) {
            .item-list-fed {
                flex-direction: column;
            }
            #foto_profilo {
                width: 100%;
            }

          }
          @media screen and (max-width: 1000px) {
            #row2 {
                flex-direction: column;
            }
            .col-3 {
                width: 100%;
            }

            .col-9 {
                width: 100%;
            }
          }      

          @media screen and (min-width:1000px) and (max-width: 1248px) {
            #sez_1 {
                grid-template-columns: 1fr;
            }
          }

          .d-flex {
            flex-flow: column wrap;
          }

    </style>

</head>
<body class="bg-beige">
 <header>
  <?php include 'navbar.php'; ?>
  </header>

  <div class="container-fed">
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
    <div class= "row align-items-start" id="row2">
        <div class="col-3">
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ordine" id="radio1"  value="recenti" checked>
            <label class="form-check-label" for="radio1"> Più recenti </label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ordine" id="radio2"  value="migliori">
            <label class="form-chekc-label" for="radio2"> Migliori valutazioni</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="ordine" id="radio3"  value="economici">
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
                            <input class="form-check-input" type="checkbox" name="genere" id="<?= $genere['id_strumento']; ?>" value="<?= $genere['nome_strumento']; ?>" />
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
  </div>
  <div class="col-9" id="pull_data">

  </div>
</div>
</div>


<footer>
<?php include('./footer.php'); ?>
</footer>

<script>

function fetch_data(page,search){
  $.ajax({
    url:"fetch_artisti.php",
    method:"POST",
    data:{page:page, search:search},
    success:function(data){
      $('#pull_data').html(data);
    }
  })
};

fetch_data();

$(document).on('click', '.page-item', function(){
  let page = $(this).attr("id");
  let search = $('#inputsearch').val();
  fetch_data(page, search);
});

$("#search-form").submit(function(event) {
  let search = $('#inputsearch').val();
  fetch_data(1, search);
  event.preventDefault();
});

</script>
    

</body>
</html>