<!-- Example of ticket: Ticket: ST-1043954-AdR2dDe7slNoiwDyBbyg-cas-uds.grenet.fr  -->
<!-- Create a simple page to add ticket  -->
<!-- https://cas-uds.grenet.fr/login?service=http%3A%2F%2Fsrv-prj-new.iut-acy.local%2FRT%2FA23%2Fauth.php -->

<?php
// Path: auth.php
// Example of ticket: Ticket: ST-1043954-AdR2dDe7slNoiwDyBbyg-cas-uds.grenet.fr
// Create a simple page to add ticket

// Get the ticket
// $ticket = $_GET['ticket'];
if (isset($_GET['ticket'])) {
    $ticket = $_GET['ticket'];
} else {
    header('Location: https://cas-uds.grenet.fr/login?service=http%3A%2F%2Fsrv-prj-new.iut-acy.local%2FRT%2FA23%2Fauth.php');
}

$url = 'https://cas-uds.grenet.fr/serviceValidate?service=http%3A%2F%2Fsrv-prj-new.iut-acy.local%2FRT%2FA23%2Fauth.php&ticket='.$ticket;
$response = file_get_contents($url);
if (preg_match('/cas:authenticationSuccess/', $response)) {
    echo 'Utilisateur authentifié';
} else {
    echo 'Utilisateur non authentifié';
}

?>