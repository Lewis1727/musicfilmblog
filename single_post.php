<?php  include('config.php'); ?>
<?php  include('includes/public_functions.php'); ?>

<?php 
	if (isset($_GET['post-slug'])) {
		$post = getPost($_GET['post-slug']);
	}
	$topics = getAllTopics();
?>
<?php include('includes/head_section.php'); ?>
<title> <?php echo $post['title'] ?> | LifeBlog</title>
</head>
<body>

<?php 
global $conn;
$query = "UPDATE posts SET views = views + 1 WHERE id = '$post[id]'"; 
mysqli_query($conn, $query);
?>

<div class="container">
	<!-- Navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
	<!-- // Navbar -->
	
	<div class="content" >
		<!-- Page wrapper -->
		<div class="post-wrapper">
			<!-- full post div -->
			<div class="full-post-div">
			<?php if ($post['published'] == false): ?>
				<h2 class="post-title">Sorry... This post has not been published</h2>
			<?php else: ?>
				<h2 class="post-title"><?php echo $post['title']; ?></h2>
				<img src="<?php echo BASE_URL . 'static/images/' . $post['image']; ?>" class="post_image" alt="">
				<div class="post-body-div">
					<!-- <?php echo file_get_contents (BASE_URL . 'includes/topics/' . $post['body']); ?> -->
					<?php echo html_entity_decode($post['body']); ?>
				</div>
			</div>	
			<!-- // full post div -->
			

			<!-- Then cоmments below -->
				<?php if (isset($_SESSION['user']['username'])): ?>	
					<div class="h2comment">
					<hr>
					<h2>Leave a comment</h2>
					<hr>
					</div>
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
					<form enctype="multipart/form-data" action="single_post.php?post-slug=<?php echo $post['slug']; ?>" method="post">
					<textarea name="comment_body" id="comment_body" cols="100" rows="10" placeholder="Add a comment..."></textarea>
					<input type="hidden" name="comment_post_id" value="<?php echo $post['id']  ?>" />
					<input type="hidden" name="comment_username" value="<?php echo $_SESSION['user']['username'] ?>" />
					<input type="hidden" name="comment_user_id" value="<?php echo $_SESSION['user']['id'] ?>" />
					<input type="hidden" name="comment_post_title" value="<?php echo $post['title'] ?>" />
					<button class="commentbtn" name="create_comment"/>Post comment</button>
					</form>
				
				<?php else: ?>
					<a href="login.php" class="join-us">Sign in to write comments!</a>
				<?php endif ?>
					<div class="h2comment">	
					<hr>
					<h2>Comments</h2>
					<hr>
					</div>
					
					
					<?php
					global $conn;
					$query = "SELECT * FROM comments WHERE post_id = '$post[id]' ";
					$result = mysqli_query($conn, $query);
					if ($result->num_rows>0){
					while($row = mysqli_fetch_object($result)){		
					?>
					<div class="comment-body">
					<div class="commentauthor">
						<span>
						<p><?php echo $row->username;?></p>
						</span>
					</div>
					<div class="commentbody"><p><?php echo html_entity_decode ($row->body); ?></p></div>
					<hr>
					</div>
					<?php } ?>
					<?php }else{ ?>
						<div class="nocomments">
						<p>No comments for this post...</p>
						</div>
					<?php } ?>
		
					<?php endif ?>	
		</div> 
	
		<!-- post sidebar -->
		<div class="post-sidebar">
			<div class="card">
				<div class="card-header">
					<h2>Topics</h2>
				</div>
				<div class="card-content">
					<?php foreach ($topics as $topic): ?>
						<a 
							href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $topic['id'] ?>">
							<?php echo $topic['name']; ?>
						</a> 
					<?php endforeach ?>
				</div>
			</div>
		</div>
		<!-- // post sidebar -->
	</div>
</div>
<!-- // content -->
<!-- Javascripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap Javascript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>

<script src="static/js/script.js"></script>


<?php include( ROOT_PATH . '/includes/footer.php'); ?>