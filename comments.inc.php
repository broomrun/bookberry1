<?php
session_start();
header('Content-Type: application/json'); // Pastikan respons dalam format JSON

$conn = pg_connect("host=localhost dbname=bookberryss user=postgres password=kamisukses");

if (!$conn) {
    echo json_encode(['error' => 'Database connection failed: ' . pg_last_error()]);
    exit;
}

// Menangani permintaan POST
// Menangani permintaan POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Menangani Like/Dislike
    if (isset($_POST['action']) && isset($_POST['commentId'])) {
        $commentId = $_POST['commentId'] ?? null;
        $action = $_POST['action'] ?? null; // 'like' or 'dislike'

        if (!$commentId || !$action || !in_array($action, ['like', 'dislike'])) {
            echo json_encode(['error' => 'Invalid data']);
            exit;
        }

        // Tentukan kolom yang perlu diperbarui
        $column = $action === 'like' ? 'likes' : 'dislikes';
        $query = "UPDATE comments SET $column = $column + 1 WHERE id = $commentId";
        $result = pg_query($conn, $query);

        if ($result) {
            echo json_encode(['success' => 'Like/Dislike updated!']);
        } else {
            echo json_encode(['error' => 'Failed to update like/dislike']);
        }
        exit;
    }

    // Menangani penyimpanan komentar
    $title = $_POST['title'] ?? null;
    $comment = $_POST['comment'] ?? null;
    $parent_id = $_POST['parent_id'] ?? null; // Tambahkan parent_id
    $username = $_SESSION['user_name'] ?? null;

    if (!$title || !$comment || !$username) {
        echo json_encode(['error' => 'Incomplete data']);
        exit;
    }

    // Simpan komentar
    $query = "INSERT INTO comments (book_title, username, text, parent_id) VALUES ($1, $2, $3, $4)";
    $result = pg_prepare($conn, "insert_comment", $query);
    if ($result) {
        $result = pg_execute($conn, "insert_comment", array($title, $username, $comment, $parent_id));
        if ($result) {
            echo json_encode(['success' => 'Comment saved!']);
        } else {
            echo json_encode(['error' => 'Failed to execute statement']);
        }
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
    exit;
}

// Menangani permintaan GET untuk mengambil komentar
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $title = $_GET['title'] ?? null;

    if (!$title) {
        echo json_encode(['error' => 'Missing book title']);
        exit;
    }

    $query = "SELECT comments.*, user_form.image FROM comments 
                LEFT JOIN user_form ON comments.username = user_form.name
                WHERE comments.book_title = $1
                ORDER BY comments.created_at ASC";
    $result = pg_prepare($conn, "get_comments", $query);
    if ($result) {
        $result = pg_execute($conn, "get_comments", array($title));

        $comments = [];
        while ($row = pg_fetch_assoc($result)) {
            // Add profile image to the comment data
            $profile_image = !empty($row['image']) ? 'uploaded_profile_images/' . $row['image'] : 'uploaded_profile_images/default_image.jpg';
            $row['profile_image'] = $profile_image;
            $comments[] = $row;
        }

        // Organize comments in a nested format
        $nestedComments = [];
        foreach ($comments as $comment) {
            if ($comment['parent_id'] === null) {
                $nestedComments[$comment['id']] = $comment;
                $nestedComments[$comment['id']]['replies'] = [];
            } else {
                $nestedComments[$comment['parent_id']]['replies'][] = $comment;
            }
        }

        echo json_encode(array_values($nestedComments));
    } else {
        echo json_encode(['error' => 'Failed to prepare statement']);
    }
    exit;
}


$conn->close();
?>
