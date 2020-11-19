<?php
/**
 * Admin View: Settings
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$_nicename = _KB()->app_nicename;
$tabs = array('general' =>'General', 'youtube' => 'Youtube');
$this->kipbeats_options = get_option( 'kipbeats_option_name' );
print_r($this->kipbeats_options);
?>

<div class="wrap <?= $_nicename ?>">
    <h2>KipBeats Options</h2>
    <p></p>
    <?php settings_errors(); ?>
	<form  id="mainform" action="" enctype="multipart/form-data">
		<div class="icon32 icon32-<?= $_nicename ?>-settings" id="icon-<?= $_nicename ?>"><br /></div>
		<ul class="nav nav-tabs <?=$_nicename. '_settings_tabs' ?>" id="myTab" role="tablist">
        <?php
				
            foreach ( $tabs as $name => $label ) { ?>
                <li class="nav-item">
                    <a class="nav-link <?= ( array_keys($tabs)[0] == $name ? 'active' : '' ); ?>" id="<?=$name?>-tab" data-toggle="tab" href="#<?=$name?>" role="tab" aria-controls="<?=$name?>" aria-selected="<?= ( array_keys($tabs)[0] == $name ? 'true' : '' ); ?>"><?=$label?></a>
                </li>
            <?php }
        ?>
		</ul>
        <div class="tab-content" id="myTabContent">
        <?php
            foreach ( $tabs as $name => $label ) { ?>
                <div class="tab-pane fade show active" id="<?=$name?>" role="tabpanel" aria-labelledby="<?=$name?>-tab"> <?php include_once('settings-'.$name.'.php' );?></div>
        <?php } ?>
        </div>


		<p class="submit">
			<?php if ( ! isset( $GLOBALS['hide_save_button'] ) ) : ?>
				<input name="save" class="btn btn-primary" type="submit" value="<?php _e( 'Save changes', $_nicename ); ?>" />
			<?php endif; ?>
			<input type="hidden" name="subtab" id="last_tab" />
			<?php wp_nonce_field( $_nicename.'-settings' ); ?>
		</p>
	</form>
</div>
