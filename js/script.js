window.addEventListener('scroll', function() {
    const navbar = document.querySelector('header');
    if (window.scrollY > 0) {
        navbar.classList.add('navbar-shadow');
    } else {
        navbar.classList.remove('navbar-shadow');
    }
});

function searchBooks(genre = null) {
    // Get the search input and genre filter, if available
    let query = $('#searchInput').val().trim(); // Trim whitespace from the search input
    if (genre) {
        query = `subject:${genre}`;
    } else if ($('#genreFilter').val() && query) {
        // Handle the genre filter only if it's selected along with a search term
        query += ` +subject:${$('#genreFilter').val()}`;
    } else if ($('#genreFilter').val()) {
        // Use genre only if there is no search term
        query = `subject:${$('#genreFilter').val()}`;
    }

    if (!query) {
        alert("Please enter a search term or select a genre."); // Optional alert if no search term is present
        return;
    }

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
                                <a href="#" class="card-link see-detail" data-bs-toggle="modal" data-bs-target="#exampleModal" 
                                   data-title="${bookInfo.title}" 
                                   data-authors="${bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown'}" 
                                   data-date="${bookInfo.publishedDate ? bookInfo.publishedDate : 'N/A'}" 
                                   data-description="${bookInfo.description ? bookInfo.description : 'No description available'}" 
                                   data-image="${imageUrl}" 
                                   data-rating="${averageRating}">
                                   <img src="${imageUrl}" class="card-img-top" alt="${bookInfo.title}">
                                </a>
                                <div class="book-card">
                                    <h5 class="book-title">${bookInfo.title}</h5>
                                    <p class="author-name">By ${bookInfo.authors ? bookInfo.authors.join(', ') : 'Unknown'}</p>
                                    <p class="card-text"><strong>Rating ⭐</strong> ${averageRating}</p>
                                </div>
                            </div>
                        </div>
                    `;
                });
                $('#searchInput').val(''); // Clear search input after search
                $('#book-list').html(output); // Display search results
            } else {
                $('#book-list').html(`<div class="col"><h1 class="text-center">No books found.</h1></div>`);
            }
        },
        error: function() {
            $('#book-list').html(`<div class="col"><h1 class="text-center">Error retrieving data. Please try again later.</h1></div>`);
        }
    });
}

// Event listener for the genre filter
$('#genreFilter').on('change', function() {
    searchBooks(); // Trigger search when the genre changes
});

// Event listeners for search button and Enter key
$('#search-button').on('click', function() {
    searchBooks();
});

$('#searchInput').on('keyup', function(event) {
    if (event.keyCode === 13) {
        searchBooks();
    }
});

$(document).ready(function() {
    $('#fantasy-tile').on('click', function() {
        searchBooks('Fantasy');
    });
    $('#fiction-tile').on('click', function() {
        searchBooks('Fiction');
    });
    $('#history-tile').on('click', function() {
        searchBooks('History');
    });
    $('#science-tile').on('click', function() {
        searchBooks('Science');
    });
    $('#biography-tile').on('click', function() {
        searchBooks('Biography');
    });
});

// Click event for the "See Detail" button
$(document).on('click', '.see-detail', function() {
    const title = $(this).data('title');
    const authors = $(this).data('authors');
    const date = $(this).data('date');
    const description = $(this).data('description');
    const image = $(this).data('image');
    const rating = $(this).data('rating'); // Retrieve rating

    $('#exampleModalLabel').text(title);
    $('#book-detail').html(`
        <div class="text-center mb-3">
            <img src="${image}" class="img-fluid" alt="${title}" style="max-height: 200px;">
        </div>
        <p><strong>Authors:</strong> ${authors}</p>
        <p><strong>Published Date:</strong> ${date}</p>
        <p><strong>Description:</strong> ${description}</p>
        <p><strong>Rating:</strong> ${rating}</p> <!-- Display rating -->
    `);
});
