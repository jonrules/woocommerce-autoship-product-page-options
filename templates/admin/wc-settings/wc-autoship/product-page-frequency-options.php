<tr valign="top">
<th scope="row" class="titledesc">
<label for="<?php echo esc_attr( $value['id'] ); ?>"><?php echo esc_html( $value['title'] ); ?></label>
		<?php echo $description['tooltip_html']; ?>
	</th>
	<td class="forminp forminp-<?php echo sanitize_title( $value['type'] ) ?>">
		<input type="hidden" name="wc_autoship_product_page_frequency_options" value="" />
		<table id="wc-autoship-product-page-frequency-options-table">
			<thead>
				<tr>
					<th><?php echo __( 'Frequency', 'wc-autoship-product-page' ); ?></th>
					<th><?php echo __( 'Name', 'wc-autoship-product-page' ); ?></th>
					<th>&times;</th>
				</tr>
			</thead>
			<tfoot>
				<td><input type="text" id="wc-autoship-product-page-frequency" placeholder="<?php echo __( 'Enter Frequency', 'wc-autoship-product-page' ); ?>" /></td>
				<td><input type="text" id="wc-autoship-product-page-frequency-name" placeholder="<?php echo __( 'Enter Name', 'wc-autoship-product-page' ); ?>" /></td>
				<td><button type="button" id="wc-autoship-product-page-frequency-button"><?php echo __( 'Add', 'wc-autoship-product-page' ); ?></button></td>
			</tfoot>
			<tbody id="wc-autoship-product-page-frequency-options-body">
				<?php if ( ! empty( $frequency_options ) ): ?>
					<?php foreach ( $frequency_options as $frequency => $name ): ?>
						<tr id="wc-autoship-frequency-option-<?php echo esc_attr( $frequency ); ?>" class="wc-autoship-frequency-option" data-frequency="<?php echo esc_attr( $frequency ); ?>">
							<td class="wc-autoship-frequency-option-frequency-column">
								<input type="hidden" name="wc_autoship_product_page_frequency_options[<?php echo esc_attr( $frequency ); ?>]"
									value="<?php echo esc_attr( $name ); ?>" />
								<span><?php echo esc_html( $frequency ); ?></span>
							</td>
							<td class="wc-autoship-frequency-option-name-column"><?php echo esc_html( $name ); ?></td>
							<td class="wc-autoship-frequency-option-delete-column"><button class="wc-autoship-frequency-option-delete">&times;</button></td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</td>
</tr>
<script>
// <![CDATA[
jQuery(function ($) {
	function sortFrequencyOptions() {
		var options = $('.wc-autoship-frequency-option').toArray();
		var changed = false;
		do {
			changed = false;
			for (var l = 0, r = 1; r < options.length; l++, r++) {
				var $left = $(options[l]);
				var $right = $(options[r]);
				if ($right.data('frequency') < $left.data('frequency')) {
					var temp = options[l];
					options[l] = options[r];
					options[r] = temp;
					changed = true;
				}
			}
		} while (changed);
		for (var i = 0; i < options.length; i++) {
			$('#wc-autoship-product-page-frequency-options-body').append(options[i]);
		}
	}
	
	$('#wc-autoship-product-page-frequency-button').click(function () {
		var frequency = parseInt($('#wc-autoship-product-page-frequency').val());
		var name = $('#wc-autoship-product-page-frequency-name').val();
		if (isNaN(frequency) || frequency < 7 || frequency > 365 || name == '') {
			return;
		}
		var options = $('.wc-autoship-frequency-option').toArray();
		for (var i = 0; i < $('.wc-autoship-frequency-option').length; i++) {
			if ($(options[i]).data('frequency') == frequency) {
				alert('This frequency option already exists!');
				return;
			}
		}
		// Frequency option row
		var $frequencyOption = $('<tr class="wc-autoship-frequency-option"></tr>')
			.attr('id', 'wc-autoship-frequency-option-' + frequency)
			.data('frequency', frequency);
		// Frequency column
		var $frequencyColumn = $('<td class="wc-autoship-frequency-option-frequency-column"></td>');
		var $input = $('<input type="hidden" />')
			.attr('name', 'wc_autoship_product_page_frequency_options[' + frequency + ']')
			.val(name);
		$frequencyColumn.append($input);
		$frequencyColumn.append($('<span></span>').text(frequency));
		$frequencyOption.append($frequencyColumn);
		// Name column
		var $nameColumn = $('<td class="wc-autoship-frequency-option-name-column"></td>');
		$nameColumn.text(name);
		$frequencyOption.append($nameColumn);
		// Delete column
		var $deleteColumn = $('<td class="wc-autoship-frequency-option-delete-column"></td>');
		var $deleteButton = $('<button type="button" class="wc-autoship-frequency-option-delete">&times;</button>');
		$deleteButton.click(function () {
			$(this).parents('.wc-autoship-frequency-option').remove();
		});
		$deleteColumn.append($deleteButton);
		$frequencyOption.append($deleteColumn);
		// Append row
		$('#wc-autoship-product-page-frequency-options-body').append($frequencyOption);
		$('#wc-autoship-product-page-frequency').val('').focus();
		$('#wc-autoship-product-page-frequency-name').val('');
		sortFrequencyOptions();
	});

	$('.wc-autoship-frequency-option-delete').click(function () {
		$(this).parents('.wc-autoship-frequency-option').remove();
	});
});
// ]]>
</script>