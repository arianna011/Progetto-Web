<nav class="navbar navbar-dark navbar-expand-lg bg-purple">
      <div class="container-fluid">
        <a class="navbar-brand" href="/pages/homepage/index.php">
          <img class="d-none d-md-block" height=50 src="/site_images/logo.png" alt="NotaMi">
          <img class="d-block d-md-none" height=40 src="/site_images/logo-mobile.png" alt="NotaMi">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="/pages/vetrine/vetrina_band/Band.php"><span class="text-white"> Band </span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pages/vetrine/vetrina_artisti/Artisti.php"><span class="text-white"> Artisti </span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pages/vetrine/vetrina_eventi/eventi.php"><span class="text-white"> Eventi </span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/pages/vetrine/vetrina_locali/Host.php"><span class="text-white"> Host </span></a>
            </li>
          </ul>
          <?php 

          if (isset($_COOKIE["univoco"])) $univoco = $_COOKIE["univoco"];
          else $univoco = "";
          
          #cookie non valido
          if ($univoco=="" || preg_match("([<>&(),%'?+])", $univoco) || preg_match('/"/', $univoco))  
          {
              echo ' <a href="/pages/login/login.php" class="d-flex btn btn-outline-secondary">
                    Accedi/Registrati </a>';
          }
          #cookie valido
          else
          {
              #include '../../connection.php'; -> non necessario: include posto in ogni file in cui appare la navbar
              $query = "SELECT id_utente, nickname FROM profilo_utente WHERE univoco = '$univoco'";
              $result = pg_query($dbconn, $query);
              $num = pg_num_rows($result);
              if ($num != 1) 
              {
                  echo ' <a href="/pages/login/login.php" class="d-flex btn btn-outline-secondary">
                      Accedi/Registrati </a>';
              }
              else
              {
                  $utente = pg_fetch_row($result);
                  $id = $utente[0];
                  $nickname = $utente[1];
                  echo '<a class="d-flex btn btn-outline-secondary" href="/pages/profili/profilo_utente.php?id=', $id ,'"> <i class="bi bi-person-circle"></i> 
                        <span class="ms-2">', $nickname, '</span> </a>';

              }
          }
  
          ?>
        </div>
      </div>
    </nav>