* Verify migrations
	* create_forms
	* create_manifests
	* create_messages
	* create_missions
	* create_moderation
	* create_navigation
	* create_personal_logs
	* create_positions
	* create_posts
	* create_sessions
	* create_settings
	* create_sim_types
	* create_site_contents
	* create_system
	* create_users
	* create_wiki
	* create_forums
	* create_applications
* Cleanup and update models
	* Catalog\Module
		* Implement uninstall method
	* Catalog\Rank
		* Implement uninstall method
	* Catalog\Skin
		* Figure out how to connect it to Catalog\SkinSection
		* Implement install method
		* Implement uninstall method
	* Catalog\SkinSection
		* Figure out how to connect it to Catalog\Skin
	* Catalog\Widget
		* Implement install method
		* Implement uninstall method