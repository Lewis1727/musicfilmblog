<?php 
// Admin user variables
$admin_id = 0;
$isEditingUser = false;
$username = "";
$role = "";
$email = "";
// general variables
$errors = [];
// Topics variables
$topic_id = 0;
$isEditingTopic = false;
$topic_name = "";
// quote variable
$quote_text = "";
$quote_author = "";
// comment variables
$comment_post_id = 0;
$comment_user_id = 0;
$comment_username = '';
$comment_body = '';
$comment_post_title = '';
//quotes variables
$quote_author = '';
$quote_text = '';
$quote_id = 0;
$isEditingQuote = false;

/* - - - - - - - - - - 
-  Admin users actions
- - - - - - - - - - -*/
// if user clicks the create admin button
if (isset($_POST['create_admin'])) {
	createAdmin($_POST);
}
// if user clicks the Edit admin button
if (isset($_GET['edit-admin'])) {
	$isEditingUser = true;
	$admin_id = $_GET['edit-admin'];
	editAdmin($admin_id);
}
// if user clicks the update admin button
if (isset($_POST['update_admin'])) {
	updateAdmin($_POST);
}
// if user clicks the Delete admin button
if (isset($_GET['delete-admin'])) {
	$admin_id = $_GET['delete-admin'];
	deleteAdmin($admin_id);
}


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Returns all admin users and their corresponding roles
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function getAdminUsers(){
	global $conn, $roles;
	$sql = "SELECT * FROM users WHERE role IS NOT NULL";
	$result = mysqli_query($conn, $sql);
	$users = mysqli_fetch_all($result, MYSQLI_ASSOC);

	return $users;
}
/* * * * * * * * * * * * * * * * * * * * *
* - Escapes form submitted value, hence, preventing SQL injection
* * * * * * * * * * * * * * * * * * * * * */
function esc(String $value){
	// bring the global db connect object into function
	global $conn;
	// remove empty space sorrounding string
	$val = trim($value); 
	$val = mysqli_real_escape_string($conn, $value);
	return $val;
}
// Receives a string like 'Some Sample String'
// and returns 'some-sample-string'
function makeSlug(String $string){
	$string = strtolower($string);
	$slug = preg_replace('/[^A-Za-z0-9-]+/', '-', $string);
	return $slug;
}
/* - - - - - - - - - - 
-  Topic actions
- - - - - - - - - - -*/
// if user clicks the create topic button
if (isset($_POST['create_topic'])) { createTopic($_POST); }
// if user clicks the Edit topic button
if (isset($_GET['edit-topic'])) {
	$isEditingTopic = true;
	$topic_id = $_GET['edit-topic'];
	editTopic($topic_id);
}
// if user clicks the update topic button
if (isset($_POST['update_topic'])) {
	updateTopic($_POST);
}
// if user clicks the Delete topic button
if (isset($_GET['delete-topic'])) {
	$topic_id = $_GET['delete-topic'];
	deleteTopic($topic_id);
}

