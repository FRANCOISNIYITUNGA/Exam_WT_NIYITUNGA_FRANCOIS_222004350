<?php
include('connection1.php');

// Check if Product_Id is set
if (isset($_REQUEST['id'])) {
    $id = $_REQUEST['id'];
    // Prepare statement with parameterized query to prevent SQL injection (security improvement)
    $stmt = $connection->prepare("SELECT * FROM post WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $b = $row['User_id'];
        $c = $row['Content'];
        $d = $row['Date_posted'];
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
        <label for="sender_id">sender_id:</label>
        <input type="number" name="sender_id" value="<?php echo isset($b) ? $b : ''; ?>">
        <br><br>

        <label for="receiver_id">receiver_id:</label>
        <input type="text" name="receiver_id" value="<?php echo isset($c) ? $c : ''; ?>">
        <br><br>

        <label for="content">content:</label>
        <input type="text" name="content" value="<?php echo isset($d) ? $d : ''; ?>">
        <br><br>

        <input type="submit" name="up" value="Update">
    </form>
</body>
</html>

<?php
if (isset($_POST['up'])) {
    // Retrieve updated values from form
    $sender_id = $_POST['sender_id'];
    $receiver_id = $_POST['receiver_id'];
    $content = $_POST['content'];

    // Update the post in the database (prepared statement again for security)
    $stmt = $connection->prepare("UPDATE message SET sender_id=?, receiver_id=?, content=? WHERE id=?");
    $stmt->bind_param("issi", $sender_id, $receiver_id, $content, $id);
    $stmt->execute();

    // Redirect to post.php
    header('Location: message.php');
    exit(); // Ensure no other content is sent after redirection
}

// Close the connection (important to close after use)
mysqli_close($connection);
?>
