<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
include 'conn.php';

$method = $_SERVER[ 'REQUEST_METHOD' ];

if ( $method === 'GET' ) {

    $sql = 'SELECT * FROM contact';
    $result = $conn->query( $sql );

    $contacts = [];

    if ( $result->num_rows > 0 ) {
        while ( $row = $result->fetch_assoc() ) {
            $contacts[] = $row;
        }
        echo json_encode( [ 'status' => 'success', 'data' => $contacts ] );
    } else {
        echo json_encode( [ 'status' => 'error', 'message' => 'No contact info found.' ] );
    }
}

// Add Contact
elseif ( $method === 'POST' ) {
    $data = json_decode( file_get_contents( 'php://input' ), true );

    $address = $data[ 'address' ];
    $timings = $data[ 'time' ];
    $email = $data[ 'email' ];
    $phone_no = $data[ 'phone' ];

    $sql = "INSERT INTO contact (address, time, email, phone) 
            VALUES ('$address', '$timings', '$email', '$phone_no')";

    if ( $conn->query( $sql ) === TRUE ) {
        echo json_encode( [ 'status' => 'success', 'message' => 'Contact added successfully!' ] );
    } else {
        echo json_encode( [ 'status' => 'error', 'message' => 'Failed to add contact.' ] );
    }
}

// Update Contact
elseif ( $method === 'PUT' ) {
    $data = json_decode( file_get_contents( 'php://input' ), true );

    $id = $data[ 'id' ];
    $address = $data[ 'address' ];
    $timings = $data[ 'time' ];
    $email = $data[ 'email' ];
    $phone_no = $data[ 'phone' ];

    $sql = "UPDATE contact
            SET address='$address', time='$timings', email='$email', phone='$phone_no' 
            WHERE id=$id";

    if ( $conn->query( $sql ) === TRUE ) {
        echo json_encode( [ 'status' => 'success', 'message' => 'Contact updated successfully!' ] );
    } else {
        echo json_encode( [ 'status' => 'error', 'message' => 'Failed to update contact.' ] );
    }
}

// Delete Contact
elseif ( $method === 'DELETE' ) {
    if ( isset( $_GET[ 'id' ] ) ) {
        $id = intval( $_GET[ 'id' ] );

        $sql = "DELETE FROM contact WHERE id=$id";

        if ( $conn->query( $sql ) === TRUE ) {
            echo json_encode( [ 'status' => 'success', 'message' => 'Contact deleted successfully!' ] );
        } else {
            echo json_encode( [ 'status' => 'error', 'message' => 'Failed to delete contact.' ] );
        }
    }
} else {
    echo json_encode( [ 'status' => 'error', 'message' => 'Invalid request method.' ] );
}

$conn->close();
?>
