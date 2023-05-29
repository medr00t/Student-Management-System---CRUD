<?php
session_start();
if ($_SESSION['admin_authentication'] == false) {
    header('Location: index.php');
    exit;
}
// and here :| ....
$servername = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "test";

$conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);

$sql = "SELECT * FROM stagieres";
$stmt = $conn->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            border: 2px solid #ccc;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f2f2f2;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e0e0e0;
        }
    </style>
</head>

<body>
    <a href='accueil.php'>Accueil</a>
    <h2>Stagieres</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Nickname</th>
                <th>CNE</th>
                <th>Email</th>
                <th>Password</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row) : ?>
                <tr>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['nickname']; ?></td>
                    <td><?php echo $row['CNE']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['password']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
