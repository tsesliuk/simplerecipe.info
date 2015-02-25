<?php
if( comments_open() ){
    if( is_user_logged_in() ){
        echo '<div id="comments" class="comments-list user-logged-in">';
    }
    else{
        echo '<div id="comments" class="comments-list">';
    }

    if ( post_password_required() ){
        echo '<p class="nopassword">';
        _e( 'This post is password protected. Enter the password to view any comments.' , 'myThemes' );
        echo '</p>';
        echo '</div>';
        return;
    }

    /* IF EXISTS WORDPRESS COMMENTS */
    if ( have_comments() ) {
        $nr = get_comments_number();
        
        if( $nr == 1 )
            $title = __( 'Комментарий' , 'myThemes' );
        else
            $title = __( 'Комментарии' , 'myThemes' );

        echo '<h3 class="comments-title">';
        echo $title . ' ( <strong>' . number_format_i18n( $nr ) . '</strong> )'; 
        echo '</h3>';
		
        echo '<ol>';
        wp_list_comments( array( 'callback' =>  array( 'myThemes' , 'comment' ) , 'style' => 'ul' ) );
        echo '</ol>';
        
        /* WORDPRESS PAGINATION FOR COMMENTS */
        echo '<div class="pagination comments">';
        echo '<nav class="inline aligncenter">';
        echo paginate_comments_links();
        echo '</nav>';
        echo '</div>';
    }
	
    /* FORM SUBMIT COMMENTS */
    $commenter = wp_get_current_commenter();

    /* CHECK VALUES */
    if( esc_attr( $commenter[ 'comment_author' ] ) )
        $name = esc_attr( $commenter[ 'comment_author' ] );
    else
        $name = __( 'Nickname ( required )' , 'myThemes' );

    if( esc_attr( $commenter[ 'comment_author_email' ] ) )
        $email = esc_attr( $commenter[ 'comment_author_email' ] );
    else
        $email = __( 'E-mail ( required )' , 'myThemes' );

    if( esc_attr( $commenter[ 'comment_author_url' ] ) )
        $web = esc_attr( $commenter[ 'comment_author_url' ] );
    else
        $web = __( 'Website' , 'myThemes' );

    /* FIELDS */
    $fields =  array(
        'author' => '<div class="field">'.
                '<p class="comment-form-author input">'.
                '<input class="required span7" value="' . $name . '" onfocus="if (this.value == \'' . __( 'Nickname ( required )' , 'myThemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'Nickname ( required )' , 'myThemes' ) . '\';}" id="author" name="author" type="text" size="30"  />' .
            '</p>',
        'email'  => '<p class="comment-form-email input">'.
                '<input class="required span7" value="' . $email . '" onfocus="if (this.value == \'' . __( 'E-mail ( required )' , 'myThemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'E-mail ( required )' , 'myThemes' ) . '\';}" id="email" name="email" type="text" size="30" />' .
            '</p>',
        'url'    => '<p class="comment-form-url input">'.
                '<input class="span7" value="' . $web . '" onfocus="if (this.value == \'' . __( 'Website' , 'myThemes' ). '\') {this.value = \'\';}" onblur="if (this.value == \'\' ) { this.value = \'' . __( 'Website' , 'myThemes' ). '\';}" id="url" name="url" type="text" size="30" />' .
            '</p></div>',
    );
    

    $rett  = '<div itemprop="interactionCount" class="textarea row-fluid"><p class="comment-form-comment textarea user-not-logged-in">';
    $rett .= '<textarea id="comment" name="comment" cols="45" rows="10" class="span12" aria-required="true">Оставьте пожалуйста свой комментарий чтобы другие посетители знали что это за рецептик.</textarea>';
    $rett .= '</p></div>';
    
    if( !myThemes::get( 'html-suggestions' ) ){
        $rett .= '<p class="comment-notes">' . __( 'Вы можете использовать эти HTML теги и атрибуты' , 'myThemes' ) . ':</p>';
        $rett .= '<pre>';
        $rett .= htmlspecialchars( '<a href="" title=""> <abbr title=""> <acronym title=""> <b> <blockquote cite=""> <cite> <code> <del datetime=""> <em> <i> <q cite=""> <strike> <strong>' );
        $rett .= '</pre>';
    }

    $args = array(	
        'title_reply' => __( "Оставьте пожалуйста <strong>простой отзыв</strong>" , 'myThemes' ),
        'comment_notes_after'   => '',
        'comment_notes_before'  => '<button type="submit" class="submit-comment">' . __( 'Опубликовать' , 'myThemes' ) . '</button><p class="comment-notes">' . __( 'Ваш email не будет опубликован.' , 'myThemes' ) . '</p>',
        'logged_in_as'          => '<button type="submit" class="submit-comment">' . __( 'Опубликовать' , 'myThemes' ) . '</button><p class="logged-in-as">' . __( 'Залогинен как' , 'myThemes' ) . ' <a href="' . home_url('/wp-admin/profile.php') . '">' . get_the_author_meta( 'nickname' , get_current_user_id() ) . '</a>. <a href="' . wp_logout_url( get_permalink( $post -> ID ) ) .'" title="' . __( 'Выйти из этого аккаунта' , 'myThemes' ) . '">' . __( 'Выйти?' , 'myThemes' ) . ' </a></p>',		
        'fields'                => apply_filters( 'comment_form_default_fields', $fields ),
        'comment_field'         => $rett,
        'label_submit'          => __( 'Опубликовать' , 'myThemes' )
    );

    comment_form( $args );
    echo '<div class="clearfix"></div>';
    echo '</div>';
}
?>