<?php
	/**
	 * media index page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 16th Dec 2013
	 */
	 
	 require_once('views/_templates/sidebar.php');
?>
		<div class="content">
        	<div class="header">
            	<h1 class="page-title">Media Manager</h1>
            </div> <!-- .header -->
            <ul class="breadcrumb">
        	    <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
    	        <li class="active">Media Manager</li>
	        </ul>
            <div class="container-fluid">
            	<div class="row-fluid">
				<div>					
                	<form id="uploader" method="post">
						<button id="home" name="home" type="button" value="Home">&nbsp;</button>
						<h1></h1>
						<div id="uploadresponse"></div>
						<input id="mode" name="mode" type="hidden" value="add" /> 
						<input id="currentpath" name="currentpath" type="hidden" />
						<div id="file-input-container">
							<div id="alt-fileinput">
								<input id="filepath" name="filepath" type="text" /><button id="browse" name="browse" type="button" value="Browse"></button>
							</div>
							<input id="newfile" name="newfile" type="file" />
						</div>
						<button id="upload" name="upload" type="submit" value="Upload"></button>
						<button id="newfolder" name="newfolder" type="button" value="New Folder"></button>
						<button id="grid" class="ON" type="button">&nbsp;</button>
						<button id="list" type="button">&nbsp;</button>
					</form>
					<div id="splitter">
						<div id="filetree"></div>
						<div id="fileinfo">
							<h1></h1>
						</div>
					</div>
					<form name="search" id="search" method="get">
					<div>
						<input type="text" value="" name="q" id="q" autocomplete="off" />
						<a id="reset" href="#" class="q-reset"></a>
						<span class="q-inactive"></span>
					</div> 
					</form>
                    <ul id="itemOptions" class="contextMenu">
                        <li class="select"><a href="#select"></a></li>
                        <li class="download"><a href="#download"></a></li>
                        <li class="rename"><a href="#rename"></a></li>
                        <li class="move"><a href="#move"></a></li>
                        <li class="delete separator"><a href="#delete"></a></li>
                    </ul>
                </div>
                </div>
            </div>
        </div> <!-- .content -->
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.filetree/jqueryFileTree.css" />
        <link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.contextmenu/jquery.contextMenu-1.01.css" />
		<link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/media-manager/styles/filemanager.css" />
        <!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?=ADMIN_URL?>/public/lib/media-manager/styles/ie.css" />
		<![endif]-->
        
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/javascripts/jquery-migrate-1.2.0.min.js"></script>
		<script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.form-3.24.js"></script>
		<script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.splitter/jquery.splitter-1.5.1.js"></script>
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.filetree/jqueryFileTree.js"></script>
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.contextmenu/jquery.contextMenu-1.01.js"></script>
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.impromptu-3.2.min.js"></script>
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/jquery.tablesorter-2.7.2.min.js"></script>
        <script type="text/javascript" src="<?=ADMIN_URL?>/public/lib/media-manager/scripts/filemanager.js"></script>