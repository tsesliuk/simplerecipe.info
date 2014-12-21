<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?><!DOCTYPE html>
<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->


<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<meta name="author" content="Простые рецепты">
	<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/images/favicon.ico" type="image/x-icon">
	<link rel="apple-touch-icon-precomposed" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon.png">
	<link rel="apple-touch-icon-precomposed" sizes="57x57" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-57x57.png">
	<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-72x72.png">
	<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-114x114.png">
	<link rel="apple-touch-icon-precomposed" sizes="144x144" href="<?php bloginfo('template_directory'); ?>/images/apple-touch-icon-144x144.png">

	<meta name='yandex-verification' content='5f7cff174242ee1b'>

	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<!-- ������� -->
<link href="<?php bloginfo('template_directory'); ?>/css/tabs.css?115" type=css" rel="stylesheet">

<script src="<?php bloginfo('template_directory'); ?>/js/jquery-1.6.3.min.js"></script>
    <script src="<?php bloginfo('template_directory'); ?>/js/easyResponsiveTabs.js" type="text/javascript"></script>

	<script type="text/javascript">
    $(document).ready(function () {
        $('#horizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion           
            width: 'auto', //auto or any width like 600px
            fit: true,   // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#tabInfo');
                var $name = $('span', $info);

                $name.text($tab.text());

                $info.show();
            }
        });

        
    });
</script>
	
	<!-- vkontakte Put this script tag to the <head> of your page -->
	<script type="text/javascript" src="http://vk.com/js/api/openapi.js?115"></script>
<script type="text/javascript">
  VK.init({apiId: 4561234, onlyWidgets: true});
</script>


<!-- OK -->
<link href="http://www.odnoklassniki.ru/oauth/resources.do?type=css" rel="stylesheet">
<script src="http://www.odnoklassniki.ru/oauth/resources.do?type=js" type="text/javascript" charset="utf-8">
</script>
<!-- ������� -->
	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?>

	<meta name="google-site-verification" content="-H4VSGpUuaTyKwCNizA9hi8QswHGB7VysfL-IBdtsOk" />
	<link rel="author" href="https://plus.google.com/112212032082298665751">

<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"YBqgj1a8Dy00yS", domain:"prostoyrecept.info",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=YBqgj1a8Dy00yS" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript -->

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-46038822-1', 'auto');
  ga('send', 'pageview');

</script>

</head>

<body <?php body_class(); ?>>
<!-- Start Alexa Certify Javascript -->
<script type="text/javascript">
_atrk_opts = { atrk_acct:"BF3hj1aAkN00Wk", domain:"prostoyrecept.info",dynamic: true};
(function() { var as = document.createElement('script'); as.type = 'text/javascript'; as.async = true; as.src = "https://d31qbv1cthcecs.cloudfront.net/atrk.js"; var s = document.getElementsByTagName('script')[0];s.parentNode.insertBefore(as, s); })();
</script>
<noscript><img src="https://d5nxst8fruw4z.cloudfront.net/atrk.gif?account=BF3hj1aAkN00Wk" style="display:none" height="1" width="1" alt="" /></noscript>
<!-- End Alexa Certify Javascript --> 

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&appId=499754933484016&version=v2.0";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

	<div id="top_href"></div>
	<div id="page" class="hfeed site">
		<?php if ( !is_front_page() ) : ?>

			<header id="masthead" class="site-header" role="banner">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">	
					<img src="<?php bloginfo('template_directory'); ?>/images/simple_cooking.png" alt="<?php bloginfo( 'name' ); ?>">
					<div class="site-title"><?php bloginfo( 'name' ); ?></div>
				</a>

					<nav id="site-navigation" class="navigation main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
						<span class="clear"></span>
					</nav><!-- #site-navigation -->

					<?php do_action('wp_menubar','categories'); ?>

			</header><!-- #masthead -->

			<!-- for single posts only -->
				<div class="advertise_holder_head">

					<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
					<!-- Prostoyrecept (0ResponsiveBannerRight) -->
					<ins class="adsbygoogle"
					     style="display:block"
					     data-ad-client="ca-pub-3923388382694018"
					     data-ad-slot="6546321280"
					     data-ad-format="auto"></ins>
					<script>
					(adsbygoogle = window.adsbygoogle || []).push({});
					</script>

				</div>

		<?php else : ?>

			<header id="masthead" class="site-header" role="banner">
				<a class="home-link" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">	
					<img src="<?php bloginfo('template_directory'); ?>/images/simple_cooking.png" alt="<?php bloginfo( 'name' ); ?>">
					<h1 class="site-title"><?php bloginfo( 'name' ); ?></h1>
				</a>

					<nav id="site-navigation" class="navigation main-navigation" role="navigation">
						<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
						<span class="clear"></span>
					</nav><!-- #site-navigation -->

					<?php do_action('wp_menubar','categories'); ?>
					
			</header><!-- #masthead -->	

		<?php endif; // is_single() ?>
		<span class="to_top"><a href="#top_href" title="К началу страницы" class="scrolingTo"><span class="icons_sprite chevron-up white"></span></a></span>
		<?php //get_search_form(); ?>
		<div id="main" class="site-main">
			<div class="site-grid row">
