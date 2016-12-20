<?php
# Short code for gating a piece of content
# 
# Not yet sure about the id functionality, but it's okay for now.
# [pm_gate 
#   id:string => true
#   condition:boolean => true
#   hide:boolean => true
# ] content to be hidden if condition is true [/pm_gate]

# Maybe a matching tag for the same string to do the opposite
# [pm_gate id:same_string] Replacement Content [/pm_gate]

# Keep in mind, a shortcode within a shortcode will require 
# recursive do_shortcode,
# but since you aren't going to know ahead of time..
# https://codex.wordpress.org/Function_Reference/get_shortcode_regex
# then you'd have to check the text for the shortcodes and parse that.

/*
	Utilizing has_shortcode/shortcode_exists,
  we can create a conditional for the user like so:

	[pm_gate atts]
		Content we want goes here
		[pm_otherwise]

		[/pm_otherwise]
	[/pm_gate]

	OR,

	[pm_gate atts show_if]

	[/pm_gate]

	[pm_gate atts hide_if]

	[/pm_gate]




*/
# 	preg_match_all("/\[\/?caption\]/", $content, $matches, PREG_OFFSET_CAPTURE);		
# http://stackoverflow.com/a/15013881/791026
function GetBetween($var1="", $var2="", $pool){

	$temp1 = strpos($pool,$var1)+strlen($var1);
	$result = substr($pool,$temp1,strlen($pool));
	$dd = strpos($result,$var2);
	
	if ($dd == 0) {
		$dd = strlen($result);
	}

	return substr($result,0,$dd);
}

function pm_gate_func($atts, $content=null){
	# grab the attributes
	$attributes = shortcode_atts([
		'id' 				=> uniqid('pmg-'),
		'condition' => 'true',
		'hide' 			=> 'true'
	], $atts);
		
	$pm_id = $attributes['id'];
	$condition = $attributes['condition'];
	$hide = $attributes['hide'];
	$output = "ID is: $pm_id, Condition is: $condition, and Hide is: $hide";

	ob_start();
 ?>

<?php if ($condition == 'true'): ?>
	
	<?php 
		echo do_shortcode("[caption]" . GetBetween('[caption]', '[/caption]', $content)."[/caption]");
	?>
	
	<p><?php echo $content ?></p>
	<br />	
	<pre><?php echo $output ?></pre>
	
<?php else: ?>

	<p>Sorry</p>

	<?php endif;
	return ob_get_clean();
}

add_shortcode('pm_gate', 'pm_gate_func');

?>