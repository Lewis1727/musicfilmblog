<?php  include('../config.php'); ?>
<?php  include(ROOT_PATH . '/admin/includes/admin_functions.php'); ?>
<?php include(ROOT_PATH . '/admin/includes/head_section.php'); ?>
<!-- Get all topics from DB -->
<?php $quotes = getAllQuotes();	?>
	<title>Admin | Manage Quotes</title>
</head>
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
			<h1 class="page-title">Create/Edit Quote</h1>
			<form method="post" action="<?php echo BASE_URL . 'admin/quotes.php'; ?>" >
				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- if editing topic, the id is required to identify that topic -->
				<?php if ($isEditingQuote === true): ?>
					<input type="hidden" name="id" value="<?php echo $quote_id; ?>">
				<?php endif ?>
				<input type="text" name="quote_text" value="<?php echo $quote_text; ?>" placeholder="Text">
				<input type="text" name="quote_author" value="<?php echo $quote_author; ?>" placeholder="Author">
				<!-- if editing topic, display the update button instead of create button -->
				<?php if ($isEditingQuote === true): ?> 
					<button type="submit" class="btn" name="update_quote">UPDATE</button>
				<?php else: ?>
					<button type="submit" class="btn" name="create_quote">Save Quote</button>
				<?php endif ?>
			</form>
		</div>
        	<!-- // Middle form - to create and edit -->
            <!-- Display records from DB-->
		<div class="table-div" style="width: 45%; margin-top: 10px;">
			<!-- Display notification message -->
			<?php include(ROOT_PATH . '/includes/messages.php') ?>
			<?php if (empty($quotes)): ?>
				<h1>No quotes in the database.</h1>
			<?php else: ?>
				<table class="table">
					<thead>
						<th></th>
						<th>Quote Text</th>
                        <th>Quote Author</th>
						<th colspan="2">Action</th>
					</thead>
					<tbody>
					<?php foreach ($quotes as $key => $quote): ?>
						<tr>
							<td><?php echo $key + 1; ?></td>
							<td><?php echo $quote['quote_text']; ?></td>
							<td><?php echo $quote['quote_author']; ?></td>
							<td>
								<a class="btn edit" href="quotes.php?edit-quote=<?php echo $quote['id'] ?>"><i class="fa fa-edit"></i></a>
							</td>
							<td>
								<a class="btn delete" href="quotes.php?delete-quote=<?php echo $quote['id'] ?>"><i class="fa fa-trash"></i></a>
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