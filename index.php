<!doctype html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>glumptio.us</title>
<meta name="description" content="">
<meta name="author" content="galumptious" >
<meta name="viewport" content="width=device-width">
<meta property="og:title" content="Glumptious" />
<meta property="og:type" content="company" />
<meta property="og:url" content="http://www.glumptio.us" />
<meta property="og:image" content="http://www.glumptio.us/img/fbsq.png" />
<meta property="og:site_name" content="Glumptious" />
<meta property="fb:admins" content="1267800034" />
<link rel="stylesheet/less" href="less/style.less?v2.1">
<script src="js/libs/less-1.3.0.min.js"></script> 

<!-- Use SimpLESS (Win/Linux/Mac) or LESS.app (Mac) to compile your .less files
	to style.css, and replace the 2 lines above by this one:

	<link rel="stylesheet" href="less/style.css">
	 -->

<script src="js/libs/modernizr-2.5.3-respond-1.1.0.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script> 
<script>window.jQuery || document.write('<script src="js/libs/jquery-1.7.2.min.js"><\/script>')</script> 
</head>
<body>
<?php require('blog/wp-load.php'); ?>
<?php include_once('analytics.php') ?>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!--[if lt IE 7]><p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p><![endif]-->


<div class="container">
<h1 class="glumptious">GLUMPTIOUS</h1>
<div class="tabbable">
  <ul class="nav nav-tabs"><div class="nav-tabs-bg"></div>
    <li id="nav1" class="active"><a href="#home" data-toggle="tab" border="0">home</a></li>
    <li id="nav2"><a href="#about" data-toggle="tab" border="0">about</a></li>
    <li id="nav3"><a href="#work" data-toggle="tab" border="0">work</a></li>
    <li id="nav4"><a class="opposite" href="#blog" data-toggle="tab" border="0">blog</a></li>
    <li id="nav5"><a class="opposite" href="mailto:zach@glumptio.us" border="0">mailio</a></li>
    <li id="nav6"><a class="opposite" href="#socio" data-toggle="tab" border="0">socio</a></li>
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade active in" id="home">
			<?php include_once('home.php') ?>
    </div>
    <div class="tab-pane fade" id="about">
      <?php include_once('about.php') ?>
    </div>
    <div class="tab-pane fade" id="work">
			<?php include_once('work.php') ?>
    </div>
    <div class="tab-pane fade" id="blog">
    	<div class="hero-unit"><span class="w_background"></span>
				<?php
          $posts = get_posts('numberposts=3');
          foreach ($posts as $post) : start_wp(); ?>
          <section style="padding: 0 20px;">
          <h2 class="hero-head slideHook slide"><?php the_title(); echo "<br>" ?></h2>
          <h4 class="tLine"><?php the_date(); ?></h4>
          <span class="tLine" style="text-align:left;"><?php the_content(); ?></span>
          </section>
        <?php
          endforeach;
        ?>
      </div>
			<img class="bg" src="img/bg1.gif">
    </div>
    <div class="tab-pane fade" id="socio">
			<?php include_once('socio.php') ?>
    </div>
  </div>
</div>
</div>
<!-- /container --> 
<script src="js/libs/bootstrap/bootstrap.min.js"></script> 
<script src="js/script.js"></script> 
<script src="js/bootstrap-datepicker.js"></script> 
<script src="js/bootstrap-tabs.js"></script>
</body>
</html>
