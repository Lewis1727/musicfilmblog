<!-- The first include should be config.php -->
<?php require_once('config.php') ?>

<?php require_once( ROOT_PATH . '/includes/public_functions.php') ?>
<?php require_once( ROOT_PATH . '/includes/registration_login.php') ?>

<?php require_once( ROOT_PATH . '/includes/head_section.php') ?>
    <title>LifeBlog | MyProfile </title>
</head>
<body>
	<!-- container - wraps whole page -->
	<div class="container">
		<!-- navbar -->
		<?php include( ROOT_PATH . '/includes/navbar.php') ?>
        <!-- // navbar -->
        <!-- Page content -->
		<div class="content">        
        <?php if (isset($_SESSION['user']['username'])): ?>    
        <div class="my-profile-div">
        <table class="table">
					<thead>						
						<th>Name</th>
						<th>Email</th>
                        <th>You loined us on</th>
                        <th>Edit profile</th>
					</thead>
					<tbody>					
						<tr>							
							<td><?php echo $_SESSION['user']['username']; ?></td>
							<td><?php echo $_SESSION['user']['email']; ?></td>
                            <td><?php echo $_SESSION['user']['created_at']; ?></td>
                            <td><a class="btn edit" href="edit_user.php?edit-user=<?php echo $_SESSION['user']['id'] ?>"><i class="fa fa-edit"></i></a></td>							
						</tr>
				
					</tbody>
        </table>  
        </div>
        <?php else :?>
        <div class="banner">
		    <div class="welcome_msg">
			<h1>Quote of the Day</h1>
			<p> 
			    “He looked at her the way <br> 
			    all women want to be looked at by a man.” <br> 
				<span>~ The Great Gatsby</span>
			</p>
			<a href="register.php" class="btn">Join us!</a>
		</div>

		<div class="login_div">
			<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				    <div style="width: 60%; margin: 0px auto;">
					    <?php include(ROOT_PATH . '/includes/errors.php') ?>
				    </div>
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="password" name="password"  placeholder="Password"> 
				<button class="btn" type="submit" name="login_btn">Sign in</button>
			</form>
		</div>
	</div>
        <?php endif?>
		</div>
	<!-- // Page content -->
	<!-- footer -->
	<?php include( ROOT_PATH . '/includes/footer.php') ?>
	<!-- // footer -->