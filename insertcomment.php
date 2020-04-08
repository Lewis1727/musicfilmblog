<?php

$post_id = 0;
$user_id = 0;
$body = "";

global $conn, $errors, $post_id, $user_id, $body;



$body = htmlentities(esc($request_values['body']));



//First check if everything is filled in
if (empty($body)) { array_push($errors, "Comment body is required"); }
if (empty($user_id)) { array_push($errors, "Something wrong with user id"); }
if (empty($post_id)) { array_push($errors, "Something is wrong with post id"); }


if (count($errors) == 0){
//Do a mysql_real_escape_string() to all fields






//Then insert comment
$query = "INSERT INTO comments (user_id, post_id, body, created_at) VALUES ('$user_id', '$post_id', '$body', now())";
$result = mysqli_query($conn, $query);
}
else
{
die("Fill out everything please.");
}
?>



