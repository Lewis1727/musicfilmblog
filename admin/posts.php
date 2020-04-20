<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<!-- Get all admin posts from DB -->
<?php $posts = getAllPosts(); ?>
	<title>Admin | Manage Posts</title>
</head>
<body>
 
<?php if (isset($_SESSION['user']['username'])): ?>  
<?php if ($_SESSION['user']['role'] == "Admin"): ?>
    <div class="container">
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div posts" style="width: 80%">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No posts in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th></th>
						<th>Author</th>
						<th>Title</th>
						<th>Views</th>
						<!-- Only Admin can publish/unpublish post -->
						<?php if ($_SESSION['user']['role'] == "Admin"): ?>
						    <th><small>Publish</small></th>
						<?php endif ?>
						<!-- <th><small>Edit</small></th> -->
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
                            <td><?php echo $post['author']; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
									<?php echo $post['title']; ?>	
								</a>
							</td>
							<td><?php echo $post['views']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
							<?php if ($_SESSION['user']['role'] == "Admin" ): ?>
								<td>
								<?php if ($post['published'] == true): ?>
									<a class="btn unpublish" href="posts.php?unpublish=<?php echo $post['id'] ?>"><i class="fa fa-check"></i></a>
								<?php else: ?>
									<a class="btn publish" href="posts.php?publish=<?php echo $post['id'] ?>"><i class="fa fa-times"></i></a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<!-- <td>
								<a class="btn edit" href="create_post.php?edit-post=<?php echo $post['id'] ?>"><i class="fa fa-edit"></i></a>
							</td> -->
							<td>
								<a class="btn delete" href="create_post.php?delete-post=<?php echo $post['id'] ?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
    </div>
	</div>
	<?php elseif ($_SESSION['user']['role'] == "Author"):  ?>
		<div class="container">
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div posts" style="width: 80%">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>

			<?php if (empty($posts)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No posts in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th></th>
						<th>Author</th>
						<th>Title</th>
						<th>Views</th>
						<!-- Only Admin can publish/unpublish post -->
						<?php if ($_SESSION['user']['role'] == "Admin"): ?>
						    <th><small>Publish</small></th>
						<?php endif ?>
						<!-- <th><small>Edit</small></th> -->
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
                            <td><?php echo $post['author']; ?></td>
							<td>
								<a 	target="_blank"
								href="<?php echo BASE_URL . 'single_post.php?post-slug=' . $post['slug'] ?>">
									<?php echo $post['title']; ?>	
								</a>
							</td>
							<td><?php echo $post['views']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
							<?php if ($_SESSION['user']['role'] == "Admin" ): ?>
								<td>
								<?php if ($post['published'] == true): ?>
									<a class="btn unpublish" href="posts.php?unpublish=<?php echo $post['id'] ?>"><i class="fa fa-check"></i></a>
								<?php else: ?>
									<a class="btn publish" href="posts.php?publish=<?php echo $post['id'] ?>"><i class="fa fa-times"></i></a>
								<?php endif ?>
								</td>
							<?php endif ?>

							<!-- <td>
								<a class="btn edit" href="create_post.php?edit-post=<?php echo $post['id'] ?>"><i class="fa fa-edit"></i></a>
							</td> -->
							<td>
								<a class="btn delete" href="create_post.php?delete-post=<?php echo $post['id'] ?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
		<!-- // Display records from DB -->
    </div>
	</div>



	<?php endif ?>
	<?php else: ?>
	
	<h2 class="warning">YOU HAVE NO ROOTS TO ACCESS THIS PAGE </h2>
	<?php endif ?>
	

</body>
</html>