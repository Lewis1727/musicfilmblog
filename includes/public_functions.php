<?php 

require_once("registration_login.php");

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
			WHERE ps.id IN 
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


// User variables
$user_id = 0;
$username = "";
$email = "";
$password = "";
$isEditingUser = false;
$errors = [];



// User actions
if (isset($_GET['edit-user'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-user'];
	editUser($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_user'])) {
	updateUser($_POST);
}




function editUser($user_id)
{
	global $conn, $username, $isEditingUser, $user_id, $email, $password;

	$sql = "SELECT * FROM users WHERE id=$user_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$user = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $user['username'];
	$email = $user['email'];
	$password = $user['password'];
}

function updateUser($request_values){
	global $conn, $errors, $username, $isEditingUser, $user_id, $email, $password;
	// get id of the admin to be updated
	$user_id = $request_values['user_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', password='$password' WHERE id=$user_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Your profile information updated successfully";
		header('location: my_profile.php');
		exit(0);
	}
}

?>
