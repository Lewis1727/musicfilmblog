<div class="header">
		<div class="logo">
			<a href="<?php echo BASE_URL .'admin/dashboard.php' ?>">
				<h1>MusicBlog - Admin</h1>
			</a>
		</div>
		<div class="user-info">
		<span class="span-info"><?php echo $_SESSION['user']['username'] ?></span> 
		<a href="<?php echo BASE_URL . '/logout.php'; ?>" class="logout-btn">logout</a>
		</div>

</div>