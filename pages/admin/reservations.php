<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../../assets/css/style.css" rel="stylesheet">
    <title>LaboRT</title>
    <favicon>
        <link rel="icon" type="image/png" href="../../assets/img/Labo.png" />
    </favicon>
</head>

<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
    require_once DIR_BASE . './controllers/ReservationActiviteController.php';
    require_once DIR_BASE . './controllers/HorairesController.php';
    require_once DIR_BASE . './controllers/UserController.php';
    include '../../components/header.php';
    ?>
    <!-- add container where the a calendar created in html will be displayed -->
    <div class="landing" id="hor-main">
        <div class="calendar">
            <h2>Labo RT - Suppression Réservations</h2>
            <table>
                <tr>
                    <th>Etudiant</th>
                    <th>Jour</th>
                    <th>Créneau</th>
                    <th>Description</th>
                    <th>Nombre Etudiants</th>
                </tr>
                <?php
                $nbdisplay = 0;
                $result = getReservationActivite();
                if (empty($result)) {
                    echo "<tr>";
                    echo "<td colspan='3'>Aucune réservation n'a été trouvé.</td>";
                    echo "</tr>";
                } else {
                    usort($result, function ($a, $b) {
                        $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
                        $dayA = array_search(strtolower(getDayOfWeek($a[2])), $days);
                        $dayB = array_search(strtolower(getDayOfWeek($b[2])), $days);
                        return $dayA - $dayB;
                    });
                    foreach ($result as $row) {
                        $h1 = substr($row[2], -8, 5);
                        $h2 = substr($row[3], -8, 5);
                        $créneau = $h1 . " - " . $h2;
                        $date = substr($row[2], 8, -9) . "-" . substr($row[3], 5, -12);
                        echo "<tr>";
                        echo "<td>" . getUserName($row[1]) . "</td>";
                        echo "<td>" . getDayOfWeek($row[1]) . " " . $date . "</td>";
                        echo "<td>" . $créneau . "</td>";
                        echo "<td>" . $row[4] . "</td>";
                        echo "<td>" . $row[5] . "</td>";
                        echo "<td><a href='./confirmdeleteResa.php?id=" . $row[0] . "'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                }
                ?>
            </table>
        </div>
    </div>
    <!-- add footer -->
    <?php
    include DIR_BASE.'components/footer.php';
    ?>
</body>

</html>