/* - - - - - - - - - - - -
-  Admin users functions
- - - - - - - - - - - - -*/
/* * * * * * * * * * * * * * * * * * * * * * *
* - Receives new admin data from form
* - Create new admin user
* - Returns all admin users with their roles 
* * * * * * * * * * * * * * * * * * * * * * */
function createAdmin($request_values){
	global $conn, $errors, $role, $username, $email;
	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);

	if(isset($request_values['role'])){
		$role = esc($request_values['role']);
	}
	// form validation: ensure that the form is correctly filled
	if (empty($username)) { array_push($errors, "Uhmm...We gonna need the username"); }
	if (empty($email)) { array_push($errors, "Oops.. Email is missing"); }
	if (empty($role)) { array_push($errors, "Role is required for admin users");}
	if (empty($password)) { array_push($errors, "uh-oh you forgot the password"); }
	if ($password != $passwordConfirmation) { array_push($errors, "The two passwords do not match"); }
	// Ensure that no user is registered twice. 
	// the email and usernames should be unique
	$user_check_query = "SELECT * FROM users WHERE username='$username' 
							OR email='$email' LIMIT 1";
	$result = mysqli_query($conn, $user_check_query);
	$user = mysqli_fetch_assoc($result);
	if ($user) { // if user exists
		if ($user['username'] === $username) {
		  array_push($errors, "Username already exists");
		}

		if ($user['email'] === $email) {
		  array_push($errors, "Email already exists");
		}
	}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = md5($password);//encrypt the password before saving in the database
		$query = "INSERT INTO users (username, email, role, password, created_at, updated_at) 
				  VALUES('$username', '$email', '$role', '$password', now(), now())";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user created successfully";
		header('location: users.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes admin id as parameter
* - Fetches the admin from database
* - sets admin fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editAdmin($admin_id)
{
	global $conn, $username, $role, $isEditingUser, $admin_id, $email;

	$sql = "SELECT * FROM users WHERE id=$admin_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$admin = mysqli_fetch_assoc($result);

	// set form values ($username and $email) on the form to be updated
	$username = $admin['username'];
	$email = $admin['email'];
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
* - Receives admin request from form and updates in database
* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */
function updateAdmin($request_values){
	global $conn, $errors, $role, $username, $isEditingUser, $admin_id, $email;
	// get id of the admin to be updated
	$admin_id = $request_values['admin_id'];
	// set edit state to false
	$isEditingUser = false;


	$username = esc($request_values['username']);
	$email = esc($request_values['email']);
	$password = esc($request_values['password']);
	$passwordConfirmation = esc($request_values['passwordConfirmation']);
	if(isset($request_values['role'])){
		$role = $request_values['role'];
}
	// register user if there are no errors in the form
	if (count($errors) == 0) {
		//encrypt the password (security purposes)
		$password = md5($password);

		$query = "UPDATE users SET username='$username', email='$email', role='$role', password='$password' WHERE id=$admin_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Admin user updated successfully";
		header('location: users.php');
		exit(0);
	}
}
// delete admin user 
function deleteAdmin($admin_id) {
	global $conn;
	$sql = "DELETE FROM users WHERE id=$admin_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "User successfully deleted";
		header("location: users.php");
		exit(0);
	}
}

/* - - - - - - - - - - 
-  Topics functions
- - - - - - - - - - -*/
// get all topics from DB
function getAllTopics() {
	global $conn;
	$sql = "SELECT * FROM topics";
	$result = mysqli_query($conn, $sql);
	$topics = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $topics;
}
function createTopic($request_values){
	global $conn, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	// create slug: if topic is "Life Advice", return "life-advice" as slug
	$topic_slug = makeSlug($topic_name);
	$topic_id = esc($request_values['topic_id']);
	// validate form
	if (empty($topic_name)) { 
		array_push($errors, "Topic name required"); 
	}
	if (empty($topic_id)) { 
		array_push($errors, "Topic id required"); 
	}
	// Ensure that no topic is saved twice. 
	$topic_check_query = "SELECT * FROM topics WHERE slug='$topic_slug' LIMIT 1";
	$result = mysqli_query($conn, $topic_check_query);
	if (mysqli_num_rows($result) > 0) { // if topic exists
		array_push($errors, "Topic already exists");
	}
	// register topic if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO topics (id, name, slug) 
				  VALUES('$topic_id', '$topic_name', '$topic_slug')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Topic created successfully";
		header('location: topics.php');
		exit(0);
	}
}
/* * * * * * * * * * * * * * * * * * * * *
* - Takes topic id as parameter
* - Fetches the topic from database
* - sets topic fields on form for editing
* * * * * * * * * * * * * * * * * * * * * */
function editTopic($topic_id) {
	global $conn, $topic_name, $isEditingTopic, $topic_id;
	$sql = "SELECT * FROM topics WHERE id=$topic_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$topic = mysqli_fetch_assoc($result);
	// set form values ($topic_name) on the form to be updated
	$topic_name = $topic['name'];
}
function updateTopic($request_values) {
	global $conn, $errors, $topic_name, $topic_id;
	$topic_name = esc($request_values['topic_name']);
	$topic_id = esc($request_values['topic_id']);
	// create slug: if topic is "Life Advice", return "life-advice" as slug
	$topic_slug = makeSlug($topic_name);
	// validate form
	if (empty($topic_name)) { 
		array_push($errors, "Topic name required"); 
	}
	// register topic if there are no errors in the form
	if (count($errors) == 0) {
		$query = "UPDATE topics SET name='$topic_name', slug='$topic_slug' WHERE id=$topic_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Topic updated successfully";
		header('location: topics.php');
		exit(0);
	}
}
// delete topic 
function deleteTopic($topic_id) {
	global $conn;
	$sql = "DELETE FROM topics WHERE id=$topic_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Topic successfully deleted";
		header("location: topics.php");
		exit(0);
	}
}

