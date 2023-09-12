<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../assets/css/style.css" rel="stylesheet">
    <script defer src="../assets/js/event.js"></script>
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
    <title>LaboRT - Événements à venir</title>
    <favicon>
        <link rel="icon" type="image/png" href="../assets/img/Labo.png"/>
    </favicon>
</head>
<body class="background-gradient">
    <?php 
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        require_once DIR_BASE.'./controllers/EventsController.php';
        include '../components/header.php';
    ?>
    <div class="landing" id="event-main">
        <div class="text-box" id="space-top">
            <h1>Labo RT - Événements à venir</h1>
            <div class="card-container">
                <?php 
                    $events = getEvents();
                    if (empty($events)) {
                        echo '<div class="card">';
                        echo '<h2>Erreur</h2>';
                        echo '<div id="rotate-arrow">';
                        echo '<i class="fa-solid fa-arrow-rotate-right fa-flip" style="--fa-animation-duration: 5s; color: #000000;"></i>';
                        echo '</div>';
                        echo '<div class="description">';
                        echo '<p class="description-content">Une erreur est survenue lors de la récupération des événements.</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    else {
                        foreach ($events as $event) {
                            $date = $event['date'];
                            $isPast = isDatePast($date);
                            if ($isPast) {
                                echo '<div class="card">';
                                echo '<h2>'.$event['nom'].'</h2>';
                                echo '<div id="rotate-arrow">';
                                echo '<i class="fa-solid fa-arrow-rotate-right fa-flip" style="--fa-animation-duration: 5s; color: #000000;"></i>';
                                echo '</div>';
                                echo '<div class="description">';
                                echo '<p class="description-content">'.$event['date'].'</p>';
                                echo '<p class="description-content">'.$event['description'].'</p>';
                                echo '</div>';
                                echo '</div>';
                            }
                            
                        }
                    }
                ?>
            </div>
        </div>
    </div>
    <!-- Ajouter le footer -->
    <?php 
        include '../components/footer.php';
    ?>
</body>
</html>
