<?php
session_start();
require_once 'config.php';

$error = '';

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

            $_SESSION['user_id']  = (int)$user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role']     = $user['role'];

            if ($user['role'] == 1) {
                header("Location: admin/index.php");
                exit;
            } elseif ($user['role'] == 2) {
                header("Location: cart.php");
                exit;
            } else {
                $error = "Role not recognized.";
            }
        } else {
            $error = "Invalid username or password.";
        }

        mysqli_stmt_close($stmt);
    } else {
        $error = "Database error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<?php include('head.php'); ?>
<body>
<?php include('nav_main.php'); ?>

<div class="container mt-5 pt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Login</h2>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Email or Username</label>
            <input type="text" class="form-control" id="username" name="username"
                   placeholder="Enter your email or username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password"
                   placeholder="Enter password" required>
        </div>
        <button type="submit" class="btn btn-success w-100">Login</button>
    </form>
</div>

<?php include('footer.php'); ?>
</body>
</html>
