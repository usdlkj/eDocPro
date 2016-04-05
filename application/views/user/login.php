<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>eDocument for Project Management</title>
	
	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<script src="<?php echo base_url();?>public/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url();?>public/js/docs.min.js"></script>
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script src="<?php echo base_url();?>public/js/ie10-viewport-bug-workaround.js"></script>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>/public/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url();?>/public/css/signin.css" rel="stylesheet">
	
	<!-- Validator -->
	<script type="text/javascript" src="<?php echo base_url();?>public/js/validator.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

		<?php echo form_open('user/login',array('class' => 'form-signin', 'data-toggle' => 'validator'));?>
			<h2 class="form-signin-heading">Please sign in</h2>
			<div class="form-group has-success has-feedback">
				<label for="login" class="sr-only">Username</label>
				<input type="text" name="login" class="form-control" placeholder="Username" required autofocus>
			</div>
			<div class="form-group has-success has-feedback">
				<label for="password" class="sr-only">Password</label>
				<input type="password" name="password" class="form-control" placeholder="Password" required>
			</div>
			<div class="checkbox">
				<label>
					<input type="checkbox" value="remember-me"> Remember me
				</label>
			</div>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
			
			<?php if (isset($message)): echo '<br />'.$message; endif;?>
		</form>
		
		<p class="text-center">
			&copy; 2015 <a href="mailto:warnin@gmail.com">Ivan Tanu</a>. All rights reserved.<br/>
			Handcrafted with love and a lot of Nuka-cola.
		</p>

    </div> <!-- /container -->
  </body>
</html>
