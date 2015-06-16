<?php
/* @var $product WC_Product */
?>

<div class="wc-autoship-container">

	<div class="wc-autoship-options">
		<?php 
		$price = $product->get_price();
		$autoship_price = get_post_meta( $product->id, '_wc_autoship_price', true );
		$autoship_min_frequency = get_post_meta( $product->id, '_wc_autoship_min_frequency', true );
		$autoship_max_frequency = get_post_meta( $product->id, '_wc_autoship_max_frequency', true );
		$autoship_default_frequency = get_post_meta( $product->id, '_wc_autoship_default_frequency', true );
		
		// Frequency options
		$frequency_options = array(
			__( '1 Month', 'wc-autoship' ) => 30,
			__( '2 Months', 'wc-autoship' ) => 60,
			__( '3 Months', 'wc-autoship' ) => 90,
			__( '4 Months', 'wc-autoship' ) => 120,
			__( '5 Months', 'wc-autoship' ) => 150
		);
		
		?>
	
		<div class="panel panel-default">
			<div class="panel-body">
				<p class="wc-autoship-select-frequency"><?php echo __( 'Select an Auto-Ship Frequency to add this item to auto-ship.', 'wc-autoship' ); ?></p>
				<?php if ( ! empty( $autoship_price ) && $price != $autoship_price ): ?>
					<h3 class="wc-autoship-price"><?php echo __( 'Auto-Ship price:', 'wc-autoship'); ?> <?php echo wc_price( $autoship_price ); ?></h3>
				<?php endif; ?>
				<p class="wc-autoship-frequency">
					<label for="wc_autoship_frequency"><?php echo __( 'Auto-Ship Frequency:', 'wc-autoship' ); ?></label>
					<select name="wc_autoship_frequency" id="wc_autoship_frequency">
						<option value="">&mdash;<?php echo __( 'SELECT', 'wc-autoship' ); ?>&mdash;</option>
						<?php foreach ( $frequency_options as $name => $days ): ?>
							<?php if ( $days < $autoship_min_frequency || $days > $autoship_max_frequency ) continue; ?>
							<option value="<?php echo esc_html( $days ); ?>" <?php echo selected( $days, $autoship_default_frequency ); ?>><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
				</p>
			</div>
		</div>
	</div>

</div>
