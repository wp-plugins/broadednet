<?php
/*
Plugin Name: BroadedNet
Plugin URI: http://broaded.net/
Description: A wide network for blog promotion and traffic
Author: Enstine Muki
Version: 1.4
Author URI: http://enstinemuki.com/
*/

class BroadedNet extends WP_Widget {
function BroadedNet()
  {
    $widget_ops = array('classname' => 'BroadedNet', 'description' => 'A wide network for blog promotion and traffic' );
    $this->WP_Widget('BroadedNet', 'BroadedNet', $widget_ops);
  }


function form($instance) {

// Check values
if( $instance) {
$title = esc_attr($instance['title']);
$BPNapi = $instance['BPNapi'];
$BPN_Num = $instance['BPN_Num'];
$BPN_url= $instance['BPN_url'];
$show_gravatar= $instance['show_gravatar'];
$gravatar_size = $instance['gravatar_size'];
$BPN_cat= $instance['BPN_cat'];
$BPN_camtype=$instance['BPN_camtype'];
$BPN_custom_widget=$instance['BPN_custom_widget'];
	} 
	else 
	{
		$title = '';
		$BPNapi = '';
		$BPN_Num = '5';
		$BPN_url='';
		$BPN_cat='1';
		$BPN_camtype='';
		$BPN_custom_widget='';
		$gravatar_size='80';
		$show_gravatar='on';
	}
?>

<p>
<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
</p>
<p>
<label for="<?php echo $this->get_field_id('BPNapi'); ?>"><?php _e('Broaded API', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('BPNapi'); ?>" name="<?php echo $this->get_field_name('BPNapi'); ?>" type="text" value="<?php echo $BPNapi; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('BPN_cat'); ?>"><?php _e('Select A Broaded Category', 'wp_widget_plugin'); ?></label>
<select name="<?php echo $this->get_field_name('BPN_cat'); ?>">
<?php
$ch = curl_init();

// Set query data here with the URL
curl_setopt($ch, CURLOPT_URL, 'http://broaded.net/catwidget.php'); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$getCat= trim(curl_exec($ch));
curl_close($ch);

//$getCat=file_get_contents("http://broaded.net/catwidget.php"); 
$a=@split(',',$getCat);
foreach($a as $x=>$x_value) {
$sp=@split('\|',$x_value);
echo"<option value=\"".$sp[1]."\" ".selected($BPN_cat, $sp[1] ).">$sp[0]</option>";

	}

?>
</select>
</p>

<p>
<label for="<?php echo $this->get_field_id('BPN_camtype'); ?>"><?php _e('What to show on this widget', 'wp_widget_plugin'); ?></label>
<select name="<?php echo $this->get_field_name('BPN_camtype'); ?>">
<option value="MyCustomWidget" <?php selected($BPN_camtype, "MyCustomWidget" );?>>My Custom Widget</option>
<option value="Article" <?php selected($BPN_camtype, "Article" );?>>Random Article Titles</option>
<option value="300x250" <?php selected($BPN_camtype, "300x250" );?>>300x250 Banner</option>
<option value="250x250" <?php selected($BPN_camtype, "250x250" );?>>250x250 Banner</option>
<option value="468x60" <?php selected($BPN_camtype, "468x60" );?>>468x60 Banner</option>
<option value="160x600" <?php selected($BPN_camtype, "160x600" );?>>160x600 Banner</option>
<option value="728x90" <?php selected($BPN_camtype, "728x90" );?>>728x90 Banner</option>
</select></p>

<p>
<label for="<?php echo $this->get_field_id('BPN_custom_widget'); ?>"><?php _e('Your Broaded Custom Widget ID', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('BPN_custom_widget'); ?>" name="<?php echo $this->get_field_name('BPN_custom_widget'); ?>" type="text" value="<?php echo $BPN_custom_widget; ?>" />
</p>

<p>
<label for="<?php echo $this->get_field_id('BPN_Num'); ?>"><?php _e('Num of Entries to show on this widget (Articles only)', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('BPN_Num'); ?>" name="<?php echo $this->get_field_name('BPN_Num'); ?>" type="text" value="<?php echo $BPN_Num; ?>" />
</p>
<p>Show Gravatar
<input class="checkbox" type="checkbox" <?php checked($instance['show_gravatar'], 'on'); ?> id="<?php echo $this->get_field_id('show_gravatar'); ?>" name="<?php echo $this->get_field_name('show_gravatar'); ?>" /> </p>

<p>Gravatar Size (Default is 80)
<input class="widefat" id="<?php echo $this->get_field_id('gravatar_size'); ?>" name="<?php echo $this->get_field_name('gravatar_size'); ?>" type="text" value="<?php echo $gravatar_size; ?>" />
</p>




<p>Show <i>Powered by</i> Link (Articles)
<input class="checkbox" type="checkbox" <?php checked($instance['BPN_url'], 'on'); ?> id="<?php echo $this->get_field_id('BPN_url'); ?>" name="<?php echo $this->get_field_name('BPN_url'); ?>" /> </p>

<?php
}
function update($new_instance, $old_instance) 
{
$instance = $old_instance;
// Fields
if(empty($new_instance['BPN_Num']))
	{
		$new_instance['BPN_Num'] = 5;
	}
if($new_instance['BPN_Num'] < 3 )
	{
		$new_instance['BPN_Num'] = 3;
	}
///////////////////////Set default gravata
if(empty($new_instance['gravatar_size']))
	{
		$new_instance['gravatar_size'] = 80;
	}
if($new_instance['gravatar_size'] > 80 )
	{
		$new_instance['gravatar_size'] = 80;
	}
/////////////////////////////////////////
$instance['title'] = strip_tags(trim($new_instance['title']));
$instance['BPNapi'] = strip_tags(trim($new_instance['BPNapi']));
$instance['BPN_Num'] = strip_tags($new_instance['BPN_Num']);
$instance['BPN_url'] = strip_tags($new_instance['BPN_url']);
$instance['BPN_cat'] = strip_tags($new_instance['BPN_cat']);
$instance['BPN_camtype'] = strip_tags($new_instance['BPN_camtype']);
$instance['BPN_custom_widget'] = strip_tags(trim($new_instance['BPN_custom_widget']));
$instance['show_gravatar'] = strip_tags($new_instance['show_gravatar']);
$instance['gravatar_size'] = strip_tags($new_instance['gravatar_size']);

return $instance;
}
// display widget
function widget($args, $instance) {
extract( $args );

// these are the widget options
$title = apply_filters('widget_title', $instance['title']);
$BPNapi = $instance['BPNapi'];
$BPN_Num=$instance['BPN_Num'];
$BPN_url=$instance['BPN_url'];
$BPN_cat=$instance['BPN_cat'];
$BPN_camtype=$instance['BPN_camtype'];
$BPN_custom_widget = $instance['BPN_custom_widget'];
$show_gravatar= $instance['show_gravatar'];
$gravatar_size = $instance['gravatar_size'];
$gravatarOption="showGravatar=$show_gravatar&dsize=$gravatar_size";
echo $before_widget;
if (!empty($title))
{
    echo $before_title . $title . $after_title;
}
	
	if($BPN_camtype=="Article")
		{
			$external="";
		}
			elseif($BPN_camtype=="MyCustomWidget")
		{	
			/////Do something
			$external="";
		}
			else
		{
			$external="camtype=$BPN_camtype";
		}
$extQuery="?MyCustomWidget=$BPN_camtype&MyCustomWidgetId=$BPN_custom_widget&api=$BPNapi&num=$BPN_Num&r=".$_SERVER['HTTP_HOST']."&url=$BPN_url&cat=$BPN_cat&$external&$gravatarOption";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://broaded.net/external.php'.$extQuery); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, '3');
$response= trim(curl_exec($ch));
curl_close($ch);
if (strpos($response,'broaded_OK_show') !== false)
 {
    echo $response; 
 }
 	else
{
	echo"We are upgrading <a href=\"http://broaded.net\" rel=\"nofollow\" target=\"_blank\">BroadedNet, Blog Traffic Tool</a>. Please keep reading <a href=\"".$_SERVER['HTTP_HOST']."\">".$_SERVER['HTTP_HOST']."</a>";
}

echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("BroadedNet");'));

?>