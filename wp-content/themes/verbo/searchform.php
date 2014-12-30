<form action="<?php echo esc_url( home_url("/") ); ?>" method="get" id="searchform">
    <fieldset>
        <div id="searchbox">
            <input type="text" name="s"  id="keywords" value="<?php _e( 'Что искать?' , 'myThemes' ); ?>" onfocus="if (this.value == '<?php _e( 'Что искать?' , 'myThemes' ); ?>') {this.value = '';}" onblur="if (this.value == '') {this.value = '<?php _e( 'type here...' , 'myThemes' ); ?>';}">
            <button type="submit">Искать</button>
        </div>
    </fieldset>
</form>