<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NotaMi</title>
  
  <link rel="stylesheet" href="/bootstrap/scss/bootstrap.css" />
  <link rel="stylesheet" href="/bootstrap-icons-1.10.4/font/bootstrap-icons.css">
  <link rel="stylesheet" href="/pages/common/style.css" />
  <link rel="stylesheet" href="/pages/homepage/homepage.css" />
  <script src="/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="/pages/homepage/jquery.js"></script>
  <script src="/pages/homepage/animations.js"></script>

</head>

<body>
  <?php include '../../connection.php'?>  

  <div class="bg-beige">

  <header class="bg-purple">
    <?php include '../common/navbar.php' ?>
  </header>

  
  <!-- carosello di presentazione !-->
  <div id="presentation" class="carousel slide mb-6" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="w-100 d-none d-md-block" style="background: url('../../site_images/pres1.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('../../site_images/pres1.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="carousel-caption text-white text-md-start">
          <span class="d-none d-md-block pres-descr"> 
            <span class="pres-slide" style="display: None;"> <h5>Sound di qualità</h5> </span> 
            <span class="pres-fade" style="display: None;"><br> per i tuoi eventi </span>
          </span>
          <span class="d-block d-md-none pres-descr-mob"> 
            <span class="pres-slide" style="display: None;"> <h5>Sound di qualità</h5> </span> 
            <span class="pres-fade" style="display: None;"><br> per i tuoi eventi </span>
          </span>
        </div>
      </div>
      <div class="carousel-item">
        <div class="w-100 d-none d-md-block" style="background: url('../../site_images/pres2.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('../../site_images/pres2.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="carousel-caption  text-white text-md-start">
          <span class="d-none d-md-block pres-descr"> 
            <span class="pres-slide" style="display: None;"><h5>Visibilità</h5> </span>
            <span class="pres-fade" style="display: None;"> <br> per il tuo gruppo </span>
          </span>
          <span class="d-block d-md-none pres-descr-mob"> 
            <span class="pres-slide" style="display: None;"><h5>Visibilità</h5> </span>
            <span class="pres-fade" style="display: None;"> <br> per il tuo gruppo </span>
          </span>
        </div>
      </div>
      <div class="carousel-item">
        <div class="w-100 d-none d-md-block" style="background: url('../../site_images/pres3.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('../../site_images/pres3.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="carousel-caption text-white text-md-start">
          <span class="d-none d-md-block pres-descr"> 
            <span class="pres-slide" style="display: None;"> <h5>Musica dal vivo</h5> </span>
            <span class="pres-fade" style="display: None;"> <br> per serate speciali </span>
          </span>
          <span class="d-block d-md-none pres-descr-mob"> 
            <span class="pres-slide" style="display: None;"> <h5>Musica dal vivo</h5> </span>
            <span class="pres-fade" style="display: None;"> <br> per serate speciali </span>
          </span>
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#presentation" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#presentation" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
  </div>
  
  <div class="container-xxl">

  <!-- descrizione testuale del sito !-->
  <div class="mt-5 mb-4">
  <span class="text-purple text-center text-title"><h1>Find Bands&Stages</h1></span>
  <p class="text-center text-descr d-none d-md-block"> <b>NotaMi</b> è una piattaforma italiana dedicata ad artisti e host di eventi musicali:
     <br> il suo obiettivo è quello di far conoscere band emergenti e facilitare l'ingaggio di gruppi per vivacizzare le serate nei locali</p>
  <p class="text-center text-descr-mob d-block d-md-none"> <b>NotaMi</b> è una piattaforma italiana dedicata ad artisti e host di eventi musicali:
      il suo obiettivo è quello di far conoscere band emergenti e facilitare l'ingaggio di gruppi per vivacizzare le serate nei locali</p>
  </div>

  <div>

  <!-- link alle sezioni del sito !-->
    <div class="card-group">
      <div class="card">
        <div style="background-image: url('../../site_images/band.jpg'); background-size: cover; height:300px;"> </div>
        <div class="card-body">
          <h5 class="card-title">Ingaggia Band</h5>
          <p class="card-text">Trova il gruppo con il sound migliore per le tue necessità</p>
        </div>
          <div class="card-footer mb-2">
          <a class="btn btn-outline-secondary" href="../vetrine/vetrina_band/band.php">Vai</a>
    </div>
      </div>

      <div class="card">
    
      <div style="background-image: url('../../site_images/artista.jpg'); background-size: cover; height:300px;"> </div>
        <div class="card-body">
          <h5 class="card-title">Trova Artisti</h5>
          <p class="card-text">Scopri nuovi componenti per la tua band</p>
        </div>
          <div class="card-footer mb-2">
          <a class="btn btn-outline-secondary" href="../vetrine/vetrina_artisti/Artisti.php">Vai</a>
          </div>
      </div>

      <div class="card">
      <div style="background-image: url('../../site_images/evento.jpg'); background-size: cover; height:300px;"></div>
        <div class="card-body">
          <h5 class="card-title">Cerca Eventi</h5>
          <p class="card-text">Trova il palco su cui esibirti</p>
        </div>
          <div class="card-footer mb-2">
          <a class="btn btn-outline-secondary" href="../vetrine/vetrina_eventi/eventi.php">Vai</a>
        </div>
      </div>

    </div>

  </div>

  <!-- vetrina di migliori band e artisti !-->
  <br><br class="d-none d-md-block">
  <span class="text-purple text-center text-title"><h1>In primo piano </h1></span>
  <p class="text-center text-descr d-none d-md-block">I <b>migliori gruppi</b> e artisti musicali registrati sul sito secondo le recensioni degli utenti</p>
  <p class="text-center text-descr-mob d-block d-md-none">I <b>migliori gruppi</b> e artisti musicali registrati sul sito secondo le recensioni degli utenti<br></p>
  
  <!-- inclusione file per il caricamento dei dati di band e artisti dal database !-->
  <?php include './showcase.php' ?>

  <div class="card text-center bg-beige">
  <nav>
    <div class="nav nav-tabs bg-purple" id="nav-tab" role="tablist">
      <button class="nav-link active" id="nav-band-tab" data-bs-toggle="tab" data-bs-target="#nav-band" type="button"
        role="tab" aria-controls="nav-band" aria-selected="true">Band</button>
      <button class="nav-link" id="nav-artist-tab" data-bs-toggle="tab" data-bs-target="#nav-artist" type="button"
        role="tab" aria-controls="nav-artist" aria-selected="false">Artisti</button>
    </div>
  </nav>
  <div class="tab-content" id="nav-tabContent">
    <div class="tab-pane fade show active" id="nav-band" role="tabpanel" aria-labelledby="nav-band-tab" tabindex="0">
    
    <div class="card-group">
      
      <div class="card m-3">
        <?php echo '<div style="background: url(', $img_band[0] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
        <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $band1["nome_band"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> 
                <?php echo $stars_band[0], '<br>', $descr_band[0]?> 
              </li>
              <li class="list-group-item"> <?php echo $genres_band[0] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $band1["sede"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_band[0] ?></li>
              <li class="list-group-item"> </li>
          </ul>
        </div>
        <div class="card-footer">
            <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo_band.php?id=', $band1["id_band"],'"> Vedi profilo</a>' ?>
        </div>
      </div>

      <div class="card m-3">
        <?php echo '<div style="background: url(', $img_band[1] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
        <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $band2["nome_band"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> <?php echo $stars_band[1], '<br>', $descr_band[1] ?> </li>
              <li class="list-group-item"> <?php echo $genres_band[1] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $band2["sede"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_band[1] ?></li>
              <li class="list-group-item"> </li>
          </ul>
        </div>
        <div class="card-footer">
          <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo_band.php?id=', $band2["id_band"],'"> Vedi profilo</a>' ?>
        </div>
      </div>

      <div class="card m-3">
        <?php echo '<div style="background: url(', $img_band[2] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
        <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $band3["nome_band"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> <?php echo $stars_band[2], '<br>', $descr_band[2] ?> </li>
              <li class="list-group-item"> <?php echo $genres_band[2] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $band3["sede"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_band[2] ?></li>
              <li class="list-group-item"> </li>
          </ul>
        </div>
        <div class="card-footer">
        <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo_band.php?id=', $band3["id_band"],'"> Vedi profilo</a>' ?>
        </div>
      </div>
    
    </div> 

    </div>
    
    <div class="tab-pane fade" id="nav-artist" role="tabpanel" aria-labelledby="nav-artist-tab" tabindex="0">
      <div class="card-group">
      
        <div class="card m-3">
          <?php echo '<div style="background: url(', $img_art[0] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
          <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $art1["nome"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> 
                <?php echo $stars_artist[0], '<br>', $descr_artist[0]?> 
              </li>
              <li class="list-group-item"> <?php echo $genres_artist[0] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $art1["nome_citta"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_artist[0] ?></li>
              <li class="list-group-item"> </li>
          </ul>
          </div>
          <div class="card-footer">
          <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo.php?id=', $art1["id_artista"],'&ptype=2"> Vedi profilo</a>' ?>
          </div>
        </div>

        <div class="card m-3">
          <?php echo '<div style="background: url(', $img_art[1] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
          <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $art2["nome"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> <?php echo $stars_artist[1], '<br>', $descr_artist[1] ?> </li>
              <li class="list-group-item"> <?php echo $genres_artist[1] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $art2["nome_citta"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_artist[1] ?></li>
              <li class="list-group-item"> </li>
          </ul>
          </div>
          <div class="card-footer">
          <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo.php?id=', $art2["id_artista"],'&ptype=2"> Vedi profilo</a>' ?>
          </div>
        </div>

        <div class="card m-3">
          <?php echo '<div style="background: url(', $img_art[2] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:200px;"></div>' ?>
          <div class="card-body">
          <h5 class="card-title showcase-title"> <?php echo $art3["nome"] ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item"> <?php echo $stars_artist[2], '<br>', $descr_artist[2] ?> </li>
              <li class="list-group-item"> <?php echo $genres_artist[2] ?> </li>
              <li class="list-group-item"> <i class="bi bi-geo-alt-fill"></i> <?php echo $art3["nome_citta"] ?> </li>
              <li class="list-group-item"> <?php echo $prices_artist[2] ?></li>
              <li class="list-group-item"> </li>
          </ul>
        </div>
        <div class="card-footer">
          <?php  echo '<a class="btn btn-primary m-3 mt-0" href="/pages/profili/profilo.php?id=', $art3["id_artista"],'&ptype=2"> Vedi profilo</a>' ?>
        </div>
      </div>
    
    </div> 
  </div>

  </div>
  </div>
  
  <!-- vetrina dei prossimi eventi !-->
  <br><br>
  <span class="text-purple text-center text-title"><h1>Eventi imminenti</h1></span>
  <p class="text-center text-descr d-none d-md-block">Le prossime <b>occasioni</b> di ingaggio per musica dal vivo da non perdere</p>
  <p class="text-center text-descr-mob d-block d-md-none">Le prossime <b>occasioni</b> di ingaggio per musica dal vivo da non perdere</p></p>

  <!-- inclusione file per il caricamento dei dati degli eventi dal database !-->
  <?php include './events.php' ?>

  <div class="row row-cols-1 row-cols-md-2 g-0 mb-4">
  <div class="col">
    <div class="card m-3">
      <div class="m-2 bg-trans-purple"> <h6 class="text-purple m-2"> <i class="bi bi-person-circle me-1"><span class="ms-1"> <?php echo $event1["nick_datore"] ?> </span> </i> </h6></div>
      <?php echo '<div style="background: url(', $img_events[0] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:300px;"></div>' ?>
      <div class="card-body">
        <h5 class="card-title showcase-title mx-2"> <?php echo $event1["titolo"] ?></h5>
        <p class="card-text showcase-date mx-2"> <?php echo $event1["stringa_data"] ?> </p>
        <p class="card-text mx-2"> <?php echo $descr_events[0] ?> </p>
        <ul class="list-group list-group-flush mx-2">
              <li class="list-group-item"> <?php echo $locations[0] ?></li>
              <li class="list-group-item"> <?php echo $retribution[0] ?> </li>
        </ul>
        <div class="card-footer" style="text-align: center;">
            <?php echo '<a href="/pages/profili/profilo.php?id=', $event1["id_datore"] ,'&ptype=1" class="btn btn-primary m-3 mt-0"> Contatta </a>' ?>
        </div>
      </div>
    </div>
  </div>
  <div class="col">
  <div class="card m-3">
  <div class="m-2 bg-trans-purple"> <h6 class="text-purple m-2"> <i class="bi bi-person-circle me-1"><span class="ms-1"> <?php echo $event2["nick_datore"] ?> </span> </i> </h6></div>
      <?php echo '<div style="background: url(', $img_events[1] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:300px;"></div>' ?>
      <div class="card-body">
        <h5 class="card-title showcase-title mx-2"> <?php echo $event2["titolo"] ?></h5>
        <p class="card-text showcase-date mx-2"> <?php echo $event2["stringa_data"] ?> </p>
        <p class="card-text mx-2"> <?php echo $descr_events[1] ?> </p>
        <ul class="list-group list-group-flush mx-2">
              <li class="list-group-item"> <?php echo $locations[1] ?></li>
              <li class="list-group-item"> <?php echo $retribution[1] ?> </li>
        </ul>
        <div class="card-footer" style="text-align: center;">
        <?php echo '<a href="/pages/profili/profilo.php?id=', $event2["id_datore"] ,'&ptype=1" class="btn btn-primary m-3 mt-0"> Contatta </a>' ?>
        </div>
      </div>
  </div>
  </div>
  <div class="col">
  <div class="card m-3">
  <div class="m-2 bg-trans-purple"> <h6 class="text-purple m-2"> <i class="bi bi-person-circle me-1"><span class="ms-1"> <?php echo $event3["nick_datore"] ?> </span> </i> </h6></div>
      <?php echo '<div style="background: url(', $img_events[2] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:300px;"></div>' ?>
      <div class="card-body">
        <h5 class="card-title showcase-title mx-2"> <?php echo $event3["titolo"] ?></h5>
        <p class="card-text showcase-date mx-2"> <?php echo $event3["stringa_data"] ?> </p>
        <p class="card-text mx-2"> <?php echo $descr_events[2] ?> </p>
        <ul class="list-group list-group-flush mx-2">
              <li class="list-group-item"> <?php echo $locations[2] ?></li>
              <li class="list-group-item"> <?php echo $retribution[2] ?> </li>
        </ul>
        <div class="card-footer" style="text-align: center;">
        <?php echo '<a href="/pages/profili/profilo.php?id=', $event3["id_datore"] ,'&ptype=1" class="btn btn-primary m-3 mt-0"> Contatta </a>' ?>
        </div>
      </div>
  </div>
  </div>
  <div class="col">
  <div class="card m-3">
  <div class="m-2 bg-trans-purple"> <h6 class="text-purple m-2"> <i class="bi bi-person-circle me-1"><span class="ms-1"> <?php echo $event4["nick_datore"] ?> </span> </i> </h6></div>
      <?php echo '<div style="background: url(', $img_events[3] ?? "../../site_images/placeholder-image.webp", ') no-repeat; background-position: center center; height:300px;"></div>' ?>
      <div class="card-body">
        <h5 class="card-title showcase-title mx-2"> <?php echo $event4["titolo"] ?></h5>
        <p class="card-text showcase-date mx-2"> <?php echo $event4["stringa_data"] ?> </p>
        <p class="card-text mx-2"> <?php echo $descr_events[3] ?> </p>
        <ul class="list-group list-group-flush mx-2">
              <li class="list-group-item"> <?php echo $locations[3] ?></li>
              <li class="list-group-item"> <?php echo $retribution[3] ?> </li>
        </ul>
        <div class="card-footer" style="text-align: center;">
        <?php echo '<a href="/pages/profili/profilo.php?id=', $event4["id_datore"] ,'&ptype=1" class="btn btn-primary m-3 mt-0"> Contatta </a>' ?>
        </div>
      </div>
  </div>
  </div>
  </div>

  </div>
  
  <footer>
    <?php include '../common/footer.php' ?>
  </footer>
  </div>

</body>

</html>