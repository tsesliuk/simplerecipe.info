<?php
/*
    Plugin Name: Simple Post Ratings
    Description: A simple way to add ratings to your WordPress posts.
    Version: 1.0.1
    Author: Eriks Briedis
    Author URI: http://eriks.designschemers.com
    License: GPL2


    Copyright 2013  Eriks Briedis  (email : eriks.briedis@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/
?>
<?php

  class PostRatings {
    public $plugin_name;
    public $upload_dir;
    public $ds_meta;
    public $post_id;
    public $options;

    public function __construct(){
      $this->plugin_name = basename(dirname(__FILE__)).'/'.basename(__FILE__);
      $this->upload_dir =  ABSPATH . 'wp-content/plugins/simple-post-ratings/';
      register_activation_hook( __FILE__, array( $this, 'ds_activate_plugin' ) );
      register_uninstall_hook(__FILE__, array(__CLASS__, 'ds_uninstall_plugin'));
      $this->post_id = null;
      $this->ds_meta = get_post_meta($this->post_id, 'ds_post_rating');
      add_action( 'add_meta_boxes', array( $this, 'ds_add_meta_box' ) );
      add_action('save_post', array($this, 'ds_save_rating'));
      add_action('the_content', array($this, 'ds_rating_display'));
      add_action('admin_menu', array($this, 'ds_rating_options'));
      $this->options = get_option('ds_rating_options');
    }

    public function ds_add_meta_box(){
      add_meta_box(
        'myplugin_sectionid',
            __( 'Post Rating' ),
            array( $this, 'ds_add_rating_content' ),
            'post',
            'side',
            'high'
        );
    }

    public function ds_add_rating_content($post, $post_id) {
      $max_rating = $this->options['max_score'];
        if ($this->is_edit_page('new')){

        }else{
          $this->post_id = $_GET['post'];
          $this->ds_meta = get_post_meta($this->post_id, 'ds_post_rating');
          print_r($post_id['post_id']);
        }
        ?>
          <label for='ds_post_rating'>Rating: </label>
          <select name='ds_post_rating'>
            <option value=''>-</option>
            <?php
              for ($i=1; $i <= $max_rating; $i++) {
                if($i == $this->ds_meta['0']){
                  echo "<option value='" . $i . "' selected>" . $i . "</option>";
                }else{
                  echo "<option value='" . $i . "'>" . $i . "</option>";
                }
              }
            ?>
          </select>
      <?php
      }

      public function ds_rating_options(){
        add_options_page('Simple Post Ratings Options', 'Simple Post Ratings Options', 'manage_options', 'ratings_options', array($this, 'settings_page'));
      }

      public function settings_page(){
        require_once('simple-post-ratings-options.php');
      }

      public function ds_save_rating($post_id){
        if(defined('DOING_AUTOSAVE') && DOING_AUTOSAVE){
          return;
        }else{
          if(!current_user_can('edit_post', $post_id)){
            return;
          }
        }
        $myrating = $_POST['ds_post_rating'];
        update_post_meta($post_id, 'ds_post_rating', $myrating);
      }

      public function ds_rating_display($content){
        $id = get_the_ID();
        $ds_meta_val = get_post_meta($id, 'ds_post_rating');
        $ds_cur_rating = $ds_meta_val['0'];
        if($ds_cur_rating > $this->options['max_score']){
          $ds_cur_rating = $this->options['max_score'];
        }
        if($ds_cur_rating){
          ?>
          <style>
            .ds_rating_wrap {
              text-align: <?php echo $this->options['align']; ?>;
              margin-bottom: 10px;
            }
            .ds_rating_wrap p {
              display: inline-block;

            }
            .rating_numbers {
              <?php if($this->options['rating_numbers'] == 'on'){
                echo "display: inline-block !important;";
                }else{
                  echo "display: none !important;";
                  } ?>
            }

            .ds_rating_img img {
              vertical-align: middle;
              margin-top: -8px;
              margin: -10px 2px 0px;
              padding: 0;
              max-width: 5.5%;
            }
          </style>

          <?php if($this->options['position'] == 'bottom'  ) { echo $content; } ?>
          <div class="ds_rating_wrap">
            <p><?php echo $this->options['before_rating']; ?></p>
            <span class="ds_rating_img">
              <?php for ($i=0; $i < $ds_cur_rating; $i++) {
                echo '<img src="' . plugins_url() . '/simple-post-ratings/' . $this->options['custom_img_slug'] . '" width="24" height="24" />';
              } ?>
            </span>
            <p class="rating_numbers" ><?php echo $ds_cur_rating . '/' . $this->options['max_score']; ?></p>
            <p><?php echo $this->options['after_rating']; ?></p>
          </div>

          <?php if($this->options['position'] == 'top' ) { echo $content; }
        }else{
          return $content;
        }
      }

      public function is_edit_page($new_edit = null){
        global $pagenow;
        //make sure we are on the backend
        if (!is_admin()){
          return false;
        }
        if($new_edit == "edit"){
          return in_array( $pagenow, array( 'post.php',  ) );
        }elseif($new_edit == "new"){
           return in_array( $pagenow, array( 'post-new.php' ) );
        }else{
          return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
        }
      }

      public function get_extension($file_name){
        $ext = explode('.', $file_name);
        $ext = array_pop($ext);
        return strtolower($ext);
      }

      public function ds_clean_string($string){
        $string = strip_tags($string);
        return $string;
      }

      public function ds_uninstall_plugin(){
        global $wpdb;
        $wpdb->query("DELETE FROM wp_postmeta WHERE meta_key = 'ds_post_rating'");
        delete_option('ds_rating_options');
      }

      public function ds_activate_plugin(){
        add_option('ds_rating_options', array(
            'max_score' => 10,
            'before_rating' => 'My rating',
            'after_rating' => '',
            'custom_img_slug' => 'ds_star.png',
            'align' => 'left',
            'rating_numbers' => 'on',
            'position' => 'top'
          ));
      }
  }


  $postRatings = new PostRatings(); //plugin activation

?>
