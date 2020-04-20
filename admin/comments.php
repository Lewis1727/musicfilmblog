<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/post_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>

<?php $comments = getAllComments(); ?>
	<title>Admin | Manage Comments</title>
</head>

<?php if (isset($_SESSION['user']['username'])): ?>  
<?php if ($_SESSION['user']['role'] == "Admin"): ?>
<div class="container">
	<!-- admin navbar -->
	<?php include(ROOT_PATH . '/admin/includes/navbar.php') ?>

	<div class="container content">
		<!-- Left side menu -->
		<?php include(ROOT_PATH . '/admin/includes/menu.php') ?>

		<!-- Display records from DB-->
		<div class="table-div"  style="width: 80%;">
			<!-- Display notification message -->
            <?php include(ROOT_PATH . '/includes/messages.php') ?>
            
            <?php if (empty($comments)): ?>
				<h1 style="text-align: center; margin-top: 20px;">No comments in the database.</h1>
			<?php else: ?>
				<table class="table">
						<thead>
						<th></th>
						<th>User</th>
						<th>Post Title</th>
                        <th>Comment</th>
                        <th>Created at</th>
						<th><small>Delete</small></th>
					</thead>
					<tbody>
					<?php foreach ($comments as $key => $comment): ?>
						<tr>
							<td width = '5%'><?php echo $key + 1; ?></td>
                            <td width = '10%'><?php echo $comment['username']; ?></td>
							<td width = '20%'><?php echo $comment['post_title']; ?></td>
                            <td width = '50%'><?php echo $comment['body']; ?></td>
                            <td width = '10%'><?php echo $comment['created_at']; ?></td>
							<td>
								<a class="btn delete" href="comments.php?delete-comment=<?php echo $comment['id'] ?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					<?php endforeach ?>
					</tbody>
				</table>
			<?php endif ?>
		</div>
	
	<?php elseif  ($_SESSION['user']['role'] == "Author"): ?>
	<h2 class="warning">YOU HAVE NO ROOTS TO ACCESS THIS PAGE </h2>

	<?php endif ?>
	
	<?php else: ?>
	<h2 class="warning">YOU HAVE NO ROOTS TO ACCESS THIS PAGE </h2>
	<?php endif ?>

</body>
</html>