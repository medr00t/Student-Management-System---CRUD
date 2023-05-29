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

$sql = "SELECT * FROM stagieres";
$stmt = $conn->query($sql);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $nickname = $_POST['nickname'];
    $cne = $_POST['cne'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $H_password = hash("sha256", $password);

    $updateSql = "UPDATE stagieres SET name = ?, nickname = ?, CNE = ?, email = ?, password = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateSql);
    try {
        $updateStmt->execute([$name, $nickname, $cne, $email, $H_password, $id]);
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "Try again. This CNE or EMAIL is already registered.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

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

        .edit-form input[type="submit"] {
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
                        <form class="edit-form" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <input type="text" name="name" value="<?php echo $row['name']; ?>">
                            <input type="text" name="nickname" value="<?php echo $row['nickname']; ?>">
                            <input type="text" name="cne" value="<?php echo $row['CNE']; ?>">
                            <input type="text" name="email" value="<?php echo $row['email']; ?>">
                            <input type="text" name="password" value="<?php echo $row['password']; ?>">
                            <input type="submit" name="submit" value="Done">
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>