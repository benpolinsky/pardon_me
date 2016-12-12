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
# recursive 

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