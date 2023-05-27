<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search-card-template</title>

    <link rel="stylesheet" href="/bootstrap/scss/bootstrap.css" />
    <link rel="stylesheet" href="/pages/common/style.css" />

    <style>
        .search-card {
            display: flex;
            flex-direction: column;
            background-color: whitesmoke;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .s-img {
            aspect-ratio: 1/1;
        }

        .s-img>img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .s-content{
            display: flex;
            flex-direction: column;
            padding: 1em;
        }

        .s-title{
            font-size: 3em;
            font-weight: 600;
        }

        .s-body{
            display: flex;
            flex-direction: column;
        }

        .s-info-1{
            display: flex;
            flex-direction: column;
        }
        .s-info-2{
            display: flex;
            flex-direction: column;
            align-self: flex-end;

            font-size: 1.5em;
        }


        /* On screens that are 769px or less */
        @media screen and (min-width: 769px) {
            .search-card{
                flex-direction: row;
            }

            .s-img{
                flex: 3 0 0;
            }
            
            .s-content{
                flex: 7 1 0;
            }

            .s-body{
                flex-grow: 1;
                flex-wrap: wrap;
                justify-content: space-between;
            }

            .search-card:hover{
                transform: scale(1.05);
            }
            .search-card{
                transition: transform 0.2s ease-in-out;
            }

        }
    </style>

</head>

<body class=bg-beige>
    <div class="search-card">
        <div class="s-img">
            <img src=<?php echo $img ?>>
        </div>

        <div class="s-content">
            <div class="s-title">
                <?php echo $title ?>
            </div>
            <div class="s-body">
                <div class="s-info1">
                    <?php foreach ($infos1 as $info)
                        echo "<div>" . $info . "</div>"; ?>
                </div>
                <div class="s-info-2">
                    <?php foreach ($infos2 as $info)
                        echo "<div>" . $info . "</div>"; ?>
                </div>
            </div>
        </div>


    </div>
</body>

</html>