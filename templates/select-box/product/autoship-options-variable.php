<?php
/* @var $product WC_Product */
?>

<div class="wc-autoship-container">

	<div class="wc-autoship-options">
		<?php 
		$autoship_min_frequency = get_post_meta( $product->id, '_wc_autoship_min_frequency', true );
		$autoship_max_frequency = get_post_meta( $product->id, '_wc_autoship_max_frequency', true );
		$autoship_default_frequency = get_post_meta( $product->id, '_wc_autoship_default_frequency', true );
		$autoship_price = '';
		$default_attributes = $product->get_variation_default_attributes();
		if ( ! empty( $default_attributes ) ) {
			$variations = $product->get_available_variations();
			foreach ( $variations as $variation ) {
				foreach ( $default_attributes as $name => $value ) {
					if ( isset( $variation['attributes'][ 'attribute_' . $name ] ) && $variation['attributes'][ 'attribute_' . $name ] == '' ) {
						continue;
					} elseif ( ! isset( $variation['attributes'][ 'attribute_' . $name ] ) || $variation['attributes'][ 'attribute_' . $name ] != $value ) {
						continue 2;
					}
				}
				$autoship_price = apply_filters( 'wc_autoship_price',
					get_post_meta( $variation['variation_id'], '_wc_autoship_price', true ),
					$variation['variation_id'],
					0,
					get_current_user_id()
				);
				break;
			}
		}
		
		// Frequency options
		$frequency_options = get_option( 'wc_autoship_product_page_frequency_options' );
		
		?>
	
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="wc-autoship-selectfrequency"><?php echo __( 'Select an Auto-Ship Frequency to add this item to auto-ship.', 'wc-autoship-product-page' ); ?></p>
				<h3 class="wc-autoship-price" <?php if ( empty( $autoship_price ) ) echo 'style="display:none"'; ?>><?php echo __( 'Auto-Ship price:', 'wc-autoship-product-page'); ?> <?php echo wc_price( $autoship_price ); ?></h3>			
				<p class="wc-autoship-frequency">
					<label for="wc_autoship_frequency"><?php echo __( 'Auto-Ship Frequency:', 'wc-autoship-product-page' ); ?></label>
					<select name="wc_autoship_frequency" id="wc_autoship_frequency">
						<option value="">&mdash;<?php echo __( 'SELECT', 'wc-autoship-product-page' ); ?>&mdash;</option>
						<?php if ( ! empty( $frequency_options ) ): ?>
							<?php foreach ( $frequency_options as $days => $name ): ?>
								<?php if ( $days < $autoship_min_frequency || $days > $autoship_max_frequency ) continue; ?>
								<option value="<?php echo esc_html( $days ); ?>" <?php echo selected( $days, $autoship_default_frequency ); ?>><?php echo esc_html( $name ), ' ', __( "(Every $days days)", 'wc-autoship-product-page' ); ?></option>
							<?php endforeach; ?>
						<?php endif; ?>
					</select>
				</p>
			</div>
		</div>
	</div>
	
</div>
