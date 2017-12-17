<?php
add_action('admin_menu', 'trtitan_add_demo_importer');
function trtitan_add_demo_importer() {
	add_theme_page(esc_html__('Demo Importer', TRTHEME_LANG_DOMAIN), esc_html__('Demo Importer', TRTHEME_LANG_DOMAIN), 'administrator', 'trtitan-demo-importer', 'trtitan_demo_importer_page');
}

function trtitan_demo_importer_page() {
	global $trtitan_demo_importer_selfcheck, $trtitan_demo_importer_success;

	echo '<div class="wrap"><h1>'.esc_html__('Demo Content Importer', TRTHEME_LANG_DOMAIN).'</h1>';

	if (empty($_POST['trtitan_importing'])) {

		// welcome message
		echo '<p>' . esc_html__('Here you can import sample content with a single click!', TRTHEME_LANG_DOMAIN) . '<br /><br />
			'. __('<b>WARNING! The importing process will remove your existing posts, pages and media library!<br />
			It\'s recommended to use a fresh, clean wordpress install!</b>', TRTHEME_LANG_DOMAIN) . '</p>';

		// show button if no error were found in selfcheck
		if (empty($trtitan_demo_importer_selfcheck)) {
			echo '<form method="post">
				<input type="hidden" name="trtitan_importing" value="1" />
				<input type="submit" name="submit" id="submit" class="button button-primary" value="' . esc_attr__('Import Now!', TRTHEME_LANG_DOMAIN) . '"  />
				</form>';
		}

	} else {

		// user pressed the import button
		if (!empty($trtitan_demo_importer_success)) {

			//successful import
			echo '<p><b>' . __('Demo content has been successfully imported!', TRTHEME_LANG_DOMAIN) . '</p>';

		} else {

			//something went wrong
			echo '<p><b>' . __('ERROR! Something went wrong!', TRTHEME_LANG_DOMAIN) . '</p>';

		}

	}

	// error messages from webhosting check
	if (!empty($trtitan_demo_importer_selfcheck)) {

		echo '<h2 class="title">'.esc_html__('Whooops!', TRTHEME_LANG_DOMAIN).'</h2>					
			<p><b>'.esc_html__('One or more problems were found that needs to be fixed before the import!', TRTHEME_LANG_DOMAIN).'</b></p>					
			<ul>';

		foreach ($trtitan_demo_importer_selfcheck as $err) {
			echo '<li>&bull; '. $err .'</li>';
		}

		echo '</ul>';

	}

	echo '</div>';
}

