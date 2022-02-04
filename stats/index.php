<!DOCTYPE HTML>

<?php

require 'mojang-api.class.php';
include("config.php");


$con = mysqli_connect($ip, $user, $password, $database);
if(!$con) {
    die("MYSQL Verbindung fehlgeschlagen.");
}

?>


<html>
<head>
    <title><?php echo $richname; ?></title>
    <meta name="description" content="<?php echo $richtext; ?>">
    <meta name="theme-color" content="#424242">
    <meta charset="UTF-8">
    <noscript>
        <link rel="stylesheet" href="css/skel.css" />
        <link rel="stylesheet" href="css/style.css" />
        <link rel="stylesheet" href="css/style-xlarge.css" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    </noscript>
    <style>

        table {
            width: 100%;
            margin: 2em 0;
            border-collapse: collapse;
            word-break:normal;
        }

        td {
            padding: .5em;
            vertical-align: top;
            border: 1px solid #bbbbbb;
        }

        th {
            padding: .5em;
            text-align: left;
            border: 1px solid #bbbbbb;
            border-bottom: 3px solid #bbbbbb;
            background:#f4f7fa;
        }


        .table-scrollable {
            width: 100%;
            overflow-y: auto;
            margin: 0 0 1em;
        }

        .table-scrollable::-webkit-scrollbar {
            -webkit-appearance: none;
            width: 14px;
            height: 14px;
        }

        .table-scrollable::-webkit-scrollbar-thumb {
            border-radius: 8px;
            border: 3px solid #fff;
            background-color: rgba(0, 0, 0, .3);
        }

    </style>


</head>

<body id="landing">
<!-- Header -->

<header id="header">


    <h1><a href="<?php echo $maindomain; ?>"><?php echo $servername; ?></a></h1>
    <nav id="nav">
        <ul>
            <li><a href="<?php echo $domain;?>">Startseite</a></li>
        </ul>
    </nav>
</header>
<!-- One -->
<section class="wrapper style special">
    <header class="major">
        <h2><?php echo $servername; ?></h2>
    </header>
    <div class="container">
        <div class="row">

            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3>Spieler suchen</h3>
                    <p></p>
                    <form id="playersearch" action="search.php" method="post">
                        <p>Spielername oder Rang: <input type="text" name="username" class="form-control" placeholder="Spielername oder Rang" required /></p>
                        <p></p>
                        <input type="submit" value="Spieler suchen" />
                        <p></p>
                    </form>

                </section>

            </div>
            <div class="6u 12u$(medium)">
                <section class="box">
                    <h3>Bedwars Stats</h3>
                    <h4>Version: <?php echo $version;?> von TheSystems</h4>

                    <?php

                    $curl = curl_init();

                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://project.the-systems.eu/api/resource/?resourceid=2&type=latest",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 2,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);

                    if ($err) {
                        ?><h4>Ein Fehler beim Versions-Überprüfen ist aufgetreten.</h4><?php
                    } else {
                        $response = json_decode($response);
                        if($response->name == $version){
                            ?><h4>Du nutzt die neuste Version.</h4><?php
                        } else {
                            ?><h4>Du nutzt eine alte Version. Die neuste ist: <?php echo $response->name; ?></h4><?php
                        }
                    }

                    ?>
                    <?php
                    $curl = curl_init();
                    curl_setopt_array($curl, array(
                        CURLOPT_URL => "https://project.the-systems.eu/api/resource/?resourceid=2&type=info",
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_ENCODING => "",
                        CURLOPT_MAXREDIRS => 10,
                        CURLOPT_TIMEOUT => 2,
                        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    ));

                    $response = curl_exec($curl);
                    $err = curl_error($curl);
                    curl_close($curl);

                    if ($err) {
                        ?><h4>Ein Fehler beim Versions-Überprüfen ist aufgetreten.</h4><?php
                    } else {
                        $response = json_decode($response);
                        $support = $response->support;
                        $url = $response->url;

                    }
                    ?>
                    <p></p>
                    <p><a href="<?php echo $support; ?>" class="button">Support Discord</a></p>
                    <p><a href="<?php echo $url; ?>" class="button">Webseite</a></p>

                </section>
            </div>
            <div class="12u 12u$(medium)">
                <section class="box">

                    <h3>Top <?php echo $topplayeramount;?> Bedwars Spieler</h3>



                    <div class="table-scrollable">
                        <table>
                            <tr>
                                <th>Rang</th>
                                <th>Name</th>
                                <th></th>
                                <th>Kills</th>
                                <th>Tode</th>
                                <th>Spiele gewonnen</th>
                                <th>Spiele gespielt</th>
                                <th>Betten zerstört</th>
                                <th>Spielzeit</th>
                            </tr>
                            <?php

                            $query = "SELECT * FROM MBedwars_stats ORDER BY Rank ASC LIMIT ".$topplayeramount;
                            $result = mysqli_query($con, $query);
                            if(mysqli_num_rows($result) > 0) {
                                $num = 0;
                                while($row = mysqli_fetch_array($result)) {
                                    $rank = $row['Rank'];
                                    $name = $row['Playername'];
                                    $uuid = $row['UUID'];
                                    $kills = $row['Kills'];
                                    $deaths = $row['Deaths'];
                                    $wins = $row['Wins'];
                                    $games = $row['RoundsPlayed'];
                                    $beds = $row['BedsDestroyed'];
                                    $playtime = $row['PlayTime'];
                                    $num++;
                                    ?>
                                    <tr>
                                        <td><?php echo $rank;?>.</td>
                                        <?php
                                        if($name = "?"){
                                            $username = MojangAPI::getUsername($uuid);
                                        } else {
                                            $username = $name;
                                        }
                                        ?>
                                        <td><?php echo $username;?></td>
                                        <td><img src="https://minotar.net/helm/<?php echo $username?>/50" class="img-responsive"></td>
                                        <td><?php echo $kills;?></td>
                                        <td><?php echo $deaths;?></td>
                                        <td><?php echo $wins;?></td>
                                        <td><?php echo $games;?></td>
                                        <td><?php echo $beds;?></td>
                                        <td><?php echo $playtime;?></td>
                                    </tr>
                                    <?php
                                }
                            } else {?>
                                <tr>
                                    <td>-</td>
                                    <td>-</td>
                                    <td><img src="https://minotar.net/helm/Notch/50" class="img-responsive"></td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                </tr>

                                <?php
                            }


                            mysqli_close($con);
                            ?>
                </section>
            </div>
</section>
</div>
</section>

<script src="js/jquery.min.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/skel-layers.min.js"></script>
<script src="js/init.js"></script>
</body>
</html>
