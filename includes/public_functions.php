<?php 

$errors= [];

	// escape value from form
	function esc(String $value)
	{	
		// bring the global db connect object into function
		global $conn;

		$val = trim($value); // remove empty space sorrounding string
		$val = mysqli_real_escape_string($conn, $value);

		return $val;
	}


/* * * * * * * * * * * * * * *
* Returns all published posts
* * * * * * * * * * * * * * */
function getPublishedPosts() {
	// use global $conn object in function
	global $conn;
	$sql = "SELECT * FROM posts WHERE published=true";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * *
* Receives a post id and
* Returns topic of the post
* * * * * * * * * * * * * * */
function getPostTopic($post_id){
	global $conn;
	$sql = "SELECT * FROM topics WHERE id=
			(SELECT topic_id FROM post_topic WHERE post_id=$post_id) LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic;
}
/* * * * * * * * * * * * * * * *
* Returns all posts under a topic
* * * * * * * * * * * * * * * * */
function getPublishedPostsByTopic($topic_id) {
	global $conn;
	$sql = "SELECT * FROM posts ps 
			WHERE published = 1 AND  ps.id IN 
			(SELECT pt.post_id FROM post_topic pt 
				WHERE pt.topic_id=$topic_id GROUP BY pt.post_id 
				HAVING COUNT(1) = 1)";
	$result = mysqli_query($conn, $sql);
	// fetch all posts as an associative array called $posts
	$posts = mysqli_fetch_all($result, MYSQLI_ASSOC);

	$final_posts = array();
	foreach ($posts as $post) {
		$post['topic'] = getPostTopic($post['id']); 
		array_push($final_posts, $post);
	}
	return $final_posts;
}
/* * * * * * * * * * * * * * * *
* Returns topic name by topic id
* * * * * * * * * * * * * * * * */
function getTopicNameById($id)
{
	global $conn;
	$sql = "SELECT name FROM topics WHERE id=$id";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	return $topic['name'];
}


/* * * * * * * * * * * * * * *
* Returns a single post
* * * * * * * * * * * * * * */
function getPost($slug){
	global $conn;
	// Get single post slug
	$post_slug = $_GET['post-slug'];
	$sql = "SELECT * FROM posts WHERE slug='$post_slug' AND published=true";
	$result = mysqli_query($conn, $sql);

	// fetch query results as associative array.
	$post = mysqli_fetch_assoc($result);
	if ($post) {
		// get the topic to which this post belongs
		$post['topic'] = getPostTopic($post['id']);
	}
	return $post;
}
/* * * * * * * * * * * *
*  Returns all topics
* * * * * * * * * * * * */
function getAllTopics()
{
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}


// // User variables
// $user_id = 0;
// $username = "";
// $email = "";
// $password = "";
// $isEditingUser = false;
// $errors = [];



// // User actions
// if (isset($_GET['edit-user'])) {
// 	$isEditingUser = true;
// 	$admin_id = $_GET['edit-user'];
// 	editUser($admin_id);
// }
// // if user clicks the update admin button
// if (isset($_POST['update_user'])) {
// 	updateUser($_POST);
// }
	


// function editUser($user_id)
// {
// 	global $conn, $username, $isEditingUser, $user_id, $email, $password;

// 	$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
// 	$result = mysqli_query($conn, $sql);
// 	$user = mysqli_fetch_assoc($result);

// 	// set form values ($username and $email) on the form to be updated
// 	$username = $user['username'];
// 	$email = $user['email'];
// 	$password = $user['password'];
// }

// function updateUser($request_values){
// 	global $conn, $errors, $username, $isEditingUser, $user_id, $email, $password;
// 	// get id of the admin to be updated
// 	$user_id = $request_values['user_id'];
// 	// set edit state to false
// 	$isEditingUser = false;


// 	$username = esc($request_values['username']);
// 	$email = esc($request_values['email']);
// 	$password = esc($request_values['password']);
// 	$passwordConfirmation = esc($request_values['passwordConfirmation']);

// 	// register user if there are no errors in the form
// 	if (count($errors) == 0) {
// 		//encrypt the password (security purposes)
// 		$password = md5($password);

// 		$query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$user_id";
// 		mysqli_query($conn, $query);

// 		$_SESSION['message'] = "Your profile information updated successfully";
// 		header('location: my_profile.php');
// 		exit(0);
// 	}
// }


// Comments //
$comment_post_id = 0;
$comment_user_id = 0;
$comment_username = '';
$comment_body = '';
$comment_post_title = '';


//If user clicks the create post button
if (isset($_POST['create_comment'])) { createComment($_POST); }

function createComment($request_values){
global $conn, $errors, $comment_post_id, $comment_user_id, $comment_body, $comment_username, $comment_post_title;

$comment_body = htmlentities(esc($request_values['comment_body']));
$comment_post_id = esc($request_values['comment_post_id']);
// var_dump($comment_post_id);
$comment_user_id = esc($request_values['comment_user_id']);
// var_dump($comment_user_id);
$comment_username = esc($request_values['comment_username']);
$comment_post_title = esc($request_values['comment_post_title']);


//First check if everything is filled in
if (empty($comment_body)) { array_push($errors, "Comment body is required"); }
if (empty($comment_user_id)) { array_push($errors, "Something wrong with user id"); }
if (empty($comment_post_id)) { array_push($errors, "Something is wrong with post id"); }
if (empty($comment_username)) { array_push($errors, "Something is wrong with comment username"); }
if (empty($comment_post_title)) { array_push($errors, "Something is wrong with post title"); }

if (count($errors) == 0){

//Then insert comment
$query = "INSERT INTO comments (user_id, post_id, body, username, created_at, post_title) VALUES ('$comment_user_id', '$comment_post_id', '$comment_body', '$comment_username', now(), '$comment_post_title')";
mysqli_query($conn, $query);

// 


header('location: index.php');
exit(0);
}
else
{
die("Fill out everything please.");
}
}

function getAllQuotes(){
	global $conn;
	$sql = "SELECT * FROM quote_of_the_day";
	$result = mysqli_query($conn, $sql);
	$quotes = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $quotes;
}

?>
