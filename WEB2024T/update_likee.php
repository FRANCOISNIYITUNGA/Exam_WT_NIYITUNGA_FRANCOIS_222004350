<?php
include('connection1.php');

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM likee WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['post_id'];
        $c = $row['user_id'];
        $d = $row['date_liked'];
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
        <label for="post_id">post_id:</label>
        <input type="number" name="post_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="user_id">user_id:</label>
        <input type="number" name="user_id" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="date_liked">date_liked:</label>
        <input type="date" name="date_liked" value="<?php echo isset($d) ? $d : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $date_liked = $_POST['date_liked'];

    // Update the post in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE likee SET post_id=?, user_id=?, date_liked=? WHERE id=?");
    $stmt->bind_param("iisi", $post_id, $user_id, $date_liked, $id);
    $stmt->execute();

    // Redirect to post.php
    header('Location: like.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
