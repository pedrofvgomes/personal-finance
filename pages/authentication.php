<?php
    declare(strict_types=1);    
    require_once(__DIR__ . '/../templates/auth_template.php');
    require_once(__DIR__ . '/../session.php');

    $session = new Session();

    draw_head();
    draw_auth();
    draw_alerts($session);
?>