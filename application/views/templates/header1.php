<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
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
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/bootstrap.min.css"/>
			
		<!-- Custom styles for this template -->
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/dashboard.css"/>
			
		<!-- DataTables -->
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/datatables.min.css"/>
		<script type="text/javascript" src="<?php echo base_url();?>public/js/datatables.min.js"></script>
		
		<!-- Select2 -->
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/css/select2.min.css" />
		<link rel="stylesheet" href="//select2.github.io/select2-bootstrap-theme/css/select2-bootstrap.css"/>
		<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1-rc.1/js/select2.min.js"></script>
		
		<!-- Datepicker -->
		<link rel="stylesheet" href="<?php echo base_url();?>public/css/datepicker.css"/>
		<script type="text/javascript" src="<?php echo base_url();?>public/js/bootstrap-datepicker.js"></script>
		
		<!-- Validator -->
		<script type="text/javascript" src="<?php echo base_url();?>public/js/validator.js"></script>
		
		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		<style>
			.required {
				font-weight: bold;
				color: red;
			}
		</style>
	</head>
	<body>
		<script>
		$(document).ready( function() {
			$(".alert").fadeOut(5000);
		} );
		</script>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="#">eDocPro</a>
				</div>
				<div id="navbar" class="navbar-collapse collapse">
					<ul class="nav navbar-nav">
						<?php if ($project_id != '0'):?><li class="dropdown">
							<a href="<?php echo site_url(array('document','view',$project_id));?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Document <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url(array('document','view',$project_id));?>">Document Register</a></li>
								<li><a href="<?php echo site_url(array('document','create',$project_id));?>">Upload Document</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="<?php echo site_url(array('mail','view',$project_id));?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> Mail <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url(array('mail','inbox',$project_id));?>">Inbox</a></li>
								<li><a href="<?php echo site_url(array('mail','sent',$project_id));?>">Sent</a></li>
								<li><a href="<?php echo site_url(array('mail','draft',$project_id));?>">Draft</a></li>
								<li role="separator" class="divider"></li>
								<li><a href="<?php echo site_url(array('mail','create',$project_id));?>">Send Mail</a></li>
							</ul>
						</li>
						<?php endif; if ($is_admin):?><li class="dropdown">
							<a href="<?php echo site_url(array('user','view'));?>" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Administration <span class="caret"></span></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url(array('user','view'));?>">User</a></li>
								<li><a href="<?php echo site_url(array('company','view'));?>">Company</a></li>
								<li><a href="<?php echo site_url(array('project','view'));?>">Project</a></li>
								<li><a href="<?php echo site_url(array('file','view'));?>">File</a></li>
							</ul>
						</li>
						<?php endif;?>
			
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li><a href="#">Welcome <?php echo $name;?></a></li>
						<li><a href="<?php echo site_url(array('user','logout'));?>">Logout</a></li>
					</ul>
				</div>
			</div>
		</nav>

		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-3 col-md-2 sidebar">
					<ul class="nav nav-sidebar">
						<?php foreach ($projects as $project_item):?><li<?php if ($project_id != '0'): $temp = $this->hashids->decode($project_id); if ($temp[0] == $project_item['project_id']): echo ' class="active"'; endif; endif;?>><a href="<?php echo site_url(array('document','view',$this->hashids->encode($project_item['project_id'])));?>"><?php echo $project_item['project_name'];?></a></li>
						<?php endforeach;?>
						
					</ul>
				</div>
				<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
					<h2 class="sub-header"><?php echo $title;?></h2>
