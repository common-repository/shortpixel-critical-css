<?php


namespace ShortPixel\CriticalCSS\Queue\Web\Check;


use ShortPixel\CriticalCSS\Queue\ListTableAbstract;

class Table extends ListTableAbstract {
	const TABLE_NAME = 'web_check';
	const STATUS_PROCESSING = 'processing';
	const STATUS_PENDING = 'pending';
	const STATUS_EXISTS = 'web_check_exists'; //status used only in frontend
	const STATUS_DONE = 'web_check_done'; //status used only in frontend

	public function __construct( array $args = [] ) {
		parent::__construct( [
			'singular' => __( 'Web Check Queue Item', 'shortpixel-critical-css' ),
			'plural'   => __( 'Web Check Queue Items', 'shortpixel-critical-css' ),
			'ajax'     => false,
		] );
	}

	/**
	 * @return array
	 */
	public function get_columns() {
		$columns = [
			'url'    => __( 'URL', 'shortpixel-critical-css' ),
			'status' => __( 'Status', 'shortpixel-critical-css' ),
			'actions'        => __( 'Actions', 'shortpixel-critical-css' ),
		];
		if ( is_multisite() ) {
			$columns = array_merge( [
				'blog_id' => __( 'Blog', 'shortpixel-critical-css' ),
			], $columns );
		}

		return $columns;
	}

	protected function do_prepare_items() {
		$wpdb        = shortpixel_critical_css()->wpdb;
		$table       = $this->get_table_name();
		$this->items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} ORDER BY LOCATE('status', {$table}.data) DESC LIMIT %d,%d", $this->start, $this->per_page ), ARRAY_A );
	}

	protected function process_purge_action() {
		parent::process_purge_action();
		shortpixel_critical_css()->get_cache_manager()->reset_web_check_transients();
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_blog_id( array $item ) {
		if ( empty( $item['blog_id'] ) ) {
			return __( 'N/A', 'shortpixel-critical-css' );
		}

		$details = get_blog_details( [
			'blog_id' => $item['blog_id'],
		] );

		if ( empty( $details ) ) {
			return __( 'Blog Deleted', 'shortpixel-critical-css' );
		}

		return $details->blogname;
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_url( array $item ) {
		return shortpixel_critical_css()->get_permalink( $item );
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_template( array $item ) {
		$settings = shortpixel_critical_css()->get_settings_manager()->get_settings();

//		if ( isset($settings['cache_mode']['templates'])
//		     && ! empty( $item['template'] )
//		     && in_array( $item['template'], $settings[ 'template_values' ] )
//		) {
			return $item['template'];
//		}
		return __( 'N/A', 'shortpixel-critical-css' );
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_status( array $item ) {
		$data = maybe_unserialize( $item['data'] );
		if ( ! empty( $data ) && ! empty( $data['status'] ) ) {
			if ( empty( $data['status'] ) ) {
				return __( 'Pending', 'shortpixel-critical-css' );
			}
			switch ( $data['status'] ) {
				case self::STATUS_PROCESSING:
					return __( 'Processing', 'shortpixel-critical-css' );
					break;
				default:
					return __( 'Pending', 'shortpixel-critical-css' );
			}
		} else {
			return __( 'Pending', 'shortpixel-critical-css' );
		}
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_actions( array $item ) {
		return '<button class="button button-primary spccss-api-action" data-action="web-run" data-id="' . $item['id'] . '"><span class="dashicons dashicons-controls-play"style="padding-top: 4px;"></span>Check</button>&nbsp;
                <button class="button button-link-delete spccss-api-action" data-action="web-remove" data-id="' . $item['id'] . '"><span class="dashicons dashicons-no"style="padding-top: 4px;"></span>Remove</button>';//. wp_send_json($item);
	}
}