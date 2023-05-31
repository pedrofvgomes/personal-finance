<?php
declare(strict_types=1);

require_once(__DIR__ . '/../session.php');
$session = new Session();

require_once(__DIR__ . '/../db/connection.php');
require_once(__DIR__ . '/../db/account.php');

$db = getdbconnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usernameEmail = $_POST['usernameemail'];
    $password = $_POST['password'];

    $user = Account::login($db, $usernameEmail, $password);

    if ($user) {
        $session->setId($user->getId());
        $session->setUsername($user->getUsername());
        $session->setEmail($user->getEmail());
        $session->addMessage('success', 'Login successful!');
        header('Location: /../pages/profile.php');
        exit();
    } else {
        $session->addMessage('error', 'Username/email or password is incorrect.');
    }
}

header('Location: /../pages/authentication.php');
?>
