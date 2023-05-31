<?php function draw_head()
{ ?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <title>Authentication</title>
        <link href='/../style/style.css' rel='stylesheet'>
    </head>

    <body>
<?php } ?>

<?php function draw_auth() { ?>
<div id="auth">
    <form id="login" class="auth" method="post" action="/../actions/login.php">
        <h2>Already have an account? Welcome back!</h2>
        <span class='input-name'>username / e-mail</span>
        <input type="text" name="usernameemail" autocomplete="off">
        <span class='input-name'>password</span>
        <input type="password" name="password" autocomplete="off">
        <input type="submit" value="Sign in">
    </form>

    <form id="signup" class="auth" method="post" action="/../actions/signup.php">
        <h2>New here? Join us!</h2>
        <span class='input-name'>username</span>
        <input name="username" type="text" autocomplete="off">
        <span class='input-name'>e-mail</span>
        <input name="email" type="email" autocomplete="off">
        <span class='input-name'>password</span>
        <input name="password" type="password" autocomplete="off">
        <input type="submit" value="Sign up">
    </form>
</div>
</body>

</html>
<?php } ?>

<?php function draw_alerts(Session $session){
    $messages = $session->getMessages();

    foreach ($messages as $message) {
        if ($message['type'] === 'error') {
            echo '<script>window.onload = function() { alert("' . $message['text'] . '"); };</script>';
        }
    }

}
?>