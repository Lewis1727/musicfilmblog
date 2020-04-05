<?php  include('../config.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
	<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
	<title>Admin | Dashboard</title>
</head>
<body>
	<?php if (isset($_SESSION['user'])): ?>
	<div class="container">
	<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>MusicBlog - Admin</h1>
			</a>
		</div>
		<div class="user-info">
		<span><?php echo $_SESSION['user']['username'] ?></span> &nbsp; &nbsp; 
		<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
		</div>

</div>
	<div class="container dashboard">
		<h1>Welcome</h1>
		<div class="stats">
			<a href="users.php" class="first">
				<span>43</span> <br>
				<span>registered users</span>
			</a>
			<a href="posts.php">
				<span>43</span> <br>
				<span>published posts</span>
			</a>
			<a href="#">
				<span>43</span> <br>
				<span>published comments</span>
			</a>
		</div>
		<br><br><br>
		<div class="buttons">
			<a href="users.php">Add Users</a>
			<a href="posts.php">Add Posts</a>
		</div>
	</div>
	</div>
	<?php else: ?>
		<div class="container header">
			<div class="logo">
				<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
					<h1>MusicBlog - Admin</h1>
				</a>
			</div>
			<div class="user-info">
				<a href="<?php echo BASE_URL . '/login.php'; ?>" class="login-btn">login</a>
			</div>
		</div>
	<?php endif ?>
</body>
</html>