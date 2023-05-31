<?php
declare(strict_types=1);

require_once(__DIR__ . '/../session.php');
$session = new Session();

require_once(__DIR__ . '/../db/connection.php');
require_once(__DIR__ . '/../db/account.php');

$db = getdbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $account = Account::signup($db, $username, $email, $password);

    if ($account !== null) {
        $session->setId($account->getId());
        $session->setUsername($account->getUsername());
        $session->setEmail($account->getEmail());
        $session->addMessage('success', 'Signup successful!');
        header('Location: /../pages/authentication.php');
        exit();
    } else {
        $session->addMessage('error', 'Username or email already exists.');
    }
}

header('Location: /../pages/authentication.php');
?>
