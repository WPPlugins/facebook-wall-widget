<?php
/*
Plugin Name: Facebook Wall Widget
Plugin URI: http://plugins.svn.wordpress.org/facebook-wall-widget/
Description: Provides a widget to insert Facebook wall iFrames in any widget area.
Version: 1.1
Author: ITS Alaska
Author URI: http://www.itscanfixthat.com/
*/

class ITS_facebook_wall_widget extends WP_Widget{
public function __construct() {
                parent::__construct(
                        'facebook_wall_widget', // Base ID
                        'Facebook Wall Widget', // Name
                        array( 'description' => __( 'This widget adds an embedded Facebook wall to the widget area of the specified page.', 'text_domain' ), )
                );
        }

        function form(){
		$data = get_option('its_facebook_wall');
	        ?>
	        	<p><label>Title: <input name="its_facebook_wall_title" type="text" value="<?php echo $data['title']; ?>" style="width:180px;" /></label></p>
                        <p><label>URL: <input name="its_facebook_wall_url" type="text" value="<?php echo $data['url']; ?>" style="width:180px;" /></label></p>
                        <p><label>Width: <input name="its_facebook_wall_width" type="text" value="<?php echo $data['width']; ?>" style="width:180px;" /></label></p>
                        <p><label>Height: <input name="its_facebook_wall_height" type="text" value="<?php echo $data['height']; ?>" style="width:180px;" /></label></p>
                        <p><label>Page: <input name="its_facebook_wall_page" type="text" value="<?php echo $data['page']; ?>" style="width:180px;" /></label></p>
		<?php
        }

	function update(){
                $data['title'] = attribute_escape($_POST['its_facebook_wall_title']);
                $data['url'] = attribute_escape($_POST['its_facebook_wall_url']);
                $data['width'] = attribute_escape($_POST['its_facebook_wall_width']);
                $data['height'] = attribute_escape($_POST['its_facebook_wall_height']);
				$data['page'] = attribute_escape($_POST['its_facebook_wall_page']);
                update_option('its_facebook_wall', $data);


	}

	function widget($args){
		$data = get_option('its_facebook_wall');
		$page = "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		// Patched by daniel@itsalaska.com
		// Allows user to specify relative link to support multiple domain names
		if($page==$data['page'] || $_SERVER['REQUEST_URI']==$data['page']){
			echo $args['before_widget'];
			?>
			<h3 class='widget-title'><?php echo $data['title']; ?></h3>
                        <iframe src="//www.facebook.com/plugins/likebox.php?href=<?php echo urlencode($data['url']); ?>&amp;width=<?php echo $data['width']; ?>&amp;height=<?php echo $data['height']; ?>&amp;colorscheme=light&amp;show_faces=true&amp;border_color&amp;stream=true&amp;header=true" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:<?php echo $data['width']; ?>px; height:<?php echo $data['height']; ?>px;background-color:#ffffff;" allowTransparency="true"></iframe>
                        <?php
			echo $args['after_widget'];
		 }
        }

}

add_action( 'widgets_init', create_function( '', 'register_widget( "ITS_facebook_wall_widget" );' ) );
?>
