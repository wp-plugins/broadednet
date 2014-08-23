<?php
/*
Plugin Name: BroadedNET
Plugin URI: http://broaded.net/
Description: A wide network for blog promotion and traffic
Author: Enstine Muki
Version: 1.0
Author URI: http://enstinemuki.com/
*/

class BroadedNet extends WP_Widget {
function BroadedNet()
  {
    $widget_ops = array('classname' => 'BroadedNet', 'description' => 'A wide network for blog promotion and traffic' );
    $this->WP_Widget('BroadedNet', 'BroadedNET', $widget_ops);
  }


function form($instance) {

// Check values
if( $instance) {
$title = esc_attr($instance['title']);
$BPNapi = $instance['BPNapi'];
$BPN_Num = $instance['BPN_Num'];
$BPN_url= $instance['BPN_url'];
$BPN_cat= $instance['BPN_cat'];
$BPN_lineColor=$instance['BPN_lineColor'];
$BPN_line=$instance['BPN_line'];
$BPN_camtype=$instance['BPN_camtype'];
	} 
	else 
	{
		$title = '';
		$BPNapi = '';
		$BPN_Num = '5';
		$BPN_url='';
		$BPN_cat='1';
		$BPN_lineColor='#F3F3F3';
		$BPN_line='';
		$BPN_camtype='';
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
$getCat=file_get_contents("http://broaded.net/catwidget.php"); 
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
<option value="Article" <?php selected($BPN_camtype, "Article" );?>>Article Titles</option>
<option value="300x250" <?php selected($BPN_camtype, "300x250" );?>>300x250 Banner</option>
<option value="250x250" <?php selected($BPN_camtype, "250x250" );?>>250x250 Banner</option>
<option value="468x60" <?php selected($BPN_camtype, "468x60" );?>>468x60 Banner</option>
<option value="160x600" <?php selected($BPN_camtype, "160x600" );?>>160x600 Banner</option>
<option value="728x90" <?php selected($BPN_camtype, "728x90" );?>>728x90 Banner</option>
</select></p>

<p>
<label for="<?php echo $this->get_field_id('BPN_Num'); ?>"><?php _e('Num of Entries to show (Articles)', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('BPN_Num'); ?>" name="<?php echo $this->get_field_name('BPN_Num'); ?>" type="text" value="<?php echo $BPN_Num; ?>" />
</p>

<label for="<?php echo $this->get_field_id('BPN_Line'); ?>"><?php _e('Seperate entries with lines (Articles)', 'wp_widget_plugin'); ?></label>
<select name="<?php echo $this->get_field_name('BPN_line'); ?>">
<option value="NO" <?php selected($BPN_line, "NO" );?>>NO</option>
<option value="solid" <?php selected($BPN_line, "solid" );?>>Solid Lines</option>
<option value="dotted" <?php selected($BPN_line, "dotted" );?>>Dotted Lines</option>
<option value="dashed" <?php selected($BPN_line, "dashed" );?>>Dashed Lines</option>

</select></p>

<p>
<label for="<?php echo $this->get_field_id('BPN_lineColor'); ?>"><?php _e('Line Color (Articles)', 'wp_widget_plugin'); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id('BPN_lineColor'); ?>" name="<?php echo $this->get_field_name('BPN_lineColor'); ?>" type="text" value="<?php echo $BPN_lineColor; ?>" />
</p>
<p>Show BPN Link (Articles)
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
$instance['title'] = strip_tags($new_instance['title']);
$instance['BPNapi'] = strip_tags($new_instance['BPNapi']);
$instance['BPN_Num'] = strip_tags($new_instance['BPN_Num']);
$instance['BPN_url'] = strip_tags($new_instance['BPN_url']);
$instance['BPN_cat'] = strip_tags($new_instance['BPN_cat']);
$instance['BPN_line'] = strip_tags($new_instance['BPN_line']);
$instance['BPN_lineColor'] = strip_tags($new_instance['BPN_lineColor']);
$instance['BPN_camtype'] = strip_tags($new_instance['BPN_camtype']);

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
$line=$instance['BPN_line'];
$lcolor=$instance['BPN_lineColor'];
$BPN_camtype=$instance['BPN_camtype'];

if ( $title )
    echo $before_title . $title . $after_title;
	
	if($BPN_camtype=="Article")
		{
			$external="useLine=$line&lcolor=$lcolor";
		}
			else
		{
			$external="camtype=$BPN_camtype";
		}
$response=file_get_contents("http://broaded.net/external.php?api=$BPNapi&num=$BPN_Num&r=".$_SERVER['HTTP_HOST']."&url=$BPN_url&cat=$BPN_cat&$external");  
echo $response; 

echo $after_widget;
}
}

// register widget
add_action('widgets_init', create_function('', 'return register_widget("BroadedNet");'));

?>