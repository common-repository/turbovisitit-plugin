<?php
/*
Plugin Name: Turbovisit.it plugin
Plugin URI: http://www.josie.it/wordpress/turbovisit-plugin/
Description: Questo plugin ti permette di integrare il sistema di scambio visite di Turbovisit.it in modo automatico.
Version: 2.0
Author: Serena Villa
Author URI: http://www.josie.it
*/
function my_scripts_method() {
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.7/jquery.min.js');
    wp_enqueue_script( 'jquery' );
    wp_enqueue_script('fancybox', plugins_url('/fancybox/jquery.fancybox-1.3.4.pack.js', __FILE__));
}



function turbovisit_footer(){
	if (!get_option("turbovisit_chance")){
		update_option("turbovisit_chance","70");
	}
	$turbovisit_chance=get_option("turbovisit_chance");
	//tranne nella home
	wp_reset_query();
	if (!is_feed()){
?>
		<script src="https://www.webinabox.it/turbovisit/turbo-<?php echo $turbovisit_chance; ?>.js" type="text/JavaScript"></script>

<?php
	}
}

function turbovisit_header(){

	//tranne nella home
	wp_reset_query();
	if (!is_feed()){
?>

	<link rel="stylesheet" href="<?php echo get_bloginfo('wpurl')?>/wp-content/plugins/turbovisitit-plugin/fancybox/jquery.fancybox-1.3.4.css" />

<?php
	}
}

function turbo_options() {
	if (!current_user_can('manage_options'))  {
		wp_die( __('Non hai i permessi sufficienti per accedere a questa pagina.') );
	}
	if ($_POST["modify"]<>"") {
	update_option("turbovisit_chance",$_POST["turbovisit_chance"]);

	echo '<div class="updated fade">Opzioni aggiornate</div>';
	}
	?>
	<div class="wrap">
	<?php if(function_exists('screen_icon')) screen_icon(); ?>
	<h2>Opzioni Turbovisit</h2><br />

	<style>
	td {padding:5px;}
	</style>

	<form method="post">
	<table>
	<tr>
	<td>Probabilit&agrave; di turbovisit</td>
	<?php $probabilita_attuale = get_option("turbovisit_chance");?>
	<td><select name="turbovisit_chance">
		<option value="100"<?php if ($probabilita_attuale=="100") {echo ' selected="selected"';}?>>100%</option>
		<option value="90"<?php if ($probabilita_attuale=="90") {echo ' selected="selected"';}?>>90%</option>
		<option value="80"<?php if ($probabilita_attuale=="80") {echo ' selected="selected"';}?>>80%</option>
		<option value="70"<?php if ($probabilita_attuale=="70") {echo ' selected="selected"';}?>>70%</option>
		<option value="60"<?php if ($probabilita_attuale=="60") {echo ' selected="selected"';}?>>60%</option>
		<option value="50"<?php if ($probabilita_attuale=="50") {echo ' selected="selected"';}?>>50%</option>
		<option value="40"<?php if ($probabilita_attuale=="40") {echo ' selected="selected"';}?>>40%</option>
		<option value="30"<?php if ($probabilita_attuale=="30") {echo ' selected="selected"';}?>>30%</option>
		<option value="20"<?php if ($probabilita_attuale=="20") {echo ' selected="selected"';}?>>20%</option>
		<option value="10"<?php if ($probabilita_attuale=="10") {echo ' selected="selected"';}?>>10%</option>
	</select>
	</td></tr>
	</table><br />
	<input type="submit" class="button-primary" value="Salva" name="modify" />
	</form>

	</div>
<?php
}

function turbovisit_options() {
	add_options_page('Turbovisit opzioni', 'Turbovisit opzioni', 'manage_options','turbo_options', 'turbo_options');
}

add_action('wp_enqueue_scripts', 'my_scripts_method');
add_action('admin_menu', 'turbovisit_options');
add_action('wp_head','turbovisit_header');
add_action('wp_footer','turbovisit_footer');
?>
