<?php
// starting the session
session_start();

//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// U SHOULD HAVE TO ENTER YOUR DB INFORMATION INCLUDING THE TABLE NAME ! //
// and create a  table called admin in ur DB and add the useranme and the password :) 
//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

// Connect to the DB
$servername = "****";
$db_username = "***";
$db_password = "****";
$db_name = "****";

$name = $_POST['Username'];
$password = $_POST['Password'];
$_SESSION['admin_name'] = $name;

// delete the whiteSpaces
$name = trim($name);
$password = trim($password);

// hashing the password using "Sha256" algo
$H_password = hash("sha256", strtolower($password));


$conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
$stmt = $conn->prepare("SELECT username, password FROM admin");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($result as $row) {
    $Cusername = $row['username'];
    $Cpassword = $row['password'];

    if ($Cusername == $name) {
        if ($Cpassword == $H_password) {
            $_SESSION['admin_authentication'] = true;
            header("Location: accueil.php");
            exit;
        }
    }
}

header("Location: index.php");
$_SESSION['admin_authentication'] = false;
exit();
