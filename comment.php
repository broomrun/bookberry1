<?php
// Set the default timezone
date_default_timezone_set('Asia/Jakarta');

// Function to check if a user is logged in
function getLogin() {
    session_start(); // Start the session
    // Check if the user ID is stored in the session
    return isset($_SESSION['user_id']);
}

// Function to connect to the database
function dbConnect() {
    $conn = new mysqli("localhost", "root", "", "bookberry");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

// Function to set a new comment in the database
function setComment() {
    if (isset($_POST['commentSubmit'])) {
        // Get user input
        $uid = $_POST['uid'];
        $date = date("Y-m-d H:i:s"); // Set the current date and time
        $message = $_POST['message'];

        // Connect to the database
        $conn = dbConnect();

        // Prepare and bind the SQL statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO comments (uid, date, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $uid, $date, $message);

        if ($stmt->execute()) {
            // Return the new comment HTML for appending
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($uid) . "</strong> at " . htmlspecialchars($date) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($message)) . "</p>";
            echo "</div><br>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
}

// Function to get comments from the database
function getComments() {
    // Connect to the database
    $conn = dbConnect();

    $sql = "SELECT * FROM comments ORDER BY date DESC";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='comment-box'>";
            echo "<p><strong>" . htmlspecialchars($row['uid']) . "</strong> at " . htmlspecialchars($row['date']) . "</p>";
            echo "<p>" . nl2br(htmlspecialchars($row['message'])) . "</p>";
            echo "</div><br>";
        }
    } else {
        echo "<div class='alert alert-warning'>No comments yet!</div>";
    }

    $conn->close();
}

// Function to delete a comment (optional)
function deleteComment($id) {
    // Connect to the database
    $conn = dbConnect();

    // Prepare and bind the SQL statement
    $stmt = $conn->prepare("DELETE FROM comments WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Comment deleted successfully.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error deleting comment: " . $stmt->error . "</div>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Handle the submission of a new comment
setComment();

// Handle comment deletion (if necessary)
// This assumes you have a way to pass the comment ID to delete
if (isset($_POST['deleteComment'])) {
    $commentId = $_POST['commentId'];
    deleteComment($commentId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="stylesheet" href="path/to/bootstrap.css">
</head>
<body>
    <div class="container">
        <h1 class="mt-5">Comments</h1>

        <?php if (getLogin()): ?>
            <form method="POST" action="">
                <input type="hidden" name="uid" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">
                <div class="mb-3">
                    <label for="message" class="form-label">Your Comment:</label>
                    <textarea class="form-control" id="message" name="message" required></textarea>
                </div>
                <button type="submit" name="commentSubmit" class="btn btn-primary">Submit Comment</button>
            </form>
        <?php else: ?>
            <div class="alert alert-warning">You need to be logged in to comment.</div>
            <a href="login.php" class="btn btn-link">Login</a>
        <?php endif; ?>

        <h2 class="mt-5">Existing Comments</h2>
        <div id="comments">
            <?php getComments(); ?>
        </div>
    </div>

    <script src="path/to/bootstrap.bundle.js"></script>
</body>
</html>
