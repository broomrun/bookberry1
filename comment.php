<?php
date_default_timezone_set('Asia/Jakarta');
include 'comments.inc.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <style>
        /* Add your CSS styles here */
        .comment-box {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .error-message {
            color: red;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Include jQuery -->
    <script>
        $(document).ready(function() {
            $('#commentForm').on('submit', function(e) {
                e.preventDefault(); // Prevent default form submission
                $.ajax({
                    type: 'POST',
                    url: 'comments.inc.php',
                    data: $(this).serialize(), // Serialize form data
                    success: function(response) {
                        // Check if the response contains an error message
                        if (response.error) {
                            $('#commentsSection').prepend(`<div class="error-message">${response.error}</div>`);
                        } else {
                            // Append the new comment to the comments section
                            $('#commentsSection').prepend(response);
                            $('#message').val(''); // Clear the message textarea
                        }
                    },
                    error: function() {
                        alert('Error submitting comment.');
                    }
                });
            });
        });
    </script>
</head>
<body>

<?php
// Display login form
echo "<form method='post' action='".getLogin($conn)."'>
    <input type='text' name='uid' placeholder='Username' required>
    <input type='password' name='pwd' placeholder='Password' required>
    <button type='submit' name='loginSubmit'>Login</button>
</form>";

// Display logout form if user is logged in
if (isset($_SESSION['user'])) {
    echo "<form method='post' action='".userLogout()."'>
        <button type='submit' name='logoutSubmit'>Logout</button>
    </form>";
}
?>

<br><br>

<!-- Form to add comments -->
<form id="commentForm" method="POST">
    <input type="hidden" name="uid" value="Anonymous">
    <input type="hidden" name="date" value="<?php echo date('Y-m-d H:i:s'); ?>">
    <textarea id="message" name="message" placeholder="Write your comment here..." required></textarea>
    <button type="submit" name="commentSubmit">Comment</button>
</form>

<!-- Display comments -->
<h2>Comments:</h2>
<div id="commentsSection">
    <?php getComments($conn); ?>
</div>

</body>
</html>
