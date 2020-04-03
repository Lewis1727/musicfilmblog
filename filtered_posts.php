<?php include('config.php'); ?>
<?php include('includes/public_functions.php'); ?>
<?php include('includes/head_section.php'); ?>
<?php 
	// Get posts under a particular topic
	if (isset($_GET['topic'])) {
		$topic_id = $_GET['topic'];
		$posts = getPublishedPostsByTopic($topic_id);
	}
?>
	<title>LifeBlog | Home </title>
</head>
<body>
<div class="container">
<!-- Navbar -->
	<?php include( ROOT_PATH . '/includes/navbar.php'); ?>
<!-- // Navbar -->
<!-- content -->
<div class="content">
	<hr>
	<h2 class="content-title">
		<?php echo getTopicNameById($topic_id); ?>
	</h2>
	<hr>
	<?php foreach ($posts as $post): ?>
		<div class="post" style="margin-left: 0px;">
			<div class="postimg"><img src="<?php echo BASE_URL . '/static/images/' . $post['image']; ?>" class="post_image" alt=""></div>
			
			<div class="postinfo"><a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
				<div class="post_info">
					<h3 class="h3postinfo"><?php echo $post['title'] ?></h3>
					<div class="info">
					<span><p>BY <?php echo $post["author"]; ?></p></span>
						<!-- <span class="read_more">Read more...</span> -->
					</div>
				</div>
			</a></div>
		</div>
	<?php endforeach ?>
</div>
<!-- // content -->
</div>
<!-- // container -->

<!-- Footer -->
	<?php include( ROOT_PATH . '/includes/footer.php'); ?>
<!-- // Footer -->