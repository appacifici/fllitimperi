<!DOCTYPE html>
<!--[if lt IE 7]> <html class="ie lt-ie9 lt-ie8 lt-ie7 paceCounter paceSocial sidebar sidebar-social footer-sticky"> <![endif]-->
<!--[if IE 7]>    <html class="ie lt-ie9 lt-ie8 paceCounter paceSocial sidebar sidebar-social footer-sticky"> <![endif]-->
<!--[if IE 8]>    <html class="ie lt-ie9 paceCounter paceSocial sidebar sidebar-social footer-sticky"> <![endif]-->
<!--[if gt IE 8]> <html class="ie paceCounter paceSocial sidebar sidebar-social footer-sticky"> <![endif]-->
<!--[if !IE]><!--><html class="paceCounter paceSocial sidebar sidebar-social footer-sticky"><!-- <![endif]-->
<head>
	<title>Social Test</title>
	
	<!-- Meta -->
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
	
	<!-- 
	**********************************************************
	In development, use the LESS files and the less.js compiler
	instead of the minified CSS loaded by default.
	**********************************************************
	<link rel="stylesheet/less" href="../assets/less/admin/module.admin.stylesheet-complete.less" />
	-->

		<!--[if lt IE 9]><link rel="stylesheet" href="../assets/components/library/bootstrap/css/bootstrap.min.css" /><![endif]-->
	
		
	<?php
$skin = isset($_GET['skin']) && $_GET['skin'] !== 'style-default' ? $_GET['skin'] : false;
if ($skin)
	echo '<link href="' . ASSETS_PATH . '/css/skins/module.' . $module . '.stylesheet-complete.skin.' . $skin . '.min.css" rel="stylesheet" />';
else
	echo '<link href="' . ASSETS_PATH . '/css/' . $module . '/module.' . $module . '.stylesheet-complete.min.css" rel="stylesheet" />';
?>

	
	
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

	<?php 
foreach ($scripts as $id => $script)
{
	$sections = !empty($script['sections']) && !empty($script['sections'][$page]);
	$inPages = in_array($page, $script['pages']);
	$inSections = !$sections ? false : in_array($section, $script['sections'][$page]);

	if ($script['header'] && ((!$sections && $inPages) || ($sections && $inSections)))
		echo '<script src="' . $script['file'] . '"></script>' . "\n\t";
} 
?>
	<script>if (/*@cc_on!@*/false && document.documentMode === 10) { document.documentElement.className+=' ie ie10'; }</script>
	
</head>
<body class=" menu-right-hidden">
	
	<!-- Main Container Fluid -->
	<div class="container-fluid menu-hidden ">

						<!-- Main Sidebar Menu -->
		<div id="menu" class="hidden-print hidden-xs sidebar-default sidebar-brand-primary">

			
<div id="sidebar-social-wrapper">
	<div id="brandWrapper">
		<a href="<?php echo getURL(array('page'=>'index')); ?>"><span class="text">Social Test</span></a>
	</div>
	<ul class="menu list-unstyled">
		<?php Menu::make($config["menu"]["admin"], $page, $module); ?>	</ul>
</div>





			
		</div>
		<!-- // Main Sidebar Menu END -->
				
		
		

