<?php 
header('Content-Type: text/javascript; charset=UTF-8');
//info: construct path to wp-load.php and get $wp_path
while(!is_file('wp-load.php')){
  if(is_dir('../')) chdir('../');
  else die('Error: Could not construct path to wp-load.php - please check <a href="http://mapsmarker.com/path-error">http://mapsmarker.com/path-error</a> for more details');
}
include( 'wp-load.php' );
$lmm_options = get_option( 'leafletmapsmarker_options' );
if (!is_multisite()) { $adminurl = admin_url(); } else { $adminurl = get_admin_url(); }
$LEAFLET_PLUGIN_URL = isset($_GET['leafletpluginurl']) ? $_GET['leafletpluginurl'] : ''; 

if ( isset($lmm_options['misc_tinymce_button']) && ($lmm_options['misc_tinymce_button'] == 'enabled') ) {
	echo "
	(function($) {
		tinymce.create('tinymce.plugins.mm_shortcode', {
			init : function(ed, url) {
				function open_map() {
									ed.windowManager.open({
											title : 'Insert map',
						file : '".$adminurl."admin-ajax.php?action=get_mm_list',
						width : 450 + parseInt(ed.getLang('example.delta_width', 0)),
						height : 440 + parseInt(ed.getLang('example.delta_height', 0)),
											inline: 1
					})
				}
				$('#globe').live('click', function(){
			   
				  open_map();
				   return false;
				});
			  
				ed.addCommand('mm_shortcode', function(){
				open_map();
				});
				ed.addButton('mm_shortcode', {title : '" . __('Insert map','lmm') . "', cmd : 'mm_shortcode', image: '".$LEAFLET_PLUGIN_URL."inc/img/icon-menu-page.png' });
			},
			createControl : function(n, cm) {
				return null;
			}
		});
		tinymce.PluginManager.add('mm_shortcode', tinymce.plugins.mm_shortcode); 
		$('#wp-content-media-buttons').append('<a id = globe href=#><img src=".$LEAFLET_PLUGIN_URL."inc/img/icon-menu-page.png></a>');
	
		})(jQuery);
	"; 
}
?>