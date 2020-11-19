<?php
if ( ! function_exists( 'encode_db_array' ) ) :
	
	function encode_db_array($a) {
		return EG()->query->encode_db_array($a);
	}
endif;
if ( ! function_exists( 'decode_db_array' ) ) :
	
	function decode_db_array($a) {
		return EG()->query->decode_db_array($a);
	}
endif;

function get_paypal_button($id) {
    $paypalitem = get_post_meta( $id, '_paypal_digital_', true );
    @extract($paypalitem);//exit;
    if (!$enabled) return; ?>
    <div class="form-row">
        <div class="form-group col-md-4">
            
            <small id="_paypal_digital_name_Help" class="form-text text-muted">
                 Purchase Download <?= $name ?>
            </small>
        </div>
        <div class="form-group col-md-6">
   <?= do_shortcode('[paypal_for_digital_goods name="'.$name.'" price="'.$price.'" url="'.$url.'"]'); ?>
        </div>
    </div>

<?php }











?>