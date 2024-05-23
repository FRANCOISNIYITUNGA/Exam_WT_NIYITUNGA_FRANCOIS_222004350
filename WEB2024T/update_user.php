<?php
include('connection1.php');

// Check if id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare a statement with a parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['name'];
        $c = $row['email'];
        $d = $row['password'];
    } else {
        echo "User not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update User</title>
    <!-- JavaScript validation and content load for updating or modifying data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update user form -->
    <h2><u>Update User Form</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="name">Name:</label>
        <input type="text" name="name" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="password">Password:</label>
        <input type="password" name="password" value="<?php echo isset($d) ? $d : ''; ?>">
        <br><br>

        <input type="submit" name="update" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['update'])) {
    // Retrieve updated values from the form
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Update the user in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE users SET name=?, email=?, password=? WHERE id=?");
    $stmt->bind_param("sssi", $name, $email, $password, $id);
    $stmt->execute();

    // Redirect to the page where users are listed
    header('Location: user.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
