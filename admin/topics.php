<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics from DB -->
<?php $topics = getAllTopics();	?>
	<title>Admin | Manage Topics</title>
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

		<!-- Middle form - to create and edit -->
		<div class="action">
			<h1 class="page-title">Create/Edit Topics</h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/topics.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- if editing topic, the id is required to identify that topic -->
				<?php if ($isEditingTopic === true): ?>
					<input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
				<?php endif ?>
				<input type="text" name="topic_name" value="<?php echo $topic_name; ?>" placeholder="Topic">
				<input type="text" name="topic_id" value="<?php echo $topic_id; ?>" placeholder="Topic ID">
				<!-- if editing topic, display the update button instead of create button -->
				<?php if ($isEditingTopic === true): ?> 
					<button type="submit" class="btn" name="update_topic">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_topic">Save Topic</button>
				<?php endif ?>
			</form>
		</div>
		<!-- // Middle form - to create and edit -->

		<!-- Display records from DB-->
		<div class="table-div" style="width: 45%; margin-top: 10px;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($topics)): ?>
				<h1>No topics in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th></th>
						<th>Topic Name</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($topics as $key => $topic): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $topic['name']; ?></td>
							<td>
								<a class="btn edit" href="topics.php?edit-topic=<?php echo $topic['id'] ?>"><i class="fa fa-edit"></i></a>
							</td>
							<td>
								<a class="btn delete" href="topics.php?delete-topic=<?php echo $topic['id'] ?>"><i class="fa fa-trash"></i></a>
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
	<?php elseif ($_SESSION['user']['role'] == "Author"): ?>>
	
	<h2 class="warning">YOU HAVE NO ROOTS TO ACCESS THIS PAGE </h2>

<?php endif ?>
	<?php else: ?>
	
	<h2 class="warning">YOU HAVE NO ROOTS TO ACCESS THIS PAGE </h2>

	<?php endif ?>
</body>
</html>