add_action('init', 'trtitan_demo_import_init');
function trtitan_demo_import_init() {
	if ( !is_admin() ) { return false; }

	// webhosting permission and capability check
	if (empty($_POST['trtitan_importing']) && $_GET['page'] == 'trtitan-demo-importer' && current_user_can('administrator')) {

		// is allow_url_fopen setting on in php.ini?
		if (ini_get('allow_url_fopen') != '1' && ini_get('allow_url_fopen') != 'On') {

			$trtitan_demo_importer_selfcheck[] = esc_html__('The allow_url_fopen setting is turned off in the PHP ini!', TRTHEME_LANG_DOMAIN);

		} else {

			// can we read a file with wp filesystem?
			global $wp_filesystem;
			if (empty($wp_filesystem)) {
				require_once(ABSPATH . '/wp-admin/includes/file.php');
				WP_Filesystem();
			}

			if (!$wp_filesystem->get_contents(get_template_directory_uri().'/inc/importer/data.imp')) {

				$trtitan_demo_importer_selfcheck[] = esc_html__('The script couldn\'t read the data.imp file. Is it there? Does it have the permission to read?', TRTHEME_LANG_DOMAIN);

			}

		}

		// can we create directory?
		$uploads_dir = $wp_filesystem->abspath() . '/wp-content/uploads';
		if (!$wp_filesystem->is_dir($uploads_dir)) {
			if (!$wp_filesystem->mkdir($uploads_dir)) {

				$trtitan_demo_importer_selfcheck[] = esc_html__('The script couldn\'t create a directory!', TRTHEME_LANG_DOMAIN);

			}
		}

		// can we copy files?
		if (!$wp_filesystem->copy(get_template_directory().'/inc/importer/media/30.png	', $wp_filesystem->abspath() . '/wp-content/uploads/test.jpg')) {

			$trtitan_demo_importer_selfcheck[] = esc_html__('The script couldn\'t copy a file!', TRTHEME_LANG_DOMAIN);

		} else {

			$wp_filesystem->delete($wp_filesystem->abspath() . '/wp-content/uploads/test.jpg');

		}

		// can we read/write database?
		global $wpdb;
		if (!$wpdb->query('CREATE TABLE IF NOT EXISTS '.$wpdb->prefix.'testing (id mediumint(9) NOT NULL AUTO_INCREMENT, test varchar(255), UNIQUE KEY id (id))')) {

			$trtitan_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!', TRTHEME_LANG_DOMAIN);

		} else {

			if (!$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'testing')) {

				$trtitan_demo_importer_selfcheck[] = esc_html__('The script is not allowed to write MySQL database!', TRTHEME_LANG_DOMAIN);

			}

		}

	}


	// start importing
	if (false && !empty($_POST['trtitan_importing']) && $_GET['page'] == 'trtitan-demo-importer' && current_user_can('administrator')) {

		// copy all media files
		global $wp_filesystem;
		if (empty($wp_filesystem)) {
			require_once(ABSPATH . '/wp-admin/includes/file.php');
			WP_Filesystem();
		}

		$files = glob(get_template_directory().'/importer/media/*.*');
		foreach($files as $file) {
			if (!$wp_filesystem->copy($file, $wp_filesystem->abspath() . '/wp-content/uploads/' . basename($file))) {
				$trtitan_demo_importer_error = '1';
			}
		}

		// clear tables
		global $wpdb;
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'comments');
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'postmeta');
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'posts');
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_relationships');
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_taxonomy');
		$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'terms');

		// read SQL dump and process each statement
		$data = $wp_filesystem->get_contents(get_template_directory_uri().'/importer/data.imp');
		$sql = explode('<cooltheme_sep>', $data);
		$current_url = get_site_url();

		foreach ($sql as $statement) {

			if (!empty($statement)) {

				// replace default wp prefix to user's choice if it's not the default one
				if (strstr($statement,'wp_comments') && $wpdb->prefix != 'wp_') {
					$statement = str_replace('wp_comments',$wpdb->prefix.'comments',$statement);
				}

				if (strstr($statement,'wp_postmeta')) {
					if ($wpdb->prefix != 'wp_') {
						$statement = str_replace('wp_postmeta',$wpdb->prefix.'postmeta',$statement);
					}
					// also replace all our sample paths to the user's actual path
					$statement = str_replace('http://localhost/cooltheme',$current_url,$statement);
				}

				if (strstr($statement,'wp_posts')) {
					if ($wpdb->prefix != 'wp_') {
						$statement = str_replace('wp_posts',$wpdb->prefix.'posts',$statement);
					}
					// also replace all our sample paths to the user's actual path
					$statement = str_replace('http://localhost/cooltheme',$current_url,$statement);
				}

				if (strstr($statement,'wp_term_relationships') && $wpdb->prefix != 'wp_') {
					$statement = str_replace('wp_term_relationships',$wpdb->prefix.'term_relationships',$statement);
				}

				if (strstr($statement,'wp_term_taxonomy') && $wpdb->prefix != 'wp_') {
					$statement = str_replace('wp_term_taxonomy',$wpdb->prefix.'term_taxonomy',$statement);
				}

				if (strstr($statement,'wp_terms') && $wpdb->prefix != 'wp_') {
					$statement = str_replace('wp_terms',$wpdb->prefix.'terms',$statement);
				}

				// run the query
				if (!$wpdb->query($statement)) {
					$trtitan_demo_importer_error = '1';
				}

			}

		}

		// navigation, widgets, other settings
		if (empty($trtitan_demo_importer_error)) {
			update_option('option_name','option_value');
			update_option('option_name',unserialize('serialized_option_value'));
		}

		// if everything went well
		if (empty($trtitan_demo_importer_error)) {
			$trtitan_demo_importer_success = '1';
		}

	}

}
