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
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        require_once DIR_BASE.'./controllers/HorairesController.php';
        include_once '../../components/header.php';
    ?>
    <!-- add container where the a calendar created in html will be displayed -->
    <div class="landing" id="hor-main">
        <div class="calendar"> 
                <h2>Labo RT - Suppression Horaires</h2>
                <table>
                    <tr>
                        <th>Jour</th>
                        <th>Créneau</th>
                        <th>Activité</th>
                    </tr>
                    <?php
                    $nbdisplay=0;
                    $result = getHoraires();
                    if (empty($result)) {
                        echo "<tr>";
                        echo "<td colspan='3'>Aucun horaire n'a été trouvé.</td>";
                        echo "</tr>";
                    }
                    else {
                        usort($result, function($a, $b) {
                            $days = ['lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi', 'dimanche'];
                            $dayA = array_search(strtolower(getDayOfWeek($a[1])), $days);
                            $dayB = array_search(strtolower(getDayOfWeek($b[1])), $days);
                            return $dayA - $dayB;
                        });
                        foreach ($result as $row) {
                            $display= isDateDuringCurrentWeekOrLater($row[1]);
                            if ($display) {
                                $nbdisplay++;
                                $h1=substr($row[1],-8,5);
                                $h2=substr($row[2],-8,5);
                                $créneau = $h1 . " - " . $h2;
                                $date = substr($row[1],8,-9). "-" . substr($row[1],5,-12);
                                echo "<tr>";
                                echo "<td>" . getDayOfWeek($row[1]) ." ". $date . "</td>";
                                echo "<td>" . $créneau . "</td>";
                                echo "<td>" . $row[3] . "</td>";
                                echo "<td><a href='./confirmdeleteHoraire.php?id=".$row[0]."'>Supprimer</a></td>";
                                echo "</tr>";
                            }
                        }
                        if ($nbdisplay==0) {
                            echo "<tr>";
                            echo "<td colspan='3'>Aucun horaire n'a été trouvé.</td>";
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