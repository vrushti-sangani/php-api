<?php
session_start();
include 'conn.php';
header( 'Content-Type: application/json' );

$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( $method === 'GET' ) {
    if ( isset( $_GET[ 'category' ] ) ) {
        $category_id = intval( $_GET[ 'category' ] );
        $sql = "SELECT * FROM product WHERE category_id = '$category_id'";
    } elseif ( isset( $_GET[ 'id' ] ) ) {
        $id = intval( $_GET[ 'id' ] );
        $sql = "SELECT * FROM product WHERE id = '$id'";
    } else {
        $sql = 'SELECT * FROM product';
    }

    $result = $conn->query( $sql );
    $products = [];

    if ( $result->num_rows > 0 ) {
        while ( $row = $result->fetch_assoc() ) {
            $products[] = $row;
        }
        echo json_encode( $products );
    } else {
        echo json_encode( [ 'status' => 'error', 'message' => 'No products found.' ] );
    }
}

$conn->close();
?>