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

// Login logic
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Use prepared statement to prevent SQL injection
        $stmt = $pdo->prepare("SELECT * FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($admin && password_verify($password, $admin['password'])) {
            // Set session for authenticated admins
            $_SESSION['admin'] = ['id' => $admin['id'], 'username' => $admin['username']];
            // Redirect to user's dashboard or any other page
            header('Location: index.php');
            exit();
        } else {
            $loginError = "Invalid username or password";
        }
    } catch (PDOException $e) {
        $loginError = "Login failed: " . $e->getMessage();
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
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

   <title>Matin Library | Admin</title>

   <style>
      body {
         background-color: #f8f9fa;
         display: flex;
         align-items: center;
         justify-content: center;
         height: 100vh;
         margin: 0;
      }

      .card {
         width: 300px;
         padding: 20px;
         border-radius: 10px;
         box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      }

      .card h3 {
         text-align: center;
      }

      .form-group {
         margin-bottom: 20px;
      }

      .btn-login {
         width: 100%;
      }

      p {
         text-align: center;
         margin-top: 20px;
      }
   </style>
</head>

<body>
   <div class="card">
      <h3>WELCOME ADMIN</h3>
      <p>Hello Admin ! Login Here !</p>

      <?php if (isset($loginError)): ?>
         <div class="alert alert-danger" role="alert">
            <?php echo $loginError; ?>
         </div>
      <?php endif; ?>

      <form action="" method="post">
         <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" name="username" placeholder="Username" required>
         </div>

         <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
         </div>

         <button type="submit" class="btn btn-success btn-login" name="login">LOGIN</button>

      </form>

      <p>Don't have an account? <a href="registeradmin.php">Register here</a></p>
   </div>

   <!-- Bootstrap -->
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>

</html>
