<?php
session_start();
include 'conn.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    if (isset($_GET['category'])) {
        $category_id = intval($_GET['category']);
        $sql = "SELECT * FROM category";
    } elseif (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT * FROM category WHERE id = '$id'";
    } else {
        $sql = 'SELECT * FROM category';
    }

    $result = $conn->query($sql);
    $categorys = [];

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $categorys[] = $row;
        }
        echo json_encode($categorys);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No categorys found.']);
    }
}
$conn->close();
?>