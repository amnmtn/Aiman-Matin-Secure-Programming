<?php
// Start the session
session_start();

// Connect to the database
$host = 'localhost';
$dbname = 'matin_library';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Registration logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        $registrationSuccess = true;
    } catch (PDOException $e) {
        $registrationError = "Registration failed: " . $e->getMessage();
    }
}

// Admin view users logic
if (isset($_SESSION['admin']) && $_SESSION['admin'] && isset($_GET['action']) && $_GET['action'] === 'view_users') {
    try {
        $stmt = $pdo->query("SELECT * FROM users");
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        $adminError = "Error fetching users: " . $e->getMessage();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Admin</title>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .navbar {
            background-color: #00ff55;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            color: white;
            text-align: center;
        }

        .btn-dark,
        .btn-success,
        .btn-danger {
            background-color: #343a40;
            color: #fff;
            transition: background-color 0.3s;
        }

        .btn-dark:hover {
            background-color: #555;
        }

        .btn-success:hover {
            background-color: #218838;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        .table {
            background-color: #fff;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .table th,
        .table td {
            text-align: center;
        }

        .link-dark {
            color: #000 !important;
            text-decoration: none;
            transition: color 0.3s;
        }

        .link-dark:hover {
            color: #555 !important;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fs-3" href="#">MATIN LIBRARY</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>
</nav>

    <div class="container">
        <div>
            <a href="add_book.php" class="btn btn-dark mb-3">Add New Books</a>
            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Title</th>
                        <th scope="col">Author</th>
                        <th scope="col">Publisher</th>
                        <th scope="col">ISBN</th>
                        <th scope="col">Version</th>
                        <th scope="col">Shelf</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Fetch and display list of books
                    $stmtBooks = $pdo->query("SELECT * FROM books");
                    while ($row = $stmtBooks->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?php echo $row["id"] ?></td>
                            <td><?php echo $row["title"] ?></td>
                            <td><?php echo $row["author"] ?></td>
                            <td><?php echo $row["publisher"] ?></td>
                            <td><?php echo $row["ISBN"] ?></td>
                            <td><?php echo $row["version"] ?></td>
                            <td><?php echo $row["shelf"] ?></td>
                            <td>
                                <a href="edit_book.php?id=<?php echo $row["id"] ?>" class="link-dark"><i
                                        class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                                <a href="delete_book.php?id=<?php echo $row["id"] ?>" class="link-dark"><i
                                        class="fa-solid fa-trash fs-5"></i></a>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div>
            <a href="add_users.php" class="btn btn-dark mb-3
            <div>
        <a href="add_users.php" class="btn btn-dark mb-3">Add New User</a>
        <table class="table table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Username</th>
                    <th scope="col">Password</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch and display list of users
                $stmtUsers = $pdo->query("SELECT * FROM users");
                while ($row = $stmtUsers->fetch(PDO::FETCH_ASSOC)) {
                    ?>
                    <tr>
                        <td><?php echo $row["id"] ?></td>
                        <td><?php echo $row["username"] ?></td>
                        <td><?php echo $row["password"] ?></td>
                        <td>
                            <a href="edit_users.php?id=<?php echo $row["id"] ?>" class="link-dark"><i
                                    class="fa-solid fa-pen-to-square fs-5 me-3"></i></a>
                            <a href="delete_user.php?id=<?php echo $row["id"] ?>" class="link-dark"><i
                                    class="fa-solid fa-trash fs-5"></i></a>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
        <a href="adminlogin.php" class="GFG">Logout Here !</a>
    </div>