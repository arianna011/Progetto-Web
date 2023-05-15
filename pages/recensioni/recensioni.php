<?php
include '../../connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap/scss/bootstrap.css" >
    <link rel="stylesheet" href="../../bootstrap-icons-1.10.4/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../common/style.css">
    <link rel="stylesheet" href="style_rec.css">
    <script src="/../../bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="../vetrine.js"></script>
    <title>Recensioni</title>
</head>

<body>
    <div class="container">
        <?php if (isset($_SESSION['id'])) { ?>
            <form class="row mb-5" action="recensioni_action.php" method="POST">
            <div class="col-12">            
                <div class="rate">
                    <input type="radio" id="rating10" name="rating" value="10" /><label class="star-label" for="rating10" title="5 stars"></label>
                    <input type="radio" id="rating9" name="rating" value="9" /><label class="half star-label" for="rating9" title="4 1/2 stars"></label>
                    <input type="radio" id="rating8" name="rating" value="8" /><label class="star-label" for="rating8" title="4 stars"></label>
                    <input type="radio" id="rating7" name="rating" value="7" /><label class="half star-label" for="rating7" title="3 1/2 stars"></label>
                    <input type="radio" id="rating6" name="rating" value="6" /><label class="star-label" for="rating6" title="3 stars"></label>
                    <input type="radio" id="rating5" name="rating" value="5" /><label class="half star-label" for="rating5" title="2 1/2 stars"></label>
                    <input type="radio" id="rating4" name="rating" value="4" /><label class="star-label" for="rating4" title="2 stars"></label>
                    <input type="radio" id="rating3" name="rating" value="3" /><label class="half star-label" for="rating3" title="1 1/2 stars"></label>
                    <input type="radio" id="rating2" name="rating" value="2" /><label class="star-label" for="rating2" title="1 star"></label>
                    <input type="radio" id="rating1" name="rating" value="1" /><label class="half star-label" for="rating1" title="1/2 star"></label>
                    <input type="radio" id="rating0" name="rating" value="0" /><label class="star-label"for="rating0" title="No star"></label>
                </div>
            </div>
            <div class=" mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Scrivi una recensione</label>
                <textarea class="form-control text-recensione" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit"> Invia recensione </button>
            </div>
            </form>
        <?php } else { ?>
            <div class="row">
                <div class="col-12 my-4">
                    <a href="../login/login.php" class="btn btn-primary">Accedi per scrivere una recensione</a>
                </div>
            </div>
        <?php } ?>

    <?php if(isset($_GET['id'])) { 
        
        $id = $_GET['id'];
        $sql = "SELECT * FROM recensione_artista WHERE id_oggetto = $id";
        $result = pg_query($dbconn, $sql);

        ?>
            <?php
                while($row = pg_fetch_array($result)) {

                    $query_utente = "SELECT nickname,foto_profilo FROM profilo_utente WHERE id_utente = $row[id_utente]";
                    $result_utente = pg_query($dbconn, $query_utente);
                    $row_utente = pg_fetch_array($result_utente);

                    ?>
                    <div class="row recensione">
                        <div class="row">
                            <div class="col-1">
                                <img src="/site_images/placeholder_profile.jpg" alt="utente" class="rounded-circle foto-recensione" >
                                <h5><?php echo $row_utente['nickname']; ?></h5>
                            </div>
                        </div>
                        <div class="col-11">
                            <h6 class="valutazione" style="color:#fd7e14"> <?php
                                for ($i=1; $i < $row['valutazione']; $i+=2) { 
                                    ?> <i class="bi bi-star-fill"></i> <?php
                                }
                                if($row['valutazione'] % 2 != 0){
                                    ?> <i class="bi bi-star-half"></i> <?php
                                }
                                if($row['valutazione'] < 9){
                                    for ($i=1; $i < 10 - $row['valutazione']; $i+=2) { 
                                        ?> <i class="bi bi-star"></i> <?php
                                    }
                                } ?>
                            </h6>
                             <p><?php echo $row['data_recensione']; ?></p>
                             <p><?php echo $row['testo']; ?></p>
                            <hr>
                        </div> 
                    </div>
                <?php
                }

            ?>
        </div>
    <?php
    }

    ?>

</body>
</html>

