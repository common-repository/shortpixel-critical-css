<?php


namespace ShortPixel\CriticalCSS\Admin\UI;


use ComposePress\Core\Abstracts\Component;

class Term extends Component {

	/**
	 *
	 */
	public function init() {
		add_action( 'wp_loaded', [
			$this,
			'wp_loaded_action',
		] );
	}

	/**
	 *
	 */
	public function wp_loaded_action() {
		foreach ( get_taxonomies() as $tax ) {
			if ( apply_filters( 'shortpixel_critical_css_manual_term_css', true ) ) {
				add_action( "{$tax}_edit_form", [
					$this,
					'render_manual_css_form',
				] );
				add_action( "edit_{$tax}", [
					$this,
					'save_manual_css',
				] );
			}
			if (
                    get_taxonomy( $tax )->hierarchical
//                    && 'on' !== $this->plugin->settings_manager->get_setting( 'template_cache' )
            ) {
				add_action( "{$tax}_edit_form", [
					$this,
					'render_term_css_override_form',
				] );
				add_action( "edit_{$tax}", [
					$this,
					'save_css_override',
				] );
			}

		}
	}

	/**
	 *
	 */
	public function render_manual_css_form() {
		$slug      = $this->plugin->get_safe_slug();
		$object_id = $this->tag->term_id;
		?>
		<?php
		$css = $this->plugin->data_manager->get_item_data( [
			'type'      => 'term',
			'object_id' => $object_id,
		], 'manual_css' );
		?>

		<table class="form-table">
			<tr>
				<th>
					<?php
					esc_html_e( 'Enter your manual critical css here:', 'shortpixel-critical-css' );
					?>
				</th>
				<td>
<!--          $slug is sanitized in api.php && it returns a constant not a variable          -->
						<textarea name="<?php echo $slug ?>_manual_css" id="<?php echo $slug ?>_manual_css"
								  class="widefat" rows="10"><?php echo $css ?></textarea>
				</td>
			</tr>
		</table>
		<?php
	}

	public function render_term_css_override_form() {
		$slug  = $this->plugin->get_safe_slug();
		$value = $this->plugin->data_manager->get_item_data( [
			'type'      => 'term',
			'object_id' => $this->tag->term_id,
		], 'override_css' );
		?>
		<table class="form-table">
			<tr class="form-field">
				<th>
					<label for="<?php echo $slug ?>_override_css">
						<?php esc_html_e( 'Override Child Critical CSS', 'shortpixel-critical-css' ) ?>
					</label>
				</th>
				<td>
					<input type="checkbox" name="<?php echo $slug ?>_override_css" id="<?php echo $slug ?>_override_css"
						   value="1" <?php checked( $value ) ?>/>
				</td>
			</tr>
		</table>
		<?php
	}

	/**
	 * @param $post_id
	 */
	public function save_manual_css( $term_id ) {
		$slug  = $this->plugin->get_safe_slug();
		$field = "{$slug}_manual_css";
		if ( ! isset( $_POST[ $field ] ) ) {
			return;
		}
		$css = sanitize_textarea_field( $_POST[ $field ] );
		$this->plugin->data_manager->set_item_data( [
			'type'      => 'term',
			'object_id' => $term_id,
		], 'manual_css', $css );
	}

	public function save_css_override( $term_id ) {
		$slug  = $this->plugin->get_safe_slug();
		//OLD: $value = ! empty( $_POST["{$slug}_override_css"] ) && 1 == $_POST["{$slug}_override_css"];
		$value = isset($_POST["{$slug}_override_css"]) ? filter_var($_POST["{$slug}_override_css"], FILTER_VALIDATE_BOOLEAN) : false;
		// here,  i used filter_var() with the flag FILTER_VALIDATE_BOOLEAN  to sanitize the $_POST value for {$slug}_override_css.
		// this function replaces the olderr un-sanitized && 1 == $_POST["{$slug}_override_css"], that i kept above for more context.
		$this->plugin->data_manager->set_item_data( [
			'type'      => 'term',
			'object_id' => $term_id,
		], 'override_css', $value );
	}
}
