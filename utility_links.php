<?php
$link_prefix = '/';

$link_to_admin_manage_staff = 'admin_manage_staff.php';
$link_to_admin_manage_content = 'admin_manage_content.php';
$link_to_admin = 'admin.php';
$link_to_admin_requests_on_register = 'admin_requests_on_register.php';

$link_to_styles = 'css/styles.css';
$link_to_files_styles = 'css/files.css';
$link_to_bootstrap_styles = 'css/bootstrap.min.css';
$link_to_animations_styles = 'css/animations.css';
$link_to_js = 'js/';
$link_to_classes = 'classes/';
$link_to_ckeditor = 'ckeditor/';

$link_to_articles_mod = 'articles';
$link_to_projects_mod = 'projects';
$link_to_directions_mod = 'directions';
$link_to_about_us_mod = 'about-us';
$link_to_contacts_mod = 'contacts';

$link_to_utility_authorization = 'utility_authorization.php';
$link_to_utility_interceptor = 'utility_interceptor.php';
$link_to_img_upload = 'imgupload.php';
$link_to_img_browse = 'imgbrowse.php';
$link_to_utility_lgmis_lib = 'ulitity_lgmis_lib.php';
$link_to_utility_languages = 'utility_languages.php';
$link_to_utility_language_change = 'utility_language_change.php';
$link_to_utility_links = 'utility_links.php';
$link_to_utility_sql_worker = 'utility_sql_worker.php';
$link_to_utility_defines = 'utility_defines.php';
$link_to_utility_download = 'utility_download.php';

$link_to_users_images = 'files/images/users/';
$link_to_article_images = 'files/images/articles/';
$link_to_direction_images = 'files/images/directions/';
$link_to_projects_images = 'files/images/projects/';
$link_to_service_images = 'files/images/service_images/';
$link_to_text_part_images = 'files/images/text_parts/';
$link_to_report_images = 'files/images/reports/';
$link_to_report_files = 'files/other/reports/';
$link_to_logo = 'files/images/service_images/Logo.png';
$link_to_files_manager_dir = 'files/file_manager/';

$link_to_element_templates = 'php_templates/element_templates.php';
$link_to_interfaces = 'classes/interfaces.php';
$link_to_user_class = 'classes/user.php';
$link_to_article_class = 'classes/article.php';
$link_to_direction_class = 'classes/direction.php';
$link_to_request_on_register_class = 'classes/requestonregister.php';
$link_to_project_class = 'classes/project.php';
$link_to_user_block_class = 'classes/userblock.php';
$link_to_text_part_class = 'classes/textpart.php';
$link_to_report_class = 'classes/report.php';
$link_to_error_class = 'classes/error.php';
$link_to_myfile_class = 'classes/myfile.php';

$link_to_public_article = 'public_article.php';
$link_to_index = 'index.php';
$link_to_public_direction = 'public_direction.php';
$link_to_public_user = 'public_user.php';
$link_to_public_project = 'public_project.php';
$link_to_about_us = 'public_about_us.php';
$link_to_contacts = 'public_contacts.php';

$link_to_admin_template = 'php_templates/admin_template.php';
$link_to_admin_menu_template = 'php_templates/admin_menu_template.php';
$link_to_pagination_init_template = 'php_templates/pagination_init_template.php';
$link_to_pagination_show_template = 'php_templates/pagination_show_template.php';
$link_to_registering_template = 'php_templates/admin_registering_template.php';
$link_to_admin_user = 'admin_user.php';
$link_to_admin_article = 'admin_article.php';
$link_to_admin_direction = 'admin_direction.php';
$link_to_admin_project = 'admin_project.php';
$link_to_admin_user_block = 'admin_user_block.php';
$link_to_admin_text_part = 'admin_text_part.php';
$link_to_admin_bookkeeping = 'admin_bookkeeping.php';
$link_to_admin_registration = 'admin_registration.php';
$link_to_admin_report = 'admin_report.php';
$link_to_admin_ajax_interceptor = 'admin_ajax_interceptor.php';
$link_to_admin_file_manager = 'admin_file_manager.php';

$link_to_public_template = 'php_templates/public_template.php';
$link_to_public_menu_template = 'php_templates/public_menu_template.php';
$link_to_public_footer_template = 'php_templates/public_footer_template.php';

class Link {
	public static function Get($_link) {
		global $use_mod_rewrite;
		global $link_prefix;

		if ($use_mod_rewrite === true) return $link_prefix.$_link;
		return $_link;
	}
}
?>