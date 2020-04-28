<?php
session_start();
?>

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
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar"
                data-class="c-sidebar-lg-show" responsive="true">
                <i class="cil-hamburger-menu"></i>
            </button>
            <ul class="nav">
                <?php if ($project_id != '0'):?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">Document</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                            href="<?php echo site_url(array('document','view',$project_id));?>">Document Register</a>
                        <a class="dropdown-item"
                            href="<?php echo site_url(array('document','create',$project_id));?>">Upload Document</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">Mail</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                            href="<?php echo site_url(array('mail','inbox',$project_id));?>">Inbox</a>
                        <a class="dropdown-item"
                            href="<?php echo site_url(array('mail','sent',$project_id));?>">Sent</a>
                        <a class="dropdown-item"
                            href="<?php echo site_url(array('mail','draft',$project_id));?>">Draft</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo site_url(array('mail','create',$project_id));?>">Send
                            Mail</a>
                    </div>
                </li>
                <?php endif; if ($is_admin):?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button"
                        aria-expanded="false">Administration</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?php echo site_url(array('user','view'));?>">User</a>
                        <a class="dropdown-item" href="<?php echo site_url(array('company','view'));?>">Company</a>
                        <a class="dropdown-item" href="<?php echo site_url(array('project','view'));?>">Project</a>
                        <a class="dropdown-item" href="<?php echo site_url(array('file','view'));?>">File</a>
                    </div>
                </li>
                <?php endif;?>
            </ul>
			<div class="col-2 mt-2">
				<a href="<?php echo site_url(array('user','logout'));?>">Logout</a>
			</div>
        </header>
        <div class="c-body">
            <main class="c-main">
                <!-- Main content here -->