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
			<!-- <a href="register.php" class="btn">Join us!</a> -->
			<?php endforeach ?>
		</div>


		<div class="logged_in_info">
		<h2>Welcome, <?php echo $_SESSION['user']['username'] ?>!</h2>
		<a href="logout.php" class="btnlogout">LOGOUT</a>
		</div>
	</div>
<?php }else{ ?>
	<div class="banner">


		<div class="welcome_msg">
			<!-- <div class="animated-border-quote">
			<blockquote>
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
				<cite>
				<span>~ <?php echo $quote['quote_author'] ?></span>
				</cite>
				</p>
				<a href="register.php" class="btn">Join us!</a>
				<?php endforeach ?>
			</blockquote>
			</div> -->
			<!-- <h2>Quote of the Day</h2> -->
			<div id="ct">
			<div class="corner "id="left_top"></div>
			<div class="corner" id="left_bottom"></div>
			<div class="corner" id="right_top"></div>
			<div class="corner" id="right_bottom"></div>
			<span class="span">~ <?php echo $quote['quote_author'] ?></span>
			<blockquote>
				<p><i>&ldquo;<?php echo $quote['quote_text'] ?>&rdquo; </i></p>
			</blockquote>
			</div>

		</div>

		<div class="login_div">
			<form action="<?php echo BASE_URL . 'index.php'; ?>" method="post" >
				<h2>Login</h2>
				<!-- <div style="width: 60%; margin: 0px auto; top: -13px; position: relative; margin-bottom: -25px;"> -->
					<?php include(ROOT_PATH . '/includes/errors.php') ?>
				<!-- </div> -->
				<input type="text" name="username" value="<?php echo $username; ?>" placeholder="Username">
				<input type="password" name="password"  placeholder="Password"> 
				<!-- <button class="btn" type="submit" name="login_btn">Sign in</button> -->
				<button class="but" type="submit" name="login_btn">Sign in</button>

				<!-- <a href="register.php" class="btn">Join us!</a> -->
				
			</form>
		</div>

	</div>
<?php } ?>
