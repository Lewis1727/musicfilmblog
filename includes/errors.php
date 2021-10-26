<?php if (count($errors) > 0) : ?>
	<div style="width: 60%; margin: 0px auto; top: -13px; position: relative; margin-bottom: -25px;">
  		<div class="message error validation_errors" >
  			<?php foreach ($errors as $error) : ?>
  	  			<p><?php echo $error ?></p>
  			<?php endforeach ?>
  		</div>
	</div>
<?php endif ?>
