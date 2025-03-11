

<?php
session_start();
include 'conn.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if (!isset($data['email']) || !isset($data['password'])) {
        echo json_encode(["status" => "error", "message" => "Missing email or password"]);
        exit();
    }
    $email = mysqli_real_escape_string($conn, $data['email']);
    $password = $data['password'];
    // Check if the email exists
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Verify the password (Assuming passwords are stored in plain text, but hashing is recommended)
        if ($user['password'] === $password) {
            $_SESSION['userid'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            echo json_encode(['status' => 'success', 'message' => 'Login successful!','user'=>$user['id'],'username'=>$user['name'], 'emailid' =>$user['email']]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect password.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Email not registered.']);
    }
    exit();
}
mysqli_close($conn);
?>