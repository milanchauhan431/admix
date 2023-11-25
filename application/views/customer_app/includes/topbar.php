    
<body class="theme-light" data-highlight="blue2">
    
	<div id="preloader"><div class="spinner-border color-highlight" role="status"></div></div>
		
	<div id="page">
		
		<!-- header and footer bar go here-->
		<div class="header header-fixed header-auto-show header-logo-app header-active">
			<a href="#" class="header-title">Admix</a>
			<a href="#" data-menu="menu-main" class="header-icon header-icon-1"><i class="fas fa-bars"></i></a>
			<a href="<?=base_url('customerApp/login/logout')?>" data-menu="menu-highlights" class="header-icon header-icon-2 font-19 font-700"  data-menu="menu-main"><i class="fas fa-power-off"></i></a>
			<a href="<?=base_url($headData->controller.'/addOrder');?>"  data-menu="menu-main" class="header-icon header-icon-3 show-on-theme-light font-19 font-700 "><i class="fas fa-plus"></i></a>
			
		</div>
		<div id="footer-bar" class="footer-bar-5">
			<a href="<?=base_url("customerApp/dashboard")?>" class="<?=($headData->menu_id == 0)?'active-nav':''?>"><i data-feather="home" data-feather-line="1" data-feather-size="21" data-feather-color="blue-dark" data-feather-bg="blue-fade-light"></i><span>Home</span></a>
			<a href="<?=base_url("customerApp/dashboard/orderList")?>" class="<?=($headData->menu_id == 1)?'active-nav':''?>"><i data-feather="file" data-feather-line="1" data-feather-size="21" data-feather-color="brown-dark" data-feather-bg="brown-fade-light"></i><span>My Orders</span></a>
		</div>