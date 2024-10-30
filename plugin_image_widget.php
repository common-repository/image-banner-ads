<?php
/**
* Plugin Name: [Enqtran] Image Banner Ads
* Plugin URI: http://enqtran.com/
* Description: Image Banner Ads Widget for WP and more
* Author: enqtran
* Version: 1.0
* Author URI: http://enqtran.com/
* Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=EU3YV2GB9434U
* License: GPLv3 or later
* License URI: http://www.gnu.org/licenses/gpl-3.0.html
* Tags: enqtran, enq, enqpro, image, ads, banner, widget
*/

/*
* Plugin Image Banner Ads
* Last update: 24/11/2015
*/
add_action( 'widgets_init', 'banner_enqtran_widget' );
if ( !function_exists('banner_enqtran_widget') ) {
	function banner_enqtran_widget() {
		register_widget('Enqtran_Images_Banner_Widget');
	}
}
class Enqtran_Images_Banner_Widget extends WP_Widget {

/**
 * config widget
 */
function __construct() {
	$widget_ops = array(
            'banner_widget', // id
			'description'=>'[Enqtran] Image Banner Ads'
        );
	 parent::__construct( '', '[Enqtran] Image Banner Ads', $widget_ops );
	add_action( 'admin_enqueue_scripts', array($this, 'upload_scripts') );
}

/**
* Upload the Javascripts for the media uploader
*/
public function upload_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_script('upload_media_widget', plugin_dir_url(__FILE__) . 'upload-media.js', array('jquery'));
    wp_enqueue_style('thickbox');
}

/**
 * [form admin]
 */
function form( $instance ){
	$defaults = array(
		'title' => '',
		'image' => '',
		'image_title' => '',
		'width_image' => '',
		'height_image' => '',
		'id_image' => '',
		'class_image' => '',
		'notifications' => '',
		'content_alert' => '',
		'url' => '',
		'image_caption'=>'',
		'open_new_tab' => 'off'
		);
	$instance = wp_parse_args( $instance, $defaults );
	$title = esc_attr($instance['title']);
	$image_link = esc_attr($instance['image']);
	$image_title = esc_attr($instance['image_title']);
	$width_image = esc_attr($instance['width_image']);
	$height_image = esc_attr($instance['height_image']);
	$id_image = esc_attr($instance['id_image']);
	$class_image = esc_attr($instance['class_image']);
	$notifications = esc_attr($instance['notifications']);
	$content_alert = esc_attr($instance['content_alert']);
	$url = esc_attr($instance['url']);
	$image_caption = esc_attr($instance['image_caption']);
	$open_new_tab = esc_attr($instance['open_new_tab']);
?>
<script>
	jQuery(document).ready(function($) {
	    $(document).on("click", ".upload_image_button", function() {
	        jQuery.data(document.body, 'prevElement', $(this).prev());
	        window.send_to_editor = function(html) {
	            var imgurl = jQuery('img',html).attr('src');
	            var inputText = jQuery.data(document.body, 'prevElement');
	            if(inputText != undefined && inputText != '')
	            {
	                inputText.val(imgurl);
	            }
	            tb_remove();
	        };
	        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
	        return false;
	    });
	});
</script>
<!-- show form admin -->

<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'title' ); ?>"><?php _e( 'Title' ); ?></label>
	</p>
	<p>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" placeholder="Title for Widget" />
	</p>
</div>
<div class="box-w">
	<p>
		<?php
		 	$image = '';
	        if(isset($instance['image']))
	        {
	            $image = $instance['image'];
	        }
	    ?>
		 <label for="<?php echo $this->get_field_name( 'image' ); ?>"><?php _e( 'Image *' ); ?></label>
	</p>
	<p>
		<input name="<?php echo $this->get_field_name( 'image' ); ?>" id="<?php echo $this->get_field_id( 'image' ); ?>" class="widefat" type="text" size="36"  value="<?php echo esc_url( $image ); ?>" require placeholder="Link Image or Upload form media library" />
            <input class="upload_image_button button button-primary widefat" type="button" value="Upload Image" style="margin-top:10px;" />
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'image_title' ); ?>"><?php _e( 'Image title' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('image_title'); ?>" value="<?php echo $image_title; ?>" placeholder="Title Image Hover">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'width_image' ); ?>"><?php _e( 'Image width' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('width_image'); ?>" value="<?php echo $width_image; ?>" placeholder="Width Image">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'height_image' ); ?>"><?php _e( 'Image height' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('height_image'); ?>" value="<?php echo $height_image; ?>" placeholder="Height Image">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'id_image' ); ?>"><?php _e( 'Image id' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('id_image'); ?>" value="<?php echo $id_image; ?>" placeholder="Id Image">
	</p>
