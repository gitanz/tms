<?php
	/**
	 * mysql backup page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 17th Dec 2013
	 */
	 
	require_once('views/_templates/sidebar.php');
	
	//Path to folder which contains images
	$dirname = BACKUP_DIRECTORY;
	//Use glob function to get the files
	$sqlfiles = glob($dirname."*.sql");
	@array_multisort(array_map('filemtime', $sqlfiles), SORT_NUMERIC, SORT_DESC, $sqlfiles);
?>
		<div class="content">        
	        <div class="header">            
	            <h1 class="page-title">Database Backup</h1>
    	    </div>        
            <ul class="breadcrumb">
	            <li><a href="<?=ADMIN_URL?>">Home</a> <span class="divider">/</span></li>
        	    <li class="active">Database Backup</li>
	        </ul>
	        <div class="container-fluid">
    	        <div class="row-fluid">
                	<div class="btn-toolbar">
                        <a class="btn btn-primary" href="<?=ADMIN_URL?>/system/backup_db"><i class="icon-upload"></i> Create New Backup</a>
                      	<div class="btn-group"></div>
                    </div>
                    <?php if (isset($_COOKIE['DBBackupCookie'])) : ?>
                	<div class="alert alert-success">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
                        Database backup is <?=$_COOKIE['DBBackupCookie']?> successfully.
                	</div>
	                <?php setcookie ("DBBackupCookie", "", time() - 3600); endif; ?>
                    <?php if (isset($this->errors)) : ?>
                	<div class="alert alert-error">
                    	<button data-dismiss="alert" class="close" type="button">×</button>
						<?php 
                            foreach ($this->errors as $error) : 
                                echo $error;
                            endforeach; 
                        ?>
                	</div>
                	<?php endif; ?>
                    <?php if($this->confirmDelete == true): ?>
					<div class="alert alert-info">
                        <p>Do you really want to delete?</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/system/backup_delete/<?=$this->sql_file?>/<?=$this->confirmDelete?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/system/backup" type="submit">No</a>
                	</div>
					<?php endif; ?>
                    <?php if($this->confirmRestore == true): ?>
					<div class="alert alert-warning">
                        <p>Do you really want to restore database? It will erase all the existing database and replace with old one.</p> 
                        <a class="btn btn-danger" href="<?=ADMIN_URL?>/system/backup_restore/<?=$this->sql_file?>/<?=$this->confirmRestore?>">Yes</a> <a class="btn" href="<?=ADMIN_URL?>/system/backup" type="submit">No</a>
                	</div>
					<?php endif; ?>
					<div class="well">
                     	<table class="table">
                        	<thead>
                            	<tr>
                                	<th>#</th>
		                            <th>Name</th>
                		            <th>Created Date</th>
                        		    <th style="width: 30px;"></th>
                               	</tr>
                            </thead>
                            <tbody>
                            <?php 
								if($sqlfiles):
									$row = 1;
									foreach($sqlfiles as $sqlfile) : 
										$filesize = filesize($sqlfile)/1024;
										$filesize = number_format($filesize, 2, '.', '');
										$created = date("D, jS M Y. g:i A", filemtime($sqlfile));
							?>
                            	<tr>
	                               	<td><?=$row?></td>
	                              	<td><?=basename($sqlfile)?> (<?=$filesize?> KB)</td>
                               		<td><?=$created?></td>
                               		<td>
                                 		<a href="<?=ADMIN_URL?>/system/backup_restore/<?=basename($sqlfile)?>" title="Restore" rel="tooltip"><i class="icon-refresh"></i></a>
                                   		<a href="<?=ADMIN_URL?>/system/backup_delete/<?=basename($sqlfile)?>" title="Remove" rel="tooltip"><i class="icon-remove"></i></a>
                               		</td>
                               	</tr>
                            <?php
									$row++; 
									endforeach; 
								else:
							?>
                               	<tr>
                            	    <td colspan="4" align="center">
	                                    <div class="alert alert-error">
    	                                    Back up not created yet. Create new backup to display here.
                                        </div>
                                    </td>
                                </tr>
                           	<?php
								endif;
							?>
							</tbody>
                    	</table>                               	
					</div> <!-- .well -->
				</div> <!-- .row-fluid -->
           		<?php require_once('views/_templates/footer-info.php');?>                    
            </div> <!-- .container-fluid -->
        </div> <!-- .content -->