<?php
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id = $_GET['id'];

    $db = new DB();
    $db->executeQuery("DELETE FROM users WHERE id = $id");

    header('Location: index.php');
}
?>