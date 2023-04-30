<!DOCTYPE html>
<html lang="it">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title>NotaMi</title>
  
  <link rel="stylesheet" href="bootstrap/scss/bootstrap.css" />
  <link rel="stylesheet" href="./css/style.css" />
  <script src="./bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="./js/jquery.js"></script>
  <script src="./js/animations.js"></script>

</head>

<body class="bg-beige">

  <header class="bg-purple">
    <?php include 'navbar.php' ?>
  </header>

  <div id="presentation" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <div class="w-100 d-none d-md-block" style="background: url('./images/pres1.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/pres1.jpg') no-repeat; background-size: cover; height:300px;"></div>
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
        <div class="w-100 d-none d-md-block" style="background: url('./images/pres2.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/pres2.jpg') no-repeat; background-size: cover; height:300px;"></div>
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
        <div class="w-100 d-none d-md-block" style="background: url('./images/pres0.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/pres0.jpg') no-repeat; background-size: cover; height:300px;"></div>
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
  
  <br><br>

  <span class="text-purple text-center text-title"><h1>Find Bands&Stages</h1></span>
  <p class="text-center text-descr d-none d-md-block"> <b>NotaMi</b> è una piattaforma italiana dedicata ad artisti e host di eventi musicali:
     <br> il suo obiettivo è quello di far conoscere band emergenti e facilitare l'ingaggio di gruppi per vivacizzare le serate nei locali</p>
  <p class="text-center text-descr-mob d-block d-md-none"> <b>NotaMi</b> è una piattaforma italiana dedicata ad artisti e host di eventi musicali:
      il suo obiettivo è quello di far conoscere band emergenti e facilitare l'ingaggio di gruppi per vivacizzare le serate nei locali</p>

  <br>


  <div class="showcase">

    <div class="card-group">
      <div class="card">
        <div class="w-100 d-none d-md-block" style="background: url('./images/band2.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/band2.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="card-body">
          <h5 class="card-title">Ingaggia Band</h5>
          <p class="card-text">Trova il gruppo con il sound migliore per le tue necessità</p>
          <button type="button" class="btn btn-outline-secondary">Vai</button>
        </div>
      </div>

      <div class="card">
        <div class="w-100 d-none d-md-block" style="background: url('./images/musicista.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/musicista.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="card-body">
          <h5 class="card-title">Trova Artisti</h5>
          <p class="card-text">Scopri nuovi componenti per la tua band</p>
          <button type="button" class="btn btn-outline-secondary">Vai</button>
        </div>
      </div>

      <div class="card">
        <div class="w-100 d-none d-md-block" style="background: url('./images/evento2.jpg') no-repeat; background-size: cover; height:400px;"></div>
        <div class="w-100 d-block d-md-none" style="background: url('./images/evento2.jpg') no-repeat; background-size: cover; height:300px;"></div>
        <div class="card-body">
          <h5 class="card-title">Cerca Eventi</h5>
          <p class="card-text">Trova il palco su cui esibirti</p>
          <button type="button" class="btn btn-outline-secondary">Vai</button>
        </div>
      </div>

    </div>

  </div>

  <br><br class="d-none d-md-block">
  <span class="text-purple text-center text-title"><h1>In primo piano </h1></span>
  <p class="text-center text-descr d-none d-md-block">I <b>migliori gruppi</b> e artisti musicali registrati sul sito secondo le recensioni degli utenti</p>
  <p class="text-center text-descr-mob d-block d-md-none">I <b>migliori gruppi</b> e artisti musicali registrati sul sito secondo le recensioni degli utenti<br></p>
  

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
    <?php 
        include "connection.php";
        $query = "SELECT nome_band FROM profilo_band;";
        $result = pg_query($dbconn, $query);
    ?>
    <div class="card-group">
      <?php 
            $tuple = pg_fetch_array($result, null, PGSQL_ASSOC);
            $name = $tuple["nome_band"];
       ?>
      <div class="card m-3">
        <div style="background: url('./images/profile.jpg') no-repeat; background-position: center center; height:300px;"></div>
        <div class="card-body">
          <h5 class="card-title"> <?php echo $name ?> </h5>
          <ul class="list-group list-group-flush">
              <li class="list-group-item">recensioni</li>
              <li class="list-group-item">genere</li>
              <li class="list-group-item">città</li>
              <li class="list-group-item">carnet</li>
              <li class="list-group-item"><a href="#" class="btn btn-primary">Vedi profilo</a></li>
          </ul>
        </div>
      </div>
      <div class="card m-3">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
        </div>
        <div class="card-footer">
          <small class="text-body-secondary">Last updated 3 mins ago</small>
        </div>
      </div>
      <div class="card m-3">
        <img src="..." class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">Card title</h5>
          <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
            content. This card has even longer content than the first to show that equal height action.</p>
        </div>
        <div class="card-footer">
          <small class="text-body-secondary">Last updated 3 mins ago</small>
        </div>
      </div>
    </div>
    </div>
    <div class="tab-pane fade" id="nav-artist" role="tabpanel" aria-labelledby="nav-artist-tab" tabindex="0">
      <div class="card-group">
        <div class="card m-3">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
              content. This content is a little bit longer.</p>
          </div>
          <div class="card-footer">
            <small class="text-body-secondary">Last updated 3 mins ago</small>
          </div>
        </div>
        <div class="card m-3">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This card has supporting text below as a natural lead-in to additional content.</p>
          </div>
          <div class="card-footer">
            <small class="text-body-secondary">Last updated 3 mins ago</small>
          </div>
        </div>
        <div class="card m-3">
          <img src="..." class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title">Card title</h5>
            <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
              content. This card has even longer content than the first to show that equal height action.</p>
          </div>
          <div class="card-footer">
            <small class="text-body-secondary">Last updated 3 mins ago</small>
          </div>
        </div>
      </div>
    </div>

  </div>
  </div>


  <br><br>
  <span class="text-purple text-center text-title"><h1>Eventi imminenti</h1></span>
  <p class="text-center text-descr d-none d-md-block">Le prossime <b>occasioni</b> di ingaggio per musica dal vivo da non perdere</p>
  <p class="text-center text-descr-mob d-block d-md-none">Le prossime <b>occasioni</b> di ingaggio per musica dal vivo da non perdere</p></p>

  <div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col">
    <div class="card m-3">
      <div style="background: url('./images/R.jpeg') no-repeat; background-position: center center; height:300px;"></div>
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
        <ul class="list-group list-group-flush">
              <li class="list-group-item">data</li>
              <li class="list-group-item">luogo</li>
              <li class="list-group-item">retribuzione</li>
              <li class="list-group-item"><a href="#" class="btn btn-primary">Contatta</a></li>
          </ul>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card m-3">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card m-3">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content.</p>
      </div>
    </div>
  </div>
  <div class="col">
    <div class="card m-3">
      <img src="..." class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Card title</h5>
        <p class="card-text">This is a longer card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
      </div>
    </div>
  </div>
  </div>


  <footer class="footer pt-lg-5 pt-4 pb-4">
    <?php include 'footer.php' ?>
  </footer>

</body>

</html>