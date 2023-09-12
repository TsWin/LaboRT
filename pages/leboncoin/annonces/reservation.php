<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Reservation</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
    <!-- <script defer src='../../../assets/js/annonce.js'></script> -->
    <!-- add fontawesom icons -->
    <script src="https://kit.fontawesome.com/df14dc0e3c.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
        include_once DIR_BASE.'layout/LeboncoinNav.php';
        require_once DIR_BASE.'controllers/AnnoncesController.php';
        require_once DIR_BASE.'controllers/ReservationController.php';
        require_once DIR_BASE.'controllers/AuthController.php';
        
        if(isset($_GET['ticket'])){
            login('leboncoin/annonces/reservation', $_GET['ticket'], false);
        } else {
            login('leboncoin/annonces/reservation', null, false);
        }
        if (checkLogin()) {
            $user = getUserWithToken($_COOKIE['token']);
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $annonce = getAnnonce($id);
                if ($annonce == null) {
                    header('Location: index.php');
                }
            } else {
                header('Location: index.php');
            }
    
            if ($annonce['stock'] == 0) {
                header('Location: '.errorURL.'4016');
            } else if (checkOwnerAnnonce($id)) {
                header('Location: '.errorURL.'4017');
            } else {
                $reservation = array(
                    'idrefannonce' => $id,
                    'idrefetatreservation' => 2,
                    'idrefetu' => $user['idetu'],
                    'datecreation' => date('Y-m-d H:i:s')
                );
    
                createReservation($reservation);
                decreaseStockAnnonce($id);
    
                header('Location: index.php');
            }
        }

    ?>
</body>
</html>