function getAllComments()
{
	global $conn;
	$sql = "SELECT * FROM comments";
	$result = mysqli_query($conn, $sql);
	$comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $comments;
}
// if user clicks the Delete admin button
if (isset($_GET['delete-comment'])) {
	$comment_id = $_GET['delete-comment'];
	deleteComment($comment_id);
}
// delete admin user 
function deleteComment($comment_id) {
	global $conn;
	$sql = "DELETE FROM comments WHERE id=$comment_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Comment successfully deleted";
		header("location: comments.php");
		exit(0);
	}
}

// if user clicks the create quote button
if (isset($_POST['create_quote'])) {
	createQuote($_POST);
}
// if user clicks the Edit quote button
if (isset($_GET['edit-quote'])) {
	$isEditingQuote = true;
	$quote_id = $_GET['edit-quote'];
	editQuote($quote_id);
}
// if user clicks the update quote button
if (isset($_POST['update_quote'])) {
	updateQuote($_POST);
}
// if user clicks the Delete quote button
if (isset($_GET['delete-quote'])) {
	$quote_id = $_GET['delete-quote'];
	deleteQuote($quote_id);
}

function getAllQuotes(){
	global $conn;
	$sql = "SELECT * FROM quote_of_the_day";
	$result = mysqli_query($conn, $sql);
	$quotes = mysqli_fetch_all($result, MYSQLI_ASSOC);
	return $quotes;
}
function createQuote($request_values){
	global $conn, $errors, $quote_text, $quote_author, $quote_id;
	$quote_text= esc($request_values['quote_text']);
	$quote_author= esc($request_values['quote_author']);
	// validate form
	if (empty($quote_text)) { 
		array_push($errors, "Quote text required"); 
	}
	if (empty($quote_author)) { 
		array_push($errors, "Quote author required"); 
	}
	// Ensure that no topic is saved twice. 
	$quote_check_query = "SELECT * FROM quote_of_the_day WHERE quote_text ='$quote_text' LIMIT 1";
	$result = mysqli_query($conn, $quote_check_query);
	if (mysqli_num_rows($result) > 0) { // if topic exists
		array_push($errors, "Quote already exists");
	}
	// register topic if there are no errors in the form
	if (count($errors) == 0) {
		$query = "INSERT INTO quote_of_the_day (quote_text, quote_author) 
				  VALUES('$quote_text', '$quote_author')";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Quote created successfully";
		header('location: quotes.php');
		exit(0);
	}
}
function editQuote($quote_id) {
	global $conn, $isEditingQuote, $quote_id, $quote_text, $quote_author;
	$sql = "SELECT * FROM quote_of_the_day WHERE id=$quote_id LIMIT 1";
	$result = mysqli_query($conn, $sql);
	$quote = mysqli_fetch_assoc($result);
	// set form values ($quote_text) on the form to be updated
	$quote_text= $quote['quote_text'];
	$quote_author= $quote['quote_author'];
	$quote_id= $quote['id'];
}
function updateQuote($request_values) {
	global $conn, $errors, $quote_author, $quote_text,  $quote_id;
	$quote_text= esc($request_values['quote_text']);
	$quote_author= esc($request_values['quote_author']);
	$quote_id= esc($request_values['id']);
	// validate form
	if (empty($quote_text)) { 
		array_push($errors, "Quote text required"); 
	}
	if (empty($quote_author)) { 
		array_push($errors, "Quote author required"); 
	}
	if (empty($quote_id)) { 
		array_push($errors, "Quote id required"); 
	}
	// register quote if there are no errors in the form
	if (count($errors) == 0) {
		$query = "UPDATE quote_of_the_day SET quote_text = '$quote_text', quote_author = '$quote_author' WHERE id=$quote_id";
		mysqli_query($conn, $query);

		$_SESSION['message'] = "Quote updated successfully";
		header('location: quotes.php');
		exit(0);
	}
}
// delete topic 
function deleteQuote($quote_id) {
	global $conn;
	$sql = "DELETE FROM quote_of_the_day WHERE id=$quote_id";
	if (mysqli_query($conn, $sql)) {
		$_SESSION['message'] = "Quote successfully deleted";
		header("location: quotes.php");
		exit(0);
	}
}
?>