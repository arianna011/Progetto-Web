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
        <?php 
            $check;
            if (isset($_COOKIE["univoco"])) $univoco = $_COOKIE["univoco"];
            else $univoco = ""; 
            if  ($univoco=="" || preg_match("([<>&(),%'?+])", $univoco) || preg_match('/"/', $univoco))  
            { 
                ?>
            <div class="row">
                <div class="col-12 my-4">
                     <?php echo '<a href="../login/login.php?back='.$_GET['id'].'" class="btn btn-primary">Accedi per scrivere una recensione</a>' ?>
                </div>
            </div>
        <?php }  else { 
            $query_utente = "SELECT id_utente FROM profilo_utente WHERE univoco = '$univoco'";
            $result_utente = pg_query($dbconn, $query_utente);
            $row_utente = pg_fetch_row($result_utente);
            $check_recensione = "SELECT * FROM recensione_artista WHERE id_utente = $row_utente[0] AND id_oggetto = $_GET[id]";
            $result_check = pg_query($dbconn, $check_recensione);
            $check = pg_fetch_row($result_check);
            ?>
            <form class="row" action="recensioni_action.php" method="POST">
            <div class="col-12">            
                <div class="rate">
                    <input type="radio" id="rating10" name="rating" value="10" <?php if($check != NULL && $check[0]==10) echo "checked" ?> /><label class="star-label" for="rating10" title="5 stars"></label>
                    <input type="radio" id="rating9" name="rating" value="9" <?php if($check != NULL && $check[0]==9) echo "checked" ?>  /><label class="half star-label" for="rating9" title="4 1/2 stars"></label>
                    <input type="radio" id="rating8" name="rating" value="8" <?php if($check != NULL && $check[0]==8) echo "checked" ?> /><label class="star-label" for="rating8" title="4 stars"></label>
                    <input type="radio" id="rating7" name="rating" value="7" <?php if($check != NULL && $check[0]==7) echo "checked" ?> /><label class="half star-label" for="rating7" title="3 1/2 stars"></label>
                    <input type="radio" id="rating6" name="rating" value="6" <?php if($check != NULL && $check[0]==6) echo "checked" ?> /><label class="star-label" for="rating6" title="3 stars"></label>
                    <input type="radio" id="rating5" name="rating" value="5" <?php if($check != NULL && $check[0]==5) echo "checked" ?> /><label class="half star-label" for="rating5" title="2 1/2 stars"></label>
                    <input type="radio" id="rating4" name="rating" value="4" <?php if($check != NULL && $check[0]==4) echo "checked" ?> /><label class="star-label" for="rating4" title="2 stars"></label>
                    <input type="radio" id="rating3" name="rating" value="3" <?php if($check != NULL && $check[0]==3) echo "checked" ?>  /><label class="half star-label" for="rating3" title="1 1/2 stars"></label>
                    <input type="radio" id="rating2" name="rating" value="2" <?php if($check != NULL && $check[0]==2) echo "checked" ?> /><label class="star-label" for="rating2" title="1 star"></label>
                    <input type="radio" id="rating1" name="rating" value="1" <?php if($check != NULL && $check[0]==1) echo "checked" ?> /><label class="half star-label" for="rating1" title="1/2 star"></label>
                    <input type="radio" id="rating0" name="rating" value="0" <?php if($check != NULL && $check[0]==0) echo "checked" ?>  /><label class="star-label"for="rating0" title="No star"></label>
                </div>
            </div>
            <div class=" mb-3">
                <textarea class="form-control text-recensione" name="recensione" rows="3"><?php if ($check!= NULL) echo $check[1] ?></textarea>
                <input type="hidden" name="id_oggetto" value="<?php echo $_GET['id']; ?>">
                <input type="hidden" name="id_utente" value="<?php echo  $row_utente[0]?>">
            </div>
            <div class="col-12">
                <?php if($check!= NULL) { echo '<button class="btn btn-primary mr-2 my-1" type="submit" name="modifica">Modifica recensione</button>';}
                    else {echo '<button class="btn btn-primary my-1" type="submit">Invia recensione</button>';}
                 ?>
                <?php if($check!= NULL) echo '<button class="btn btn-danger my-1" type="submit" name="elimina">Cancella recensione</button>' ?>
            </div>
            </form>
        <?php }
    ?>

    <?php
        $id = $_GET['id'];
        $sql = "SELECT * FROM recensione_artista WHERE id_oggetto = $id";
        $result = pg_query($dbconn, $sql);
        ?>
        <div>
            <?php
                while($row = pg_fetch_array($result)) {

                    $query_utente = "SELECT nickname,foto_profilo FROM profilo_utente WHERE id_utente = $row[id_utente]";
                    $result_utente = pg_query($dbconn, $query_utente);
                    $row_utente_recensione = pg_fetch_array($result_utente);
                    if($row_utente_recensione['foto_profilo'] != NULL) {
                        $query_immagine = "SELECT src FROM immagine WHERE id_immagine = $row_utente_recensione[foto_profilo]";
                        $result_immagine = pg_query($dbconn, $query_immagine);
                        $row_immagine = pg_fetch_array($result_immagine);
                    }
                    
                    if(  $row['id_utente']  != $row_utente[0]  )  { ?>
                    <div class="row mt-3 recensione"> 
                        <div class="row">
                            <div class="col-1">
                                <?php if($row_utente_recensione['foto_profilo'] == NULL || str_starts_with( $row_immagine['src'], "http")) { ?>
                                    <img src="/site_images/placeholder_profile.jpg" alt="utente" class="rounded-circle foto-recensione" >
                                <?php } else { ?>
                                    <img src="/user_data/<?php echo $row_immagine['src']; ?>" alt="utente" class="rounded-circle foto-recensione" >
                                <?php } ?>
                                <h5><?php echo $row_utente_recensione['nickname']; ?></h5>
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
                <?php }
                }

            ?>
            </div>
        </div>

</body>
</html>

