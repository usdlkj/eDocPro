<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>eDocument for Project Management</title>

    <!-- CoreUI -->
    <link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-rc.0/dist/css/coreui.min.css"
        crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.15.0/umd/popper.min.js"
        integrity="sha384-L2pyEeut/H3mtgCBaUNw7KWzp5n9&#43;4pDQiExs933/5QfaTh8YStYFFkOzSoXjlTb" crossorigin="anonymous">
    </script>
    <script src="https://unpkg.com/@coreui/coreui@3.0.0-rc.0/dist/js/coreui.min.js"></script>

    <!-- DataTables -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/dt/jq-3.3.1/jszip-2.5.0/dt-1.10.20/af-2.3.4/b-1.6.1/b-colvis-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/cr-1.5.2/fc-3.3.0/fh-3.1.6/kt-2.5.1/r-2.2.3/rg-1.1.1/rr-1.2.6/sc-2.0.1/datatables.min.js">
    </script>
	
	<!-- Select2 -->
	<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
	
	<!-- Datepicker -->
	<link rel="stylesheet" href="<?php echo base_url();?>public/css/datepicker.css"/>
	<script type="text/javascript" src="<?php echo base_url();?>public/js/bootstrap-datepicker.js"></script>

    <style>
    .required {
        font-weight: bold;
        color: red;
    }
    </style>
</head>

<body>
	<div class="container">
		<div class="row mt-5">
			<div class="col"></div>
			<div class="col-6 card text-center">
				<h2>Welcome to Anthive!</h2>
				<div>
					<?php echo form_open('user/login',array('class' => 'form-signin', 'data-toggle' => 'validator'));?>
						<h4 class="text-center">Please sign in</h4>
						<div class="form-group has-success has-feedback">
							<label for="login" class="sr-only">Username</label>
							<input type="text" name="login" class="form-control" placeholder="Username" required autofocus>
						</div>
						<div class="form-group has-success has-feedback">
							<label for="password" class="sr-only">Password</label>
							<input type="password" name="password" class="form-control" placeholder="Password" required>
						</div>
						<button class="btn btn-primary w-25" type="submit">Sign in</button>
						<?php if (isset($message)): echo '<br />'.$message; endif;?>
					</form>
				</div>
			</div>
			<div class="col"></div>
		</div>
		<div class="row">
			<div class="col">
				<p class="text-center">
					&copy; 2015 <a href="mailto:warnin@gmail.com">Ivan Tanu</a>. All rights reserved.<br/>
					Handcrafted with love and a lot of Nuka-cola.
				</p>
			</div>
		</div>
	</div> <!-- /container -->
</body>
</html>
