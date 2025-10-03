<?php
/**
 * Plugin Name: Git Update
 * Description: Example plugin with direct GitHub updates (no external libraries).
 * Version: 1.2.7
 * Author: Sudip
 * Plugin URI: https://github.com/sudipgit/git-update
 */
 
 
/* Change Log:
    v1.2.7    ccv fdsgsfdhggh sdfgs
    v1.2.6    ccv fdsgs sdfgs
    v1.2.5    twiks some issues  ccv fdsgs sdfgs
    v1.2.4    twiks some issues fdsgs sdfgs
    v1.2.3    twiks some issues
    v1.2.2    Fixed other some issues
    v1.2.1    Fixed some issues
    v1.2.0    Update format
    v1.1.1    Initial release
          
   
*/

// =============== CONFIG ===============
define('MY_PLUGIN_SLUG', 'git-update/git-update.php'); // folder/file name
define('MY_PLUGIN_GITHUB_USER', 'sudipgit');
define('MY_PLUGIN_GITHUB_REPO', 'git-update');
define('MY_PLUGIN_VERSION', '1.2.7');
// ======================================



// 1. Check for updates
add_filter('pre_set_site_transient_update_plugins', function($transient) {
    if (empty($transient->checked)) return $transient;

    $remote = wp_remote_get("https://api.github.com/repos/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO."/releases/latest");
    if (is_wp_error($remote)) return $transient;

    $release = json_decode(wp_remote_retrieve_body($remote));
    if (!isset($release->tag_name)) return $transient;

    $latest_version = preg_replace('/[^0-9.]/', '', $release->tag_name); // safe parsing
    $plugin_data = get_plugin_data(WP_PLUGIN_DIR . '/' . MY_PLUGIN_SLUG);

    if (version_compare($latest_version, $plugin_data['Version'], '>')) {
        $transient->response[MY_PLUGIN_SLUG] = (object)[
            'slug'        => dirname(MY_PLUGIN_SLUG),
            'new_version' => $latest_version,
            'url'         => "https://github.com/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO,
            'package'     => "https://github.com/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO."/releases/download/{$release->tag_name}/git-update.zip",
        ];
    }

    return $transient;
});

// 2. Plugin info screen
add_filter('plugins_api', function($res, $action, $args) {
    if ($action !== 'plugin_information') return $res;
    if ($args->slug !== dirname(MY_PLUGIN_SLUG)) return $res;

    $remote = wp_remote_get("https://api.github.com/repos/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO."/releases/latest");
    if (is_wp_error($remote)) return $res;

    $release = json_decode(wp_remote_retrieve_body($remote));

    return (object)[
        'name'          => 'Git Update',
        'slug'          => dirname(MY_PLUGIN_SLUG),
        'version'       => preg_replace('/[^0-9.]/', '', $release->tag_name),
        'author'        => '<a href="https://github.com/'.MY_PLUGIN_GITHUB_USER.'">'.MY_PLUGIN_GITHUB_USER.'</a>',
        'homepage'      => "https://github.com/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO,
        'download_link' => "https://github.com/".MY_PLUGIN_GITHUB_USER."/".MY_PLUGIN_GITHUB_REPO."/releases/download/{$release->tag_name}/git-update.zip",
        'sections'      => [
            'description' => $release->body ?? 'No description available.',
        ],
    ];
}, 10, 3);

// Footer
add_action('wp_footer', function(){
    echo 'This is version ' . MY_PLUGIN_VERSION;
});
