<?php
include('connection1.php');

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM follow WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['Follower_id'];
        $c = $row['Following_id'];
        $d = $row['Date_followed'];
    } else {
        echo "Post not found.";
    }

    $stmt->close(); // Close the statement after use
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update post</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <!-- Update products form -->
    <h2><u>Update Form of post</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
        <label for="Follower_id">Follower_id:</label>
        <input type="number" name="Follower_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="Following_id">Following_id:</label>
        <input type="text" name="Following_id" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="Date_followed">Date_followed:</label>
        <input type="date" name="Date_followed" value="<?php echo isset($d) ? $d : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $Follower_id = $_POST['Follower_id'];
    $Following_id = $_POST['Following_id'];
    $Date_followed = $_POST['Date_followed'];

    // Update the post in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE follow SET Follower_id=?, Following_id=?, Date_followed=? WHERE id=?");
    $stmt->bind_param("iisi", $Follower_id, $Following_id, $Date_followed, $id);
    $stmt->execute();

    // Redirect to post.php
    header('Location: follow.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
