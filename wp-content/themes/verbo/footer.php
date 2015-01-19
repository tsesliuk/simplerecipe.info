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
                                 <a title="Простые рецепты (главная страница)" href="http://loc.simplerecipe.info/">Главная</a>, 
                                 <a title="О проекте «Простые рецепты»" href="http://loc.simplerecipe.info/about/">О проекте</a>, 
                                 <a title="Контакты простых рецептов" href="http://loc.simplerecipe.info/contacts/">Контакты</a>
                                 <a title="Простые советы" href="http://loc.simplerecipe.info/simple-advice/"><span class="glyphicon glyphicon-info-sign" aria-hidden="true"></span> Простые советы</a>
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
                            <!-- Rating@Mail.ru logo -->
                            <a target="_blank" href="http://top.mail.ru/jump?from=2500936">
                            <img src="//top-fwz1.mail.ru/counter?id=2500936;t=355;l=1" 
                            border="0" height="18" width="88" alt="Рейтинг@Mail.ru"></a>
                            <!-- //Rating@Mail.ru logo -->

                            <div class="mythemes-social" style="display:none">
                                <?php
                                    if( !empty( $github ) ){
                                        echo '<a href="' . $github . '" class="icon-github" target="_blank"></a>';
                                    }

                                    if( !empty( $vimeo ) ){
                                        echo '<a href="' . $vimeo . '" class="icon-vimeo" target="_blank"></a>';
                                    }

                                    if( !empty( $twitter ) ){
                                        echo '<a href="' . $twitter . '" class="icon-twitter" target="_blank"></a>';
                                    }

                                    if( !empty( $renren ) ){
                                        echo '<a href="' . $renren . '" class="icon-renren" target="_blank"></a>';
                                    }

                                    if( !empty( $skype ) ){
                                        echo '<a href="' . $skype . '" class="icon-skype" target="_blank"></a>';
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
                                        echo '<a href="' . $flickr . '" class="icon-flickr" target="_blank"></a>';
                                    }

                                    if( !empty( $tumblr ) ){
                                        echo '<a href="' . $tumblr . '" class="icon-tumblr" target="_blank"></a>';
                                    }

                                    if( !empty( $instagram ) ){
                                        echo '<a href="' . $instagram . '" class="icon-instagram" target="_blank"></a>';
                                    }

                                    if( !empty( $vkontakte ) ){
                                        echo '<a href="' . $vkontakte . '" class="icon-vkontakte" target="_blank"></a>';
                                    }

                                    if( !empty( $facebook ) ){
                                        echo '<a href="' . $facebook . '" class="icon-facebook" target="_blank"></a>';
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
                                        echo '<a href="' . $gplus . '" class="icon-gplus" target="_blank"></a>';
                                    }

                                    if( !empty( $pinterest ) ){
                                        echo '<a href="' . $pinterest . '" class="icon-pinterest" target="_blank"></a>';
                                    }

                                    if( !empty( $smashing ) ){
                                        echo '<a href="' . $smashing . '" class="icon-smashing" target="_blank"></a>';
                                    }

                                    if( !empty( $rdio ) ){
                                        echo '<a href="' . $rdio . '" class="icon-rdio" target="_blank"></a>';
                                    }

                                   /* echo '<a href="http://ok.ru/group/56850074435628" class="icon-rdio" target="_blank"></a>'; */

                                    if( $rss ){
                                        echo '<a href="'; bloginfo('rss2_url');  echo '" class="icon-rss" target="_blank"></a>';
                                    }
                                ?>
                            </div>
                            <p><?php echo myThemes::get( 'footer-text', true ); ?></p>
                        </div>
                    </div>
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

    </body>
</html>