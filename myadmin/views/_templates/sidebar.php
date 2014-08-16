<?php
	/**
	 * sidebar page of the admin template
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 12th Dec 2013
	 */
	 // echo $filename;
?>    	
        <!--<br />-->
        <div class="sidebar-nav">
        	<form class="search form-inline">
            <!--<input type="text" placeholder="Search...">-->
        	</form>
	        <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
    	    <ul id="dashboard-menu" class="nav nav-list collapse
            <?php
				if ( ($this->checkForActiveController($filename, "media"))
						|| ($this->checkForActiveController($filename, "system"))
						|| ($this->checkForActiveController($filename, "index"))) echo ' in'; ?>
             ">
        	    <li><a href="<?=ADMIN_URL?>" title="Home">Home</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "system/counter")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/system/counter">Counter</a></li>
                <li<?php if ( ($this->checkForActiveControllerAndAction($filename, "system/backup")) 
								|| ($this->checkForActiveControllerAndAction($filename, "system/backup_db")) ) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/system/backup">Backup Database</a></li>
	        </ul>
	        
            <a href="#nav-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-list-ul"></i>Site Menu <i class="icon-chevron-up"></i></a>
    	    <ul id="nav-menu" class="nav nav-list collapse            
            <?php if ( ($this->checkForActiveController($filename, "menu"))) echo ' in'; ?>">
        	    <li<?php if ($this->checkForActiveControllerAndAction($filename, "menu/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/menu/create">Add New</a></li>
            	<li<?php if ($this->checkForActiveControllerAndAction($filename, "menu/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/menu/lists">View All</a></li>
	            <li<?php if ($this->checkForActiveControllerAndAction($filename, "menu/order")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/menu/order">Rearrange Menu Order</a></li>
    	    </ul>
            
            <a href="#page-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-list"></i>Pages <i class="icon-chevron-up"></i></a>
    	    <ul id="page-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "pages"))) echo ' in'; ?>">
        	    <li<?php if ($this->checkForActiveControllerAndAction($filename, "pages/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/pages/create">Add New</a></li>
            	<li<?php if ($this->checkForActiveControllerAndAction($filename, "pages/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/pages/lists">View All</a></li>
    	    </ul>
            
            <a href="#banner-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th-large"></i>Banners <i class="icon-chevron-up"></i></a>
    	    <ul id="banner-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "banners"))) echo ' in'; ?>">
        	    <li<?php if ($this->checkForActiveControllerAndAction($filename, "banners/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/banners/create">Add New</a></li>
            	<li<?php if ($this->checkForActiveControllerAndAction($filename, "banners/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/banners/lists">View All</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "banners/order")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/banners/order">Rearrange Banner Order</a></li>
    	    </ul>
            <a href="#testimonial-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-book"></i>Testimonials <i class="icon-chevron-up"></i></a>
            <ul id="testimonial-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "testimonials"))) echo ' in'; ?>">
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "testimonials/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/testimonials/create">Add New</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "testimonials/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/testimonials/lists">View All</a></li>                
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "testimonials/order")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/testimonials/order">Rearrange Order</a></li>                
            
            </ul>
            <a href="#news-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-calendar"></i>News and Events<i class="icon-chevron-up"></i></a>
            <ul id="news-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "news"))) echo ' in'; ?>">
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "news/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/news/create">Add New</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "news/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/news/lists">View All</a></li>                
            </ul>
            <a href="#trip-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-th-large"></i>Itinerary <i class="icon-chevron-up"></i></a>
            <ul id="trip-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "itinerary"))) echo ' in'; ?>">
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "itinerary/form")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/itineraries/create">Add New</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "itinerary/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/itineraries/lists">View All</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "itinerary/categories")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/itineraries/categories">Add/Remove Categories</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "itinerary/bookings")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/itineraries/bookings">Bookings</a></li>
                <li<?php if ($this->checkForActiveControllerAndAction($filename, "itinerary/plans")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/itineraries/plans">Plans</a></li>

            </ul>
           <!--  <a href="#gallery-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-picture"></i>Gallery <i class="icon-chevron-up"></i></a>
    	    <ul id="gallery-menu" class="nav nav-list collapse<?php if ( ($this->checkForActiveController($filename, "gallery"))) echo ' in'; ?>">
        	    <li<?php if ($this->checkForActiveControllerAndAction($filename, "gallery/create")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/gallery/create">Add New</a></li>
            	<li<?php if ($this->checkForActiveControllerAndAction($filename, "gallery/index")) { echo ' class="active" '; } ?>><a href="<?=ADMIN_URL?>/gallery/lists">View All</a></li>                
    	    </ul> -->
            <a href="<?=ADMIN_URL?>/users/logout" class="nav-header" ><i class="icon-signout"></i>Log Out</a>
	    </div>