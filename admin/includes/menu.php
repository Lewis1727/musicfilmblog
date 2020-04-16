<div class="menu">
	<div class="card">
		<div class="card-header">
			<h2>Actions</h2>
		</div>
		<?php if ($_SESSION['user']['role'] == "Admin"): ?>
		<div class="card-content">
			<a href="<?php echo BASE_URL . 'admin/create_post.php' ?>">Create Posts</a>
			<a href="<?php echo BASE_URL . 'admin/posts.php' ?>">Manage Posts</a>
			<a href="<?php echo BASE_URL . 'admin/users.php' ?>">Manage Users</a>
			<a href="<?php echo BASE_URL . 'admin/topics.php' ?>">Manage Topics</a>
			<a href="<?php echo BASE_URL . 'admin/comments.php' ?>">Manage Comments</a>
		</div>
		<?php else: ?>
		<div class="card-content">
			<a href="<?php echo BASE_URL . 'admin/create_post.php' ?>">Create Posts</a>
			<a href="<?php echo BASE_URL . 'admin/posts.php' ?>">Manage Posts</a>
			<!-- <a href="<?php echo BASE_URL . 'admin/comments.php' ?>">Manage Comments</a> -->
		</div>
		<?php endif ?>
		
	</div>
</div>