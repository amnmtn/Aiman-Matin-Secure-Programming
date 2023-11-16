<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $db = new DB();
    $result = $db->executeQuery("SELECT * FROM books WHERE id = $id");
    $row = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $author = $_POST['author'];
    $publisher = $_POST['publisher'];
    $isbnnumber = $_POST ['ISBN Number'];
    $version = $_POST['version'];
    $shelf = $_POST['shelf'];

    $db = new DB();
    $query = "UPDATE books SET title='$title', author='$author', publisher='$publisher', ISBN='$ISBN', version='$version', shelf='$shelf' WHERE id=$id";
    $db->executeQuery($query);

    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Book</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h2>Edit Book</h2>
<form method="post">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label>Title:</label>
    <input type="text" name="title" value="<?php echo $row['title']; ?>" required><br>

    <label>Author:</label>
    <input type="text" name="author" value="<?php echo $row['author']; ?>" required><br>

    <label>Publisher:</label>
    <input type="text" name="publisher" value="<?php echo $row['publisher']; ?>" required><br>

    <label>ISBN:</label>
    <input type="text" name="ISBN" value="<?php echo $row['ISBN']; ?>" required><br>

    <label>Version:</label>
    <input type="text" name="version" value="<?php echo $row['version']; ?>" required><br>

    <label>Shelf:</label>
    <input type="text" name="shelf" value="<?php echo $row['shelf']; ?>" required><br>

    <input type="submit" value="Update Book">
</form>

</body>
</html>