<?php

/**
 * The class takes the following arguments
 * * $hook - the hook of the 'parent' (menu top-level page).
 * * $title - the browser window title of the page
 * * $title - the page title as it appears in the menu
 * * $permissions - the capability a user requires to see the page
 * * $slug - a slug identifier for this page
 * * $body_content_cb -(optional) a callback that prints to the page, above the metaboxes. See the tutorial for more details.
 *
 * Example use
 * $my_admin page = new ODS_Dashboard_Page('my_hook','My Admin Page','My Admin Page', 'manage_options','my-admin-page')
 *
 * Full example below the class (which adds example metaboxes too).
 */

class ODS_Dashboard_Page
{
	var $hook;
	var $title;
	var $menu;
	var $permissions;
	var $slug;
	var $page;
	/**
	 * Constructor class
	 *@param $hook - (string) parent page hook
	 *@param $title - (string) the browser window title of the page
	 *@param $menu - (string)  the page title as it appears in the menuk
	 *@param $permissions - (string) the capability a user requires to see the page
	 *@param $slug - (string) a slug identifier for this page
	 *@param $body_content_cb - (callback)  (optional) a callback that prints to the page, above the metaboxes. See the tutorial for more details.
	 */
	function __construct($hook, $title, $menu, $permissions, $slug, $body_content_cb = '__return_true')
	{
		$this->hook = $hook;
		$this->title = $title;
		$this->menu = $menu;
		$this->permissions = $permissions;
		$this->slug = $slug;
		$this->body_content_cb = $body_content_cb;
		/* Add the page */
		add_action('admin_menu', array($this, 'add_page'));
	}
	/**
	 * Adds the custom page.
	 * Adds callbacks to the load-* and admin_footer-* hooks
	 */
	function add_page()
	{
		/* Add the page */
		$this->page = add_submenu_page($this->hook, $this->title, $this->menu, $this->permissions, $this->slug,  array($this, 'render_page'), 10);
		/* Add callbacks for this screen only */
		add_action('load-' . $this->page,  array($this, 'page_actions'), 9);
		add_action('admin_footer-' . $this->page, array($this, 'footer_scripts'));
	}
	/**
	 * Prints the jQuery script to initiliase the metaboxes
	 * Called on admin_footer-*
	 */
	function footer_scripts()
	{
?>
		<script>
			postboxes.add_postbox_toggles(pagenow);
		</script>
	<?php
	}
	/*
	* Actions to be taken prior to page loading. This is after headers have been set.
        * call on load-$hook
	* This calls the add_meta_boxes hooks, adds screen options and enqueues the postbox.js script.   
	*/
	function page_actions()
	{
		do_action('add_meta_boxes_' . $this->page, null);
		do_action('add_meta_boxes', $this->page, null);
		/* User can choose between 1 or 2 columns (default 2) */
		//add_screen_option('layout_columns', array('max' => 2, 'default' => 2) );
		/* Enqueue WordPress' script for handling the metaboxes */
		wp_enqueue_script('postbox');
	}
	/**
	 * Renders the page
	 */
	function render_page()
	{
	?>
		<div class="wrap">

			<h1> <?php echo esc_html($this->title); ?> </h1>

			<form name="my_form" method="post">
				<input type="hidden" name="action" value="some-action">
				<?php wp_nonce_field('some-action-nonce');
				/* Used to save closed metaboxes and their order */
				wp_nonce_field('meta-box-order', 'meta-box-order-nonce', false);
				wp_nonce_field('closedpostboxes', 'closedpostboxesnonce', false); ?>


				<div id="dashboard-widgets-wrap">
					<div id="dashboard-widgets" class="metabox-holder odsa-metabox-holder">
						<div id="postbox-container-1" class="postbox-container"><?php do_meta_boxes('', 'core', null);  ?>
						</div>
						<div id="postbox-container-2" class="postbox-container"><?php do_meta_boxes('', 'normal', null); ?>
						</div>
						<div id="postbox-container-3" class="postbox-container"><?php do_meta_boxes('', 'side', null); ?>
						</div>
						<div id="postbox-container-4" class="postbox-container"><?php do_meta_boxes('', 'advanced', null); ?>
						</div>
						<div id="post-body-content"><?php call_user_func($this->body_content_cb); ?></div>

					</div> <!-- dashboard-widgets-wrap -->

			</form>

		</div><!-- .wrap -->
<?php
	}
}

// END CLASS