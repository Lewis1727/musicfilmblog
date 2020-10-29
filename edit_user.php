<!-- The first include should be config.php -->
<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>

<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
    <title>LifeBlog | EditUser </title>
</head>
<body>
<div class="container">
		<!-- navbar -->
        <?php include( ROOT_PATH . '/includes/navbar.php') ?>
        <div class="content">
        <div class="action">
            <!-- <h1 class="page-title">Edit User</h1> -->
            <hr>
			<h2 class="content-title">Edit User</h2>
			<hr>
			<form method="post" action="<?php echo BASE_URL . 'edit_user.php'; ?>" >

				<!-- validation errors for the form -->
				<?php include(ROOT_PATH . '/includes/errors.php') ?>

				<!-- if editing user, the id is required to identify that user -->
				<?php if ($isEditingUser === true): ?>
					<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
				<?php endif ?>

				<input type="text" name="username" value="<?php echo $_SESSION['user']['username']; ?>" placeholder="Username">
				<input type="email" name="email" value="<?php echo $_SESSION['user']['email']; ?>" placeholder="Email">
				<input type="password" name="password" placeholder="Password">
				<input type="password" name="passwordConfirmation" placeholder="Password Confirmation">
				

				<!-- if editing user, display the update button instead of create button -->
				<?php if ($isEditingUser === true): ?> 
					<button type="submit" class="btn" name="update_user">UPDATE</button>
				<?php endif ?>
			</form>
        </div>
</div>
		<!-- // Middle form - to create and edit -->
<!-- // Page content -->
	<!-- footer -->
	<?php include( ROOT_PATH . '/includes/footer.php') ?>
	<!-- // footer -->