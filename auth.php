<?php
require_once($CFG->libdir.'/authlib.php');

class auth_plugin_loginlogoutredir extends auth_plugin_base {
    /**
     * Constructor.
     */
    function __construct() {
        $this->authtype = 'loginlogoutredir';
        $this->config = get_config('auth/loginlogoutredir');
    }
    
    /*
     * Must override or an error is printed.
     * @return boolean False means login was not a success.
     */
    function user_login($username, $password) {
        false;
    }

    function user_authenticated_hook(&$user, $username, $password) {
		global $CFG, $SESSION;
		if (isset($CFG->loginredir) && $CFG->loginredir) {
			$urltogo = $CFG->loginredir;
			if (true || !isset($SESSION->wantsurl)) {
				$SESSION->wantsurl = $urltogo;
			}
			else {
				error_log("Not redirecting to '$urltogo': came from other page '$SESSION->wantsurl'");
			}
		}
		else {
			error_log("'loginredir' not set in config.php. Not redirecting.");
		}
		return true;
    }

    function logoutpage_hook() {
		global $CFG;
		global $redirect;
		if (isset($CFG->logoutredir) && $CFG->logoutredir) {
			$redirect = $CFG->logoutredir;
		}
		else {
			error_log("'logoutredir' not set in config.php. Not redirecting.");
		}
    }
}

?>
