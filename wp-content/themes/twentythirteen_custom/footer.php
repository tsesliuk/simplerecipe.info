<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Thirteen
 * @since Twenty Thirteen 1.0
 */
?>
			</div>
		</div><!-- #main -->
		<footer class="site-footer" role="contentinfo">
			<div class="frame row">
				<div class="col-xs-12 col-md-6 tl">
					<?php get_sidebar( 'main' ); ?>
				</div>
				
				<div class="col-xs-12 col-md-6 site-info tr">
					<a href="https://plus.google.com/112212032082298665751" rel="publisher">Google+</a>
					<!--
					Простые рецепты созданы <a href="simplestudio.com" title="Просто студия, это простой и качественный дизайн">Просто</a> студией.
					-->
				</div>

				<div class="clear"></div>
			</div>
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>

	<!-- Yandex.Metrika counter -->
	<script type="text/javascript">
	(function (d, w, c) {
	    (w[c] = w[c] || []).push(function() {
	        try {
	            w.yaCounter23821627 = new Ya.Metrika({id:23821627,
	                    webvisor:true,
	                    clickmap:true,
	                    trackLinks:true,
	                    accurateTrackBounce:true});
	        } catch(e) { }
	    });

	    var n = d.getElementsByTagName("script")[0],
	        s = d.createElement("script"),
	        f = function () { n.parentNode.insertBefore(s, n); };
	    s.type = "text/javascript";
	    s.async = true;
	    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

	    if (w.opera == "[object Opera]") {
	        d.addEventListener("DOMContentLoaded", f, false);
	    } else { f(); }
	})(document, window, "yandex_metrika_callbacks");
	</script>
	<noscript><div><img src="//mc.yandex.ru/watch/23821627" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->

</body>
</html>