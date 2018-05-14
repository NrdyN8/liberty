<html>
<body>
<h1>Welcome <?php print($user->username); ?>!</h1>
<p>Activate your account on <?php print(APP_URL); ?> by clicking on this link <a href="<?php print(APP_URL.'/activate?key='.$activation_key); ?>"><?php print(APP_URL.'/activate?key='.$activation_key); ?></a></p>
</body>
</html>