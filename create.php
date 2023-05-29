<?php
session_start();
if ($_SESSION['admin_authentication'] == false) {
    header('Location: index.php');
    exit;
} elseif (isset($_POST['submit'])) {
    // change it here too :) ... 
    $servername = "localhost";
    $db_username = "root";
    $db_password = "root";
    $db_name = "test";

    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $cne = $_POST['cne'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $H_password = hash("sha256", $password);


    $sql = "INSERT INTO stagieres (name, nickname, CNE, email, password) VALUES ('$name', '$nickname', '$cne', '$email', '$H_password')";

    if (!empty($name) && !empty($nickname) && !empty($cne) && !empty($email) && !empty($password)) {
        try {
            $conn->exec($sql);
            echo "Data inserted successfully.";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                echo "Try again. This CNE or EMAIL is already registered.";
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
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
    <a href='accueil.php'>Accueil</a>

    <?php if (!isset($_POST['submit']) || (isset($_POST['submit']))) : ?>
        <form action="create.php" method="post">
            Name <input type="text" name="name" required placeholder="name"><br>
            Nickname <input type="text" name="nickname" required placeholder="nickname"><br>
            CNE <input type="text" name="cne" required placeholder="cne"><br>
            Email <input type="text" name="email" required placeholder="email"><br>
            Password <input type="password" name="password" required placeholder="password"><br><br><br>
            <input type="submit" name="submit" value="ADD"><br>
        </form>
    <?php endif; ?>


</body>

</html>
