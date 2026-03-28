<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $sql = "SELECT user_id, username, password, role FROM users WHERE username = ? AND password = ?";
    if ($stmt = mysqli_prepare($conn, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);

        if ($res && mysqli_num_rows($res) === 1) {
            $user = mysqli_fetch_assoc($res);
            $_SESSION['user_id'] = (int)$user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] == 1) {
                header("Location: admin/index.php");
                exit;
            } elseif ($user['role'] == 2) {
                header("Location: cart.php");
                exit;
            } else {
                echo "<p>Unknown role. Contact support.</p>";
                exit;
            }
        } else {
            echo "<p style='color:red;'>Invalid username or password.</p>";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "<p style='color:red;'>Database error. Try again later.</p>";
    }
}
?>