<div id="menu-right">
	<div>
		<button class="btn btn-inverse btn-xs btn-close" data-toggle="sidr-close" data-menu="menu-right"><i class="fa fa-times"></i></button>

		<div class="tab-content">
			<div class="tab-pane" id="chat-conversation">
				<ul>
					<li>
						<div class="innerAll"><button class="btn btn-primary" data-toggle="tab" data-target="#chat-list"><i class="fa fa-fw fa-user"></i> friends</button></div>
					</li>
					<li class="conversation innerAll">
						<!-- Media item -->
						<div class="media">
							<small class="author"><a href="#" title="" class="strong">Jane Doe</a></small>
							<div class="media-object pull-left"><img src="../assets/images/people/50/1.jpg" alt="Image" class="img-circle" /></div>
							<div class="media-body">
								<blockquote>
									<small class="date"><cite>just now</cite></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Necessitatibus, sit?</p>
								</blockquote>
							</div>
						</div>
						<!-- // Media item END -->
						
						<!-- Media item -->
						<div class="media primary right">
							<small class="author"><a href="#" title="" class="strong">John Doe</a></small>
							<div class="media-object pull-right"><img src="../assets/images/people/50/2.jpg" alt="Image" class="img-circle" /></div>
							<div class="media-body">
								<blockquote class="pull-right">
									<small class="date"><cite>15 seconds ago</cite></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quo, molestiae!</p>
								</blockquote>
							</div>
						</div>
						<!-- // Media item END -->
						
						<!-- Media item -->
						<div class="media">
							<small class="author"><a href="#" title="" class="strong">Ricky</a></small>
							<div class="media-object pull-left"><img src="../assets/images/people/50/1.jpg" alt="Image" class="img-circle" /></div>
							<div class="media-body">
								<blockquote>
									<small class="date"><cite>5 minutes ago</cite></small>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Doloremque, distinctio!</p>
								</blockquote>
							</div>
						</div>
						<!-- // Media item END -->
					</li>
				</ul>
			</div>
			
			<div class="tab-pane active" id="chat-list">
				<div class="mixitup" id="mixitup-chat" data-show-default="mixit-chat-1" data-layout-mode="list" data-target-selector=".mix" data-filter-selector=".filter-chat">
					<ul>
						<li class="category">Groups</li>
						<li class="reset">
							<div class="innerLR">
								<ul>
									<li class="filter-chat" data-filter="mixit-chat-1"><a href="" class="no-ajaxify"><span class="fa fa-fw fa-circle-o text-success"></span> Work Related</a></li>
									<li class="filter-chat" data-filter="mixit-chat-2"><a href="" class="no-ajaxify"><span class="fa fa-fw fa-circle-o text-primary"></span> Very Important</a></li>
									<li class="filter-chat" data-filter="mixit-chat-3"><a href="" class="no-ajaxify"><span class="fa fa-fw fa-circle-o text-info"></span> Friends &amp; Family</a></li>
								</ul>
							</div>
						</li>
						<li class="category border-bottom">Online</li>
						<li>
							
																					<div class="mixit-chat-1 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/1.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Perpetua Inger</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-1 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/2.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Zoticus Axel</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-1 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/3.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Yun Ragna</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-1 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/4.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Victor Tacitus</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-1 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/5.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Arden Catharine</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-2 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/6.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Mihovil Govinda</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-2 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/7.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Mariya Hadya</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-2 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/8.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Tahir Benedikt</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-2 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/9.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Olayinka Kristin</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-2 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/10.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Danko Nikodim</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-3 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/11.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Zoja Aileas</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-3 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/12.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Alphonsus Braidy</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-3 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/13.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Helene Liana</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-3 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/14.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Sebastian Niklas</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class="mixit-chat-3 mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/15.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Elvire Maya</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
																					<div class=" mix media border-bottom innerAll margin-none">
								<a href="#chat-conversation" data-toggle="tab" class="pull-left media-object"><img src="../assets/images/people/35/16.jpg" class="img-circle" /></a>
								<div class="media-body">
									<a href="#chat-conversation" data-toggle="tab" class="pull-right text-muted innerT half">
										<i class="fa fa-comments"></i> 4
									</a>
									<h5 class="margin-none"><a href="#chat-conversation" data-toggle="tab" class="text-white">Kerman Otakar</a></h5>
									<small>Hey, the party is on tonight!</small>
								</div>
							</div>
							
						</li>
					</ul>
				</div>
			</div>
		</div>

	</div>
</div>







		
		<!-- Content START -->
		<div id="content">
			
<div class="navbar hidden-print navbar-default box main" role="navigation">

	<div class="user-action user-action-btn-navbar pull-right border-left">
		<a href="#menu-right" class="btn btn-sm btn-navbar btn-open-right"><i class="fa fa-comments fa-2x"></i></a>
	</div>
	<div class="user-action user-action-btn-navbar pull-left">
		<a href="#menu" class="btn btn-sm btn-navbar btn-open-left"><i class="fa fa-bars fa-2x"></i></a>
	</div>

	<ul class="notifications pull-left hidden-xs">
		<li class="dropdown notif">
			<a href="" class="dropdown-toggle"  data-toggle="dropdown"><i class="notif-block icon-envelope-1"></i><span class="fa fa-star"></span></a>
			<ul class="dropdown-menu chat media-list">
				<li class="media">
			        <a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/15.jpg" alt="50x50" width="50"/></a>
					<div class="media-body">
			        	<span class="label label-default pull-right">5 min</span>
			            <h5 class="media-heading">Adrian D.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
				</li>
		      	<li class="media">
		          	<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/16.jpg" alt="50x50" width="50"/></a>
					<div class="media-body">
			          	<span class="label label-default pull-right">2 days</span>
			            <h5 class="media-heading">Jane B.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
		        </li>
			    <li class="media">
		          	<a class="pull-left" href="#"><img class="media-object thumb" src="../assets/images/people/100/17.jpg" alt="50x50" width="50"/></a>
			      	<div class="media-body">
						<span class="label label-default pull-right">3 days</span>
			            <h5 class="media-heading">Andrew M.</h5>
			            <p class="margin-none">Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
			        </div>
		        </li>
	      	</ul>
		</li>
	</ul>

	<div class="user-action pull-left menu-right-hidden-xs menu-left-hidden-xs border-left">
		<div class="dropdown username pull-left">
			<a class="dropdown-toggle" data-toggle="dropdown" href="#">
				<span class="media margin-none">
					<span class="pull-left"><img src="../assets/images/people/35/16.jpg" alt="user" class="img-circle"></span>
					<span class="media-body">Bill <span class="caret"></span></span>
				</span>
			</a>
			<ul class="dropdown-menu">
				<li><a href="<?php echo getURL(array('page'=>'about_1')); ?>" >About</a></li>
				<li><a href="<?php echo getURL(array('page'=>'messages')); ?>">Messages</a></li>
				<li><a href="<?php echo getURL(array('page'=>'timeline_3')); ?>">Profile</a></li>
				<li><a href="<?php echo getURL(array('page'=>'login')); ?>">Logout</a></li>
		    </ul>
		</div>
	</div>
	<div class="input-group hidden-xs pull-left">
	  	<span class="input-group-addon"><i class="icon-search"></i></span>
	  	<input type="text" class="form-control" placeholder="Search a friend"/>
	</div>
</div>
	


			<!-- <div class="layout-app">  -->
			