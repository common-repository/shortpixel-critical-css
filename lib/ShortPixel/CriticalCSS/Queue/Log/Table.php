<?php


namespace ShortPixel\CriticalCSS\Queue\Log;


use ShortPixel\CriticalCSS\API;
use ShortPixel\CriticalCSS\Queue\ListTableAbstract;

class Table extends ListTableAbstract {
	public function __construct( array $args = [] ) {
		parent::__construct( [
			'singular' => __( 'Processed Log Item', 'shortpixel-critical-css' ),
			'plural'   => __( 'Processed Log Items', 'shortpixel-critical-css' ),
			'ajax'     => false,
		] );
	}

	/**
	 * @return array
	 */
	public function get_columns() {
		$columns = [
			'url'       => __( 'URL', 'shortpixel-critical-css' ),
			'template'  => __( 'Template', 'shortpixel-critical-css' ),
			'post_type' => __( 'Post type', 'shortpixel-critical-css' ),
            'status'    => __( 'Status', 'shortpixel-critical-css' ),
            'updated'  => __( 'Updated', 'shortpixel-critical-css' ),
		];
		if ( is_multisite() ) {
			$columns = array_merge( [
				'blog_id' => __( 'Blog', 'shortpixel-critical-css' ),
			], $columns );
		}

		return $columns;
	}

	protected function get_bulk_actions() {
		return [];
	}

	protected function do_prepare_items() {
		$wpdb        = shortpixel_critical_css()->wpdb;
		$table       = $this->get_table_name();
		$this->items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} ORDER BY updated DESC LIMIT %d,%d", $this->start, $this->per_page ), ARRAY_A );
	}

	protected function get_table_name() {
		return shortpixel_critical_css()->log->get_table_name();
	}

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
		if ( ! empty( $item['template'] ) || ! empty( $item['post_type'] ) ) {
			return __( 'N/A', 'shortpixel-critical-css' );
		}

		return shortpixel_critical_css()->get_permalink( $item );
	}

	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_post_type( array $item ) {

		if ( ! empty( $item['post_type'] ) ) {
			return $item['post_type'];
		}

		return __( 'N/A', 'shortpixel-critical-css' );
	}
	/**
	 * @param array $item
	 *
	 * @return string
	 */
	protected function column_template( array $item ) {

		if ( ! empty( $item['template'] ) ) {
			return $item['template'];
		}

		return __( 'N/A', 'shortpixel-critical-css' );
	}

    /**
     * @param array $item
     *
     * @return string
     */
    protected function column_status( array $item ) {
        if ( ! empty( $item['data'] ) ) {
            $data = unserialize($item['data']);
            if (!empty($data['result_status']) && $data['result_status'] === 'EXPIRED') {
                return "EXPIRED";
            } else {
                $css = shortpixel_critical_css()->retrieve_cached_css($item);
                if($css->cache) {
                    if(!empty($data['result_status'])) {
                        $ret = $data['result_status'];
                        if(!empty($data['code'])) {
                            $shotsUrl = API::BASE_URL . 'screenshot/' . $data['code'] . '/';
                            $ret .= ' ( <a class="thickbox spccss-get" data-id="'. $item['id'] . '" href="">CSS</a> |'
                                .' <a class="spccss-screenshot" href="' . $shotsUrl . 'original.png" target="_blank">Original</a> | <a class="spccss-screenshot" href="' . $shotsUrl . 'critical.png" target="_blank">Critical</a> )';
                        }
                        return $ret;
                    }
                }
                else {
                    //Instead of just returning "EXPIRED" directly, updated the status in the database so it can
                    // be retrieved in another functions
                    $data['result_status'] = 'EXPIRED';
                    // re-Serialize the updated data
                    $serialized_data = serialize($data);
                    global $wpdb;
                    $table_name = $wpdb->prefix . 'shortpixel_critical_css_processed_items';
                    $wpdb->update(
                        $table_name,
                        ['data' => $serialized_data],
                        ['id' => $item['id']],
                        ['%s'],
                        ['%d']
                    );
                    return "EXPIRED";
                }
            }
        }
        return __( 'N/A', 'shortpixel-critical-css' );
    }

    /**
     * @param array $item
     *
     * @return string
     */
    protected function column_updated( array $item ) {

        if ( ! empty( $item['data'] ) ) {
            $data = unserialize($item['data']);
            if(!empty($data['updated'])) {
                $ret = $data['updated'];
                return $ret;
            }
        }

        return __( 'N/A', 'shortpixel-critical-css' );
    }

}