</div>

<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'class_image' ); ?>"><?php _e( 'Image class' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('class_image'); ?>" value="<?php echo $class_image; ?>" placeholder="Class Image">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'notifications' ); ?>"><?php _e( 'Notifications Popup' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('notifications'); ?>" value="<?php echo $notifications; ?>" placeholder="Notifications Popup">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'content_alert' ); ?>"><?php _e( 'Content Popup' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('content_alert'); ?>" value="<?php echo $content_alert; ?>" placeholder="Coupons code or more ...">
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'url' ); ?>"><?php _e( 'Link Target *' ); ?></label>
	</p>
	<p>
		<input type="text" class="widefat" name="<?php echo $this->get_field_name('url'); ?>" value="<?php echo $url; ?>" placeholder="Open link after click Image" require>
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'open_new_tab' ); ?>"><?php _e( 'Open New Window or Tab  ' ); ?></label>
		<input type="checkbox" name="<?php echo $this->get_field_name('open_new_tab'); ?>" <?php checked($instance['open_new_tab'], 'on');?> />
	</p>
</div>
<div class="box-w">
	<p>
		<label for="<?php echo $this->get_field_name( 'image_caption' ); ?>"><?php _e( 'Image Caption' ); ?></label>
	</p>
	<p>
		<textarea class="widefat" name="<?php echo $this->get_field_name('image_caption'); ?>" placeholder="Caption Image"><?php echo $image_caption; ?></textarea>
	</p>
</div>
<div class="box-w">
	<p>Default don't show</p>
</div>

<style>
	div#TB_title {
    	height: 0px;
	}
	.image_table_enqtran{
		margin:15px auto;
	}
</style>
<?php
}

/*
* [update]
*/
function update( $new_instance, $old_instance ) {
	$instance = $old_instance;
	$instance['title'] = esc_attr($new_instance['title']);
	$instance['image'] = esc_attr($new_instance['image']);
	$instance['image_title'] = esc_attr($new_instance['image_title']);
	$instance['width_image'] = esc_attr($new_instance['width_image']);
	$instance['height_image'] = esc_attr($new_instance['height_image']);
	$instance['id_image'] = esc_attr($new_instance['id_image']);
	$instance['class_image'] = esc_attr($new_instance['class_image']);
	$instance['notifications'] = esc_attr($new_instance['notifications']);
	$instance['content_alert'] = esc_attr($new_instance['content_alert']);
	$instance['url'] = esc_attr($new_instance['url']);
	$instance['image_caption'] = esc_attr($new_instance['image_caption']);
	$instance['open_new_tab'] = esc_attr($new_instance['open_new_tab']);
	return $instance;
}

/**
* [widget content]
*/
function widget( $args, $instance ) {
	extract($args);
	$title = apply_filters( 'widget_title', $instance['title'] );
	$new_tab = $instance['open_new_tab'] ? 'true' : 'false';
	echo $before_widget;
	if ( !empty( $title ) ) {
		echo $before_title;
		echo $title;
		echo $after_title;
	} ?>
	<div class="content-sidebar-widget">
		<div class="image_widget">
			<a
				<?php if ( $instance['content_alert'] ) { ?>
					onclick="s=prompt(' <?php echo $instance['notifications'] ?>:','<?php echo $instance['content_alert'] ?>')"
				<?php } else { } ?>
					target="<?php echo ($instance['open_new_tab']=='on') ? '_blank' : '_self' ?>" href="<?php echo $instance['url']; ?>" >
					<img
					class="img-responsive <?php echo ($instance['class_image']) ? $instance['class_image'] : '' ?>"
					id="<?php echo ($instance['id_image']) ? $instance['id_image'] : '' ?> "
					width="<?php echo ($instance['width_image']) ? $instance['width_image'] : '100%' ?>"
					height="<?php echo ($instance['height_image']) ? $instance['height_image'] : 'auto' ?>"
					title="<?php echo ($instance['image_title']) ? : 'Image-Banner' ?>"
					src="<?php echo ($instance['image']) ? $instance['image'] : get_template_directory_uri().'/images/default.png' ?>"
					alt="<?php echo ($instance['image_title']) ? $instance['image_title'] : 'Image'  ?>">
			</a>
			<?php if ( $instance['image_caption'] != '' ) {
				echo ('<div class="image-widget-caption" style="font-size: 16px; line-height:24px; color: #000; padding: 5px;">'.$instance['image_caption'].'</div>');
				} ?>
		</div>
	</div>
<?php
	echo $after_widget;
	}
}

/*
* End Plugins Images Banner Widget
*/
