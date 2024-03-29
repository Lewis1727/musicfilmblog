<!-- The first include should be config.php -->
<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>

<!-- Retrieve all posts from database  -->
<?php $posts = getPublishedPosts(); ?>

<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
	<title>MusicBlog | Home </title>
</head>
<link rel="icon" type="image/png" href="/favicon.png"/>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php') ?>
		<!-- // navbar -->

		<!-- banner -->
		<?php include( ROOT_PATH . '/includes/banner.php') ?>
		<!-- // banner -->

		<!-- Page content -->
		<div class="content">
			
			<hr>
			<h2 class="content-title">Recent Articles</h2>
			<hr>
			
			<?php array_multisort(array_column($posts, "created_at"), SORT_DESC, $posts); ?>
			<?php foreach ($posts as $post): ?>
			

			
				
			<div class="post" style="margin-left: 0px;">
				<div class="postimg"><img src="<?php echo BASE_URL . 'static/images/' . $post['image']; ?>" class="post_image" alt=""></div>
        		<!-- Added this if statement... -->
				<div class="postinfo"><?php if (isset($post['topic']['name'])): ?>
				<!-- <a href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>" -->
					<!-- class="btn category"> -->
					<!-- <?php echo $post['topic']['name'] ?> -->
				<!-- </a> -->
				<?php endif ?>
				<a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
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
		<!-- // Page content -->
		<!-- footer -->
		<?php include( ROOT_PATH . '/includes/footer.php') ?>
		<!-- // footer -->
	
