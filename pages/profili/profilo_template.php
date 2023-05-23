<?php 
$isUtente ??= false; //per la retrocompatibilità ;)
$isProfiloUtente ??= false;
$isProfiloArtista ??= false;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Profilo_template</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style_profili.css">
    <link rel="stylesheet" href="/pages/common/style.css" />
    <link rel="stylesheet" href="../../bootstrap/scss/bootstrap.css" >

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <script>
        $(".contain-image").on("click", function() {
            if ($(".hidden-button").attr("hidden")) {
                $(".hidden-button").removeAttr("hidden");
            } else {
                $(".hidden-button").attr("hidden", "true");
            }
            
            
        });
    </script>


</head>

<body>
    
    <div class="profile">
        <div class="p-card">
            <div class="p-img p-avatar">
                <img src="<?php echo $avatarSrc ?? "../../site_images/placeholder_profile.jpg"; ?>">
            </div>

            <div class="p-info-card">
                <div id="p-name" style="color:whitesmoke"> <h1> <b> <?php echo $name ?> </b></h1></div>
                <?php foreach ($infos as $info) echo '<div class="info">'.$info.'</div>'; ?>
                <?php if($isUtente) { ?>
                <?php if ($isProfiloUtente) { ?>
                    <div class="col-auto">
                        <?php echo ' <a href="/pages/profili/modifiche/modifica_immagine.php?id='.$id.'&ptype=1" type="button" class="btn btn-light my-2"> Modifica immagine <i class="bi bi-plus-circle-fill"></i> </a>' ?>
                    </div>
                    <?php } if ($isProfiloArtista) { ?>
                        <div class="col-auto">
                        <?php echo ' <a href="/pages/profili/modifiche/modifica_immagine.php?id='.$id.'&ptype=2" type="button" class="btn btn-light my-2"> Modifica immagine <i class="bi bi-plus-circle-fill"></i> </a>' ?>
                    </div>
                            <?php
                    } } ?>
            </div>

            <?php if($isUtente) { ?>
                <?php if ($isProfiloUtente) { ?>
            <div class="col-auto">
                <?php echo ' <a href="/pages/profili/modifiche/modifica_profilo_utente.php?id='.$id.'" type="button" class="btn btn-light"> Modifica profilo <i class="bi bi-pencil-square"></i> </a>' ?>
            </div>
            <?php } if ($isProfiloArtista) { ?>
                <div class="col-auto">
                <?php echo ' <a href="/pages/profili/modifiche/modifica_profilo_artista.php?id='.$id.'" type="button" class="btn btn-light"> Modifica profilo <i class="bi bi-pencil-square"></i> </a>' ?>
            </div>
                    <?php
            } } ?>

        </div>


        <div class="p-desc">
            <div class="p-desc-title">
                <h2> Descrizione </h2>
            </div>
            <div class="p-desc-body">
                <?php echo $description ?? "<h3 class='text-grey' style='font-weight:50'> nessuna descrizione... </h3>" ?>
            </div>
        </div>

        <div class="p-gallery">
            <div class="p-g-images">
                <?php foreach ($imgs as $img) {
                 if(str_starts_with($img, "http")) {
                 echo '<div class="contain-image"> <a class="hidden-button btn btn-danger px-2 py-0 mb-2" href="/pages/profili/modifiche/elimina_immagine.php?id='.$id.'&ptype=6&del='.$img.'" hidden >  <i class="bi bi-x"></i> </a> <img src= "'.$img.'"> </div>';
                 } else {
                    $img_2 = "/user_data/$img";
                    echo '<div class="contain-image"> <a class="hidden-button btn btn-danger px-2 py-0 mb-2" href="/pages/profili/modifiche/elimina_immagine.php?id='.$id.'&ptype=6&del='.$img.'" hidden >  <i class="bi bi-x"></i> </a> <img src= "'.$img_2.'"> </div>';
                    }
                 } ?> 
            <?php if($isUtente) { ?>
                <?php if ($isProfiloArtista) { ?>
                <a href = "/pages/profili/modifiche/modifica_immagine.php?id=<?php echo $id ?>&ptype=6">
            <i class="bi bi-plus-circle-fill clickable-icon" style="font-size:xx-large;"></i>
            </a>
            <?php } } ?>
            </div>
        </div>
    </div>

</body>

</html>