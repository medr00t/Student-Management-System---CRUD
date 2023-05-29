<?php
// starting the session
session_start();
if ($_SESSION['admin_authentication'] == false) {
    header('Location: index.php');
    exit;
}

if (isset($_POST['create'])) {
    header("location: create.php");
} elseif (isset($_POST['read'])) {
    header("location: read.php");
} elseif (isset($_POST['update'])) {
    header("location: update.php");
} elseif (isset($_POST['delete'])) {
    header("location: delete.php");
}
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
    <h1>Random words</h1>
    <?php
    echo "<h3>Hello {$_SESSION['admin_name']} !</h3>";
    ?>
    <form action="accueil.php" method="post">
        <input type="submit" name="create" value="create">
        <input type="submit" name="read" value="read">
        <input type="submit" name="update" value="update">
        <input type="submit" name="delete" value="delete">
    </form>

</body>

</html>