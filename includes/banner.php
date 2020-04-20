<?php 
	$quotes = getAllQuotes();
?>
<?php if (isset($_SESSION['user']['username'])) { ?>
	
	<div class="bannerloggedin">
	<div class="welcome_msg">
			<h2>Quote of the Day</h2>
			<?php
			global $conn;
			$query = "SELECT * FROM quote_of_the_day ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($conn, $query);
			mysqli_fetch_object($result);	
			?>
			<?php foreach ($quotes as $quote): ?>
			<p>“<?php echo $quote['quote_text'] ?>” 
			<br> 
			<span>~ <?php echo $quote['quote_author'] ?></span>
			</p>
			<a href="register.php" class="btn">Join us!</a>
			<?php endforeach ?>
		</div>


		<div class="logged_in_info">
		<h2>Welcome, <?php echo $_SESSION['user']['username'] ?>!</h2>
		<a href="logout.php" class="btnlogout">LOGOUT</a>
		</div>
	</div>
<?php }else{ ?>
	<div class="banner">
		<!-- <div class="welcome_msg">
			<h2>Quote of the Day</h2>
			<p> 
			    “He looked at her the way <br> 
			    all women want to be looked at by a man.” <br> 
				<span>~ The Great Gatsby</span>
			</p>
			<a href="register.php" class="btn">Join us!</a>
		</div> -->

		<div class="welcome_msg">
			<h2>Quote of the Day</h2>
			<?php
			global $conn;
			$query = "SELECT * FROM quote_of_the_day ORDER BY id DESC LIMIT 1";
			$result = mysqli_query($conn, $query);
			mysqli_fetch_object($result);	
			?>
			<?php foreach ($quotes as $quote): ?>
			<p>“<?php echo $quote['quote_text'] ?>” 
			<br> 
			<span>~ <?php echo $quote['quote_author'] ?></span>
			</p>
			<a href="register.php" class="btn">Join us!</a>
			<?php endforeach ?>
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
<?php } ?>