<?php
session_start();
if ($_SESSION['admin_authentication'] == false) {
    header('Location: index.php');
    exit;
}

$servername = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "test";

$conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $deleteSql = "DELETE FROM stagieres WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->execute([$id]);

    // Redirect to the current page to refresh the table
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

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

        .delete-form input[type="submit"] {
            margin-right: 5px;
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
                <th>Action</th>
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
                    <td>
                        <form class="delete-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="submit" name="submit" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>