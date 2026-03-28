<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

defined('LOCALHOST') ? null : define('LOCALHOST', 'localhost');
defined('USERNAME')  ? null : define('USERNAME', 'root');
defined('PASSWORD')  ? null : define('PASSWORD', '');
defined('DBNAME')    ? null : define('DBNAME', 'eBus');

$conn = mysqli_connect(LOCALHOST, USERNAME, PASSWORD, DBNAME) or die("Connection to DB failed");


function connection() {
    global $conn;
    return $conn;
}

function query($str) {
    global $conn;
    return mysqli_query($conn, $str);
}

function check($results) {
    global $conn;
    if (!$results) {
        echo mysqli_error($conn);
    }
}

function getAllProducts() {
    global $conn;
    $query = "SELECT * FROM products_db";
    return mysqli_query($conn, $query);
}

function getProductById($id) {
    global $conn;
    $id = intval($id);
    $query = "SELECT * FROM products_db WHERE id = $id";
    return mysqli_query($conn, $query);
}

function getProductsByCategory($category) {
    global $conn;
    $category = mysqli_real_escape_string($conn, $category);
    $query = "SELECT * FROM products_db WHERE category = '$category'";
    return mysqli_query($conn, $query);
}

function getAllCategories() {
    global $conn;
    $query = "SELECT DISTINCT category FROM products_db";
    return mysqli_query($conn, $query);
}

function getCategories() {
    global $conn;
    $q = "SELECT id, name, category FROM products_db ORDER BY id ASC";
    $results = mysqli_query($conn, $q);

    echo "<table class='table table-striped'>";
    echo "<thead><tr>
            <th>ID</th>
            <th>Category</th>
            <th>Product Name</th>
            <th>Modify</th>
            <th>Delete</th>
          </tr></thead><tbody>";

    while ($row = mysqli_fetch_assoc($results)) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td>{$row['category']}</td>";
        echo "<td>{$row['name']}</td>";
        echo "<td><a href='categories.php?edit={$row['id']}' class='btn btn-sm btn-primary'><i class='fas fa-edit'></i></a></td>";
        echo "<td><a href='categories.php?delete={$row['id']}' onclick=\"return confirm('Are you sure?')\" class='btn btn-sm btn-danger'><i class='fas fa-trash'></i></a></td>";
        echo "</tr>";
    }

    echo "</tbody></table>";
}

function login() {
    if (isset($_POST['submit'])) {
        global $conn;
        $user = $_POST['username'];
        $pass = $_POST['password'];

        $result = query("SELECT * FROM users 
                         WHERE (username='{$user}' OR username='{$user}') 
                         AND password='{$pass}'");

        if (!$result || mysqli_num_rows($result) == 0) {
            echo "Username or Password incorrect!!";
        } else {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['email']    = $row['username']; 
        }
    }
}
?>
