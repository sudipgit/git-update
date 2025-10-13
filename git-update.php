<?php
/**
 * Plugin Name: Git Update
 * Description: Example plugin with direct GitHub updates (no external libraries).
 * Version: 1.3.1
 * Author: Sudip
 * Plugin URI: https://github.com/sudipgit/git-update
 */
 
 
/* Change Log:
    v1.3.1    ccdv  sdfgsg  d tgrhb 
    v1.3.0    ccdv  sdfgsg tgrhb 
    v1.2.9    ccdv  sdfgsrt
    v1.2.8    ccv  sdfgs tr
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



//Github connectivity
if( ! class_exists( 'MY_Plugin_Updater' ) ){
    include_once( plugin_dir_path( __FILE__ ) . 'updater.php' );
}


$access_token = '';

$updater = new MY_Plugin_Updater( __FILE__ );
$updater->set_username( 'sudipgit' );
$updater->set_repository( 'git-update' );
$updater->authorize($access_token);
$updater->initialize();

