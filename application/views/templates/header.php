<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>eDocument for Project Management</title>

		<!-- CoreUI CSS -->
 		<link rel="stylesheet" href="https://unpkg.com/@coreui/coreui@3.0.0-rc.0/dist/css/coreui.min.css" crossorigin="anonymous">
		<link rel="stylesheet" href="https://unpkg.com/@coreui/icons@1.0.0/css/all.min.css">

		<style>
			.required {
				font-weight: bold;
				color: red;
			}
		</style>
	</head>
	<body class="c-app">
		<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
			<div class="c-sidebar-brand d-md-down-none">
				Anthive
			</div>
			<ul class="c-sidebar-nav">
				<li class="c-sidebar-nav-title">Projects</li>
				<?php 
				foreach ($projects as $project_item) {
					echo '<li class="c-sidebar-nav-item">'; 
					// If this is the first time user logs into system, project_id = 0
					echo '<a class="c-sidebar-nav-link';
					if ($project_id != '0') {
						$temp = $this->hashids->decode($project_id); 
						if ($temp[0] == $project_item['project_id']) { 
							echo '';
						}
					}
					echo '" href="'.site_url(array('document','view',$this->hashids->encode($project_item['project_id']))).'">'.$project_item['project_name'].'</a></li>';
				}
				?>
			</ul>
		</div>
		<div class="c-wrapper">
			<header class="c-header c-header-light c-header-fixed">
			<!-- Header content here -->
				<button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
					<i class="cil-hamburger-menu"></i>
				</button>
				<ul class="nav">
					<?php if ($project_id != '0'):?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Document</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo site_url(array('document','view',$project_id));?>">Document Register</a>
							<a class="dropdown-item" href="<?php echo site_url(array('document','create',$project_id));?>">Upload Document</a>
						</div>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Mail</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo site_url(array('mail','inbox',$project_id));?>">Inbox</a>
							<a class="dropdown-item" href="<?php echo site_url(array('mail','sent',$project_id));?>">Sent</a>
							<a class="dropdown-item" href="<?php echo site_url(array('mail','draft',$project_id));?>">Draft</a>
							<div class="dropdown-divider"></div>
							<a class="dropdown-item" href="<?php echo site_url(array('mail','create',$project_id));?>">Send Mail</a>
						</div>
					</li>
					<?php endif; if ($is_admin):?>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">Administration</a>
						<div class="dropdown-menu">
							<a class="dropdown-item" href="<?php echo site_url(array('user','view'));?>">User</a>
							<a class="dropdown-item" href="<?php echo site_url(array('company','view'));?>">Company</a>
							<a class="dropdown-item" href="<?php echo site_url(array('project','view'));?>">Project</a>
							<a class="dropdown-item" href="<?php echo site_url(array('file','view'));?>">File</a>
						</div>
					</li>
					<?php endif;?>
				</ul>
			</header>
			<div class="c-body">
				<main class="c-main">
					<!-- Main content here -->
					
