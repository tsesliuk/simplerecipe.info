        <footer>
            <?php
                ob_start();
                get_sidebar( 'footer-first' );
                $first = ob_get_clean();

                ob_start();
                get_sidebar( 'footer-second' );
                $second = ob_get_clean();

             

                $sidebar_content = $first . $second;
                

                if( !empty( $sidebar_content ) ){
            ?>
                    <aside>
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <?php echo $first; ?>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                    <?php echo $second; ?>
                                </div>
                            </div>
                        </div>
                    </aside>
            <?php
                }
            ?>

            <div class="mythemes-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-6 col-lg-6">
                           <div class="footer-menu">
                                 <a title="Простые рецепты (главная страница)" href="/">Главная</a>, 
                                 <a title="О проекте «Простые рецепты»" href="/about/">О проекте</a>, 
                                 <a title="Контакты простых рецептов" href="/contacts/">Контакты</a>
                                 <a title="Простые советы" href="/simple-advice/"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Простые советы</a>
                                </ul>
                            </div> 
                        </div>
                        <?php
                            $github     = myThemes::get( 'github' );
                            $vimeo      = myThemes::get( 'vimeo' );
                            $twitter    = myThemes::get( 'twitter' );
                            $renren     = myThemes::get( 'renren' );
                            $skype      = myThemes::get( 'skype' );
                            $linkedin   = myThemes::get( 'linkedin' );
                            $behance    = myThemes::get( 'behance' );
                            $dropbox    = myThemes::get( 'dropbox' );
                            $flickr     = myThemes::get( 'flickr' );
                            $tumblr     = myThemes::get( 'tumblr' );
                            $instagram  = myThemes::get( 'instagram' );
                            $vkontakte  = myThemes::get( 'vkontakte' );
                            $facebook   = myThemes::get( 'facebook' );
                            $evernote   = myThemes::get( 'evernote' );
                            $flattr     = myThemes::get( 'flattr' );
                            $picasa     = myThemes::get( 'picasa' );
                            $dribbble   = myThemes::get( 'dribbble' );
                            $soundcloud = myThemes::get( 'soundcloud' );
                            $mixi       = myThemes::get( 'mixi' );
                            $stumbl     = myThemes::get( 'stumbl' );
                            $lastfm     = myThemes::get( 'lastfm' );
                            $gplus      = myThemes::get( 'gplus' );
                            $pinterest  = myThemes::get( 'pinterest' );
                            $smashing   = myThemes::get( 'smashing' );
                            $rdio       = myThemes::get( 'rdio' );
                            $rss        = myThemes::get( 'rss' );
                        ?>
                        <div class="col-sm-6 col-md-6 col-lg-6">
                            
                            <span class="counters pull-right">
                                <!-- Rating@Mail.ru counter -->
                                <script type="text/javascript">
                                var _tmr = _tmr || [];
                                _tmr.push({id: "2500936",  type: "pageView", start: (new Date()).getTime()});
                                (function (d, w) {
                                   var ts = d.createElement("script"); ts.type = "text/javascript"; ts.async = true;
                                   ts.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//top-fwz1.mail.ru/js/code.js";
                                   var f = function () {var s = d.getElementsByTagName("script")[0]; s.parentNode.insertBefore(ts, s);};
                                   if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); }
                                })(document, window);
                                </script><noscript><div style="position:absolute;left:-10000px;">
                                <img src="//top-fwz1.mail.ru/counter?id=2500936;js=na" style="border:0;" height="1" width="1" alt="Рейтинг@Mail.ru" />
                                </div></noscript>
                                <!-- //Rating@Mail.ru counter -->

                                <!-- Rating@Mail.ru logo -->
                                <a class="" target="_blank" href="http://top.mail.ru/jump?from=2500936">
                                <img src="//top-fwz1.mail.ru/counter?id=2500936;t=355;l=1" 
                                border="0" height="18" width="88" alt="Рейтинг@Mail.ru"></a>
                                <!-- //Rating@Mail.ru logo -->

                                <!-- Yandex.Metrika informer -->
                                <a href="https://metrika.yandex.ua/stat/?id=23821627&amp;from=informer"
                                target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/23821627/1_1_FFFFECFF_FFFFCCFF_0_pageviews"
                                style="width:80px; height:15px; border:0;" alt="Яндекс.Метрика" title="Яндекс.Метрика: данные за сегодня (просмотры)" onclick="try{Ya.Metrika.informer({i:this,id:23821627,lang:'ru'});return false}catch(e){}" /></a>
                                <!-- /Yandex.Metrika informer -->

                                <!-- Yandex.Metrika counter -->
                                <script type="text/javascript">
                                    (function (d, w, c) {
                                        (w[c] = w[c] || []).push(function() {
                                            try {
                                                w.yaCounter23821627 = new Ya.Metrika({
                                                    id:23821627
                                                });
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

                                <!-- begin of Top100 code 
                                <script id="top100Counter" type="text/javascript" src="http://counter.rambler.ru/top100.jcn?3082375"></script>
                                <noscript>
                                <a href="http://top100.rambler.ru/navi/3082375/">
                                <img src="http://counter.rambler.ru/top100.cnt?3082375" alt="Rambler's Top100" border="0" />
                                </a>

                                </noscript>
                                 end of Top100 code -->
                            </span>
                            <div class="mythemes-social">
                                <a href="https://www.youtube.com/channel/UCT2CiftLOwGMaow-SE5e4iw/feed" class="fa fa-youtube" target="_blank"></a>
                                <?php
                                    if( !empty( $github ) ){
                                        echo '<a href="' . $github . '" class="fa fa-github-alt" target="_blank"></a>';
                                    }

                                    if( !empty( $vimeo ) ){
                                        echo '<a href="' . $vimeo . '" class="fa fa-vimeo-square" target="_blank"></a>';
                                    }

                                    if( !empty( $twitter ) ){
                                        echo '<a href="' . $twitter . '" class="fa fa-twitter" target="_blank"></a>';
                                    }

                                    if( !empty( $renren ) ){
                                        echo '<a href="' . $renren . '" class="fa fa-renren" target="_blank"></a>';
                                    }

                                    if( !empty( $skype ) ){
                                        echo '<a href="' . $skype . '" class="fa fa-skype" target="_blank"></a>';
                                    }

                                    if( !empty( $linkedin ) ){
                                        echo '<a href="' . $linkedin . '" class="icon-linkedin" target="_blank"></a>';
                                    }

                                    if( !empty( $behance ) ){
                                        echo '<a href="' . $behance . '" class="icon-behance" target="_blank"></a>';
                                    }

                                    if( !empty( $dropbox ) ){
                                        echo '<a href="' . $dropbox . '" class="icon-dropbox" target="_blank"></a>';
                                    }

                                    if( !empty( $flickr ) ){
                                        echo '<a href="' . $flickr . '" class="fa fa-flickr" target="_blank"></a>';
                                    }

                                    if( !empty( $tumblr ) ){
                                        echo '<a href="' . $tumblr . '" class="fa fa-tumblr" target="_blank"></a>';
                                    }

                                    if( !empty( $instagram ) ){
                                        echo '<a href="' . $instagram . '" class="fa fa-instagram" target="_blank"></a>';
                                    }

                                    if( !empty( $vkontakte ) ){
                                        echo '<a href="' . $vkontakte . '" class="fa fa-vk" target="_blank" title="Простой рецепт в ВК"></a>';
                                    }

                                    if( !empty( $facebook ) ){
                                        echo '<a href="' . $facebook . '" class="fa fa-facebook" target="_blank"  title="Простой рецепт в Facebook"></a>';
                                    }

                                    if( !empty( $evernote ) ){
                                        echo '<a href="' . $evernote . '" class="icon-evernote" target="_blank"></a>';
                                    }

                                    if( !empty( $flattr ) ){
                                        echo '<a href="' . $flattr . '" class="icon-flattr" target="_blank"></a>';
                                    }

                                    if( !empty( $picasa ) ){
                                        echo '<a href="' . $picasa . '" class="icon-picasa" target="_blank"></a>';
                                    }

                                    if( !empty( $dribbble ) ){
                                        echo '<a href="' . $dribbble . '" class="icon-dribbble" target="_blank"></a>';
                                    }

                                    if( !empty( $soundcloud ) ){
                                        echo '<a href="' . $soundcloud . '" class="icon-soundcloud" target="_blank"></a>';
                                    }

                                    if( !empty( $mixi ) ){
                                        echo '<a href="' . $mixi . '" class="icon-mixi" target="_blank"></a>';
                                    }

                                    if( !empty( $stumbl ) ){
                                        echo '<a href="' . $stumbl . '" class="icon-stumbl" target="_blank"></a>';
                                    }

                                    if( !empty( $lastfm ) ){
                                        echo '<a href="' . $lastfm . '" class="icon-lastfm" target="_blank"></a>';
                                    }

                                    if( !empty( $gplus ) ){
                                        echo '<a href="' . $gplus . '" class="fa fa-google" target="_blank" title="Простой рецепт в Google Plus"></a>';
                                    }

                                    if( !empty( $pinterest ) ){
                                        echo '<a href="' . $pinterest . '" class="fa fa-pinterest" target="_blank" title="Простой рецепт в Pinterest"></a>';
                                    }

                                    if( !empty( $smashing ) ){
                                        echo '<a href="' . $smashing . '" class="icon-smashing" target="_blank"></a>';
                                    }

                                    if( !empty( $rdio ) ){
                                        echo '<a href="' . $rdio . '" class="icon-rdio" target="_blank"></a>';
                                    }

                                   /* echo '<a href="http://ok.ru/group/56850074435628" class="icon-rdio" target="_blank"></a>'; */

                                    if( $rss ){
                                        echo '<a href="'; bloginfo('rss2_url');  echo '" class="fa fa-rss" target="_blank"></a>';
                                    }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    <p><?php echo myThemes::get( 'footer-text', true ); ?></p>
                </div>
            </div>
        </footer>

        <?php wp_footer(); ?>

        <div id="fb-root"></div>
        <script>(function(d, s, id) {
          var js, fjs = d.getElementsByTagName(s)[0];
          if (d.getElementById(id)) return;
          js = d.createElement(s); js.id = id;
          js.src = "//connect.facebook.net/uk_UA/sdk.js#xfbml=1&appId=499754933484016&version=v2.0";
          fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
        </script>
        
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-46038822-1', 'auto');
          ga('send', 'pageview');

        </script>

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    </body>
</html>