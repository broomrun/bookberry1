<?php 
session_start();
include "config.php"; // Ensure this file sets up $conn
?>
<!DOCTYPE html>
<html>
<head>
  <title>Comment System</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
  <br />
  <h2 align="center"><a href="#">Comment System</a></h2>
  <br />
  <div class="container">
   <form method="POST" id="comment_form">
    <div class="form-group">
     <input type="text" name="comment_name" id="comment_name" class="form-control" placeholder="Enter Name" required />
    </div>
    <div class="form-group">
     <textarea name="comment_content" id="comment_content" class="form-control" placeholder="Enter Comment" rows="5" required></textarea>
    </div>
    <div class="form-group">
     <input type="hidden" name="comment_id" id="comment_id" value="0" />
     <input type="submit" name="submit" id="submit" class="btn btn-info" value="Submit" />
    </div>
   </form>
   <span id="comment_message"></span>
   <br />
   <div id="display_comment"></div>
  </div>
</body>
</html>

<script>
$(document).ready(function(){
 
 $('#comment_form').on('submit', function(event){
  event.preventDefault();
  var form_data = $(this).serialize();
  $.ajax({
   url: "add_comment.php", // Ensure this file is set up correctly
   method: "POST",
   data: form_data,
   dataType: "JSON",
   success: function(data) {
       console.log(data); // Log the response to check for errors
       $('#comment_message').html(data.error); // Show the success/error message
       if(data.error == '<label class="text-success">Comment Added</label>') {
           $('#comment_form')[0].reset(); // Reset the form
           $('#comment_id').val('0'); // Reset comment ID
           load_comment(); // Load updated comments
       }
   }
  });
 });

 load_comment();

 function load_comment() {
  $.ajax({
   url: "fetch_comment.php", // Ensure this file is set up correctly
   method: "POST",
   success: function(data) {
    $('#display_comment').html(data); // Update comments display
   }
  });
 }

 $(document).on('click', '.reply', function() {
  var comment_id = $(this).attr("id");
  $('#comment_id').val(comment_id); // Set the reply ID
  $('#comment_name').focus(); // Focus on the name input
 });
});
</script>
