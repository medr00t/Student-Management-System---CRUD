<?php
session_start();
$_SESSION['admin_authentication'] = false;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
</head>

<body>
    <form action="authenticate.php" method="post">
        Username<input type="text" name="Username"><br>
        Password<input type="password" name="Password"><br>
        <input type="submit" value="submit">
    </form>
</body>

</html>