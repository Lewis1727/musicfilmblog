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
                        <!-- <th>Edit profile</th> -->
					</thead>
					<tbody>					
						<tr>							
							<td><?php echo $_SESSION['user']['username']; ?></td>
							<td><?php echo $_SESSION['user']['email']; ?></td>
                            <td><?php echo $_SESSION['user']['created_at']; ?></td>
                            <!-- <td><a class="btn edit" href="edit_user.php?edit-user=<?php echo $_SESSION['user']['id'] ?>"><i class="fa fa-edit"></i></a></td>							 -->
						</tr>
				
					</tbody>
		</table>  
		
		<div class="myprofilecomments">
		<h2 class="h2comment">Your comments:</h2> 
		<?php
					global $conn;
					$query = "SELECT * FROM comments WHERE user_id = '{$_SESSION['user']['id']}' ";
					$result = mysqli_query($conn, $query);
					if ($result->num_rows>0){
					while($row = mysqli_fetch_object($result)){		
					?>
					<div class="comment-body">
					<div class="commentauthor">
						<span>
						<p><?php echo $row->post_title;?> </p>
						</span>
					</div>
					<div class="commentbody">
						<p><?php echo html_entity_decode ($row->body); ?></p></div>
					<hr>
					</div>
					<?php } ?>
					<?php }else{ ?>
						<div class="nocomments">
						<p>You haven't commented our posts...</p>
						</div>
					<?php } ?>
		</div>		
	</div>
        <?php else :?>
        <div class="banner_phone">
		<div class="login_div_phone">
			<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				    <div style="width: 60%; margin: 0px auto;">
					    <?php include(ROOT_PATH . '/includes/errors.php') ?>
				    </div>
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="password" name="password"  placeholder="Password"> 
				<button class="btn fv" type="submit" name="login_btn">Sign in</button>
			</form>
		</div>
	</div>
        <?php endif?>
	</div>
	<!-- // Page content -->
	<!-- footer -->
	<?php include( ROOT_PATH . '/includes/footer.php') ?>
	<!-- // footer -->