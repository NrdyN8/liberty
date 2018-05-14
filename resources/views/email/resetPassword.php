<html>
<body>
<h1>Password reset <?php print($user->username); ?></h1>
<p>Follow this link to reset your password:</p>
<a href="<?php print(APP_URL.'/resetPassword?key='.$password_key); ?>"><?php print(APP_URL.'/resetPassword?key='.$password_key); ?></a>
</body>
</html>