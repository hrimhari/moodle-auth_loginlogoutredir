<?php
require_once($CFG->libdir.'/authlib.php');

class auth_plugin_loginlogoutredir extends auth_plugin_base {
    /**
     * Constructor.
     */
    function auth_plugin_loginlogoutredir() {
        $this->authtype = 'loginlogoutredir';
        $this->config = get_config('auth/loginlogoutredir');
    }

    function user_authenticated_hook($user, $username, $password) {
		global $CFG, $SESSION;
		if ($CFG->loginredir) {
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
		if ($CFG->logoutredir) {
			$redirect = $CFG->logoutredir;
		}
		else {
			error_log("'logoutredir' not set in config.php. Not redirecting.");
		}
    }
}

?>
