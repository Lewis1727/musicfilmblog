<?php




$post_id = 0;
$user_id = 0;
$body = "";

// if user clicks the create post button
if (isset($_POST['create_comment'])) { createComment($_POST); }

function createComment($request_values){
global $conn, $errors, $post_id, $user_id, $body;

$body = htmlentities(esc($request_values['body']));
$post_id = '$post[id]';
$user_id = $_SESSION['user']['id'];

//First check if everything is filled in
if (empty($body)) { array_push($errors, "Comment body is required"); }
if (empty($user_id)) { array_push($errors, "Something wrong with user id"); }
if (empty($post_id)) { array_push($errors, "Something is wrong with post id"); }


if (count($errors) == 0){

//Then insert comment
$query = "INSERT INTO comments (user_id, post_id, body, created_at) VALUES ('$user_id', '$post_id', '$body', now())";
mysqli_query($conn, $query);

$_SESSION['message'] = "Comment created successfully";
header('location: single_post.php');
exit(0);
}
else
{
die("Fill out everything please.");
}
}
?>



