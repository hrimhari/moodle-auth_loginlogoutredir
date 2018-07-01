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

    function user_authenticated_hook(&$user, $username, $password) {
		global $CFG, $SESSION;

		if(!isset($CFG->loginredir)) {
			$CFG->loginredir = false;
		}

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
			
			if($_REQUEST["redirect_to_course"]) {
				$courseid = clean_param($_REQUEST["redirect_to_course"], PARAM_RAW);
				if (true || !isset($SESSION->wantsurl)) {
					$SESSION->wantsurl = $CFG->wwwroot.'/'."course/view.php?id=$courseid";
				}
				else {
					error_log("Not redirecting to course '$courseid': came from other page '$SESSION->wantsurl'");
				}
			} 
		}
		return true;
    }

    function logoutpage_hook() {
		global $CFG;
		global $redirect;
		if(isset($CFG->logoutredir)) {
			if ($CFG->logoutredir) {
				$redirect = $CFG->logoutredir;
			} else {
				error_log("'logoutredir' not set in config.php. Not redirecting.");
			}
		}
    }
}

?>
