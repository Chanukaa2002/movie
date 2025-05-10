<?php
include('connect.php');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
        exit;
    }

    $sql = "SELECT * FROM `users` WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        echo json_encode([
            'status' => 'success',
            'message' => 'Login successful',
            'user' => [
                'userid' => $data['userid'],
                'email' => $data['email'],
                'role' => $data['roteype']
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Only POST method allowed']);
}
?>
