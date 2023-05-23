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
                <?php foreach ($imgs as $img) echo '<div> <img src= "'.$img.'"> </div>'; ?> 
            </div>
            <i class="bi bi-plus-circle-fill clickable-icon" style="font-size:xx-large;" hidden></i>
        </div>
    </div>

</body>

</html>