<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home Page</title>
  <link rel="stylesheet" href="css/style.css">
  <style>
    body {
      background-image: url("images/conflict_pic3.jpeg");
      background-size: cover;
      background-repeat: no-repeat;
    }
    header {
      background-color: #333;
      padding: 10px;
    }
    header ul {
      list-style-type: none;
      padding: 0;
      margin: 0;
    }
    header ul li {
      display: inline;
      margin-right: 10px;
    }
    header ul li a {
      color: #fff;
      text-decoration: none;
      padding: 8px 12px; /* Medium padding */
    }
    .dropdown {
      position: relative;
      display: inline-block;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      background-color: #333;
      min-width: 120px;
      z-index: 1;
    }
    .dropdown:hover .dropdown-content {
      display: block;
    }
  </style>
</head>
<body>
  <header>
    <form class="d-flex" role="search" action="search.php" method="GET">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    <ul>
      <li><img src="images/conflic_pic5.jpeg" width="90" height="75" alt="Logo"></li>
      <li><a href="./home.html">HOME</a></li>
      <li><a href="./about.html">ABOUT</a></li>
      <li><a href="./contact.html">CONTACT</a></li>
      <li><a href="./tag.php">Tag</a></li>
      <li><a href="./profile.php">Profile</a></li>
      <li><a href="./post_tag.php">Post Tag</a></li>
      <li><a href="./user.php">user</a></li>
      <li><a href="./post.php">Post</a></li>
      <li><a href="./notification.php">Notification</a></li>
      <li><a href="./message.php">Message</a></li>
      <li><a href="./like.php">Like</a></li>
      <li><a href="./follow.php">Follow</a></li>
      <li><a href="./comment.php">Comment</a></li>
      <li class="dropdown">
        <a href="#" style="padding: 10px; color: white; background-color: skyblue; text-decoration: none; margin-right: 15px;">Settings</a>
        <div class="dropdown-content">
          <a href="index.html">Login</a>
          <a href="register.html">Register</a>
          <a href="logout.php">Logout</a>
        </div>
      </li>
    </ul>
  </header>
  <section>
    <h1>Follow Form</h1>
    <form method="post" onsubmit="return confirmInsert();" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <label for="id">ID:</label>
      <input type="number" id="id" name="id"><br><br>

      <label for="Follower_id">Follower ID:</label>
      <input type="number" id="Follower_id" name="Follower_id" required><br><br>

      <label for="Following_id">Following ID:</label>
      <input type="number" id="Following_id" name="Following_id" required><br><br>

      <label for="Date_followed">Date Followed:</label>
      <input type="date" id="Date_followed" name="Date_followed" required><br><br>

      <input type="submit" name="add" value="Insert">
    </form>

    <?php
    // Connection details
    include('connection1.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Prepare and bind parameters with appropriate data types
      $stmt = $connection->prepare("INSERT INTO follow (id, Follower_id, Following_id, Date_followed) VALUES (?, ?, ?, ?)");
      $stmt->bind_param("iiss", $id, $Follower_id, $Following_id, $Date_followed);

      // Set parameters from POST data with validation (optional)
      $id = intval($_POST['id']); // Ensure integer for ID
      $Follower_id = htmlspecialchars($_POST['Follower_id']); // Prevent XSS
      $Following_id = htmlspecialchars($_POST['Following_id']); // Prevent XSS
      $Date_followed = htmlspecialchars($_POST['Date_followed']); // Prevent XSS
      // Execute prepared statement with error handling
      if ($stmt->execute()) {
        echo "New record has been added successfully!";
      } else {
        echo "Error: " . $stmt->error;
      }

      $stmt->close();
    }

    $connection->close();
    ?>

    <h2>Table of Follow</h2>
    <table border="5">
      <tr>
        <th>ID</th>
        <th>Follower ID</th>
        <th>Following ID</th>
        <th>Date Followed</th>
        <th>Delete</th>
        <th>Update</th>
      </tr>
      <?php
      // Connection details
      include('connection1.php');

      // SQL query to fetch data from follow table
      $sql = "SELECT * FROM follow";
      $result = $connection->query($sql);

      // Check if there are any profiles
      if ($result->num_rows > 0) {
        // Output data for each row
        while ($row = $result->fetch_assoc()) {
          $id = $row['id']; // Fetch the ID
          echo "<tr>
                  <td>" . $row['id'] . "</td>
                  <td>" . $row['Follower_id'] . "</td>
                  <td>" . $row['Following_id'] . "</td>
                  <td>" . $row['Date_followed'] . "</td>
                  <td><a style='padding:4px' href='delete_follow.php?id=$id'>Delete</a></td> 
                  <td><a style='padding:4px' href='update_follow.php?id=$id'>Update</a></td> 
                </tr>";
        }
      } else {
        echo "<tr><td colspan='6'>No data found</td></tr>";
      }
      // Close the database connection
      $connection->close();
      ?>
    </table>
  </section>

  <footer>
    <center> 
      <b><h2>UR CBE BIT &copy designed by Francois Niyitunga reg 222004350</h2></b>
    </center>
  </footer>
</body>
</html>
