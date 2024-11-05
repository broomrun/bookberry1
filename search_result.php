<?php
include 'config.php';

$query = isset($_GET['query']) ? mysqli_real_escape_string($conn, $_GET['query']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header>
    <h2><a href="user_page.php" class="logo">BookBerry</a></h2>
    <nav class="navigation">
        <a href="home.php">Home</a>
        <a href="about.php">About</a>
        <a href="profile.php">Profile</a>
    </nav>
</header>

<div class="container mt-4">
    <h1 class="text-center">Search Results for "<?php echo htmlspecialchars($query); ?>"</h1>
    <div class="row" id="book-list"></div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Book Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="book-detail">Book details will appear here...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.2.1.min.js" crossorigin="anonymous"></script>
<script>
$(document).ready(function() {
    const query = "<?php echo $query; ?>";
    if (query) {
        $.ajax({
            url: 'https://www.googleapis.com/books/v1/volumes',
            type: 'GET',
            dataType: 'json',
            data: {
                'key': 'AIzaSyBqUPg1Itse_NYH1z7r8lA7-oA27aXBCW8',
                q: query
            },
            success: function(result) {
                if (result.totalItems > 0) {
                    let books = result.items;
                    let output = '';

                    $.each(books, function(index, book) {
                        let bookInfo = book.volumeInfo;
                        let imageUrl = bookInfo.imageLinks ? bookInfo.imageLinks.thumbnail : 'path/to/default-image.jpg';
                        let averageRating = bookInfo.averageRating ? bookInfo.averageRating : 'N/A';

                        output += `
                            <div class="col-md-3">
                                <div class="card mb-5">
                                    <img src="${imageUrl}" class="card-img-top" alt="${bookInfo.title}">
                                    <div class="card-body">
                                        <h5 class="card-title">${bookInfo.title}</h5>
                                        <p class="card-text">By ${bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown'}</p>
                                        <p><strong>Rating ⭐</strong> ${averageRating}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    });

                    $('#book-list').html(output); // Display search results
                } else {
                    $('#book-list').html(`<div class="col"><h1 class="text-center">No books found.</h1></div>`);
                }
            },
            error: function() {
                $('#book-list').html(`<div class="col"><h1 class="text-center">Error retrieving data. Please try again later.</h1></div>`);
            }
        });
    } else {
        $('#book-list').html(`<div class="col"><h1 class="text-center">No search query provided.</h1></div>`);
    }
});
</script>

</body>
</html>
