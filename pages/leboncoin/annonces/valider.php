<meta charset='utf-8'>
<meta http-equiv='X-UA-Compatible' content='IE=edge'>
<title>Changer l'état d'une annonce</title>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' type='text/css' media='screen' href='../../../assets/css/leboncoin.css'>
</head>
<body>
    <?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/config.php';
    include_once DIR_BASE.'layout/LeboncoinNav.php';
    require_once DIR_BASE.'controllers/AnnoncesController.php';

    if(isset($_GET['ticket'])){
        login('leboncoin/annonces/create', $_GET['ticket'], true);
    } else {
        login('leboncoin/annonces/create', null, true);
    }
    
    if (isset($_POST['confirm']) && isset($_GET['id'])) {     
        $id = $_GET['id'];
        if ($_POST['confirm'] === 'Oui') {
            $id = $_GET['id'];
            updateEtatAnnonce($id, 3);
            header('Location: '.homeLeboncoin.'compte/admin/approuver.php');
            exit;
        } else {
            header('Location: '.homeLeboncoin.'compte/admin/afficheAnnonceValider.php?id=' . $id);
            exit;
        }  
    } else if (isset($_GET['id'])) {
        $id = $_GET['id'];
        echo '<div class="container">';
        echo '<div class="delete-container">';
        echo '<p>Etes vous sur de vouloir changer l\'état de cette annonce ?</p>';
        echo '<form method="post">';
        echo '<button class="delete-button" name="confirm" value="Oui" type="submit">Oui</button>';
        echo '<a class="delete-button" href="'.homeLeboncoin.'compte/admin/afficheAnnonceValider.php?id=' . $id . '">Non</a>';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    } else {
        header('Location: '.homeLeboncoin.'annonces/');
        exit;
    }
    ?>
