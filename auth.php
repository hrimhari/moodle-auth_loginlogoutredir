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

    /**
     * Returns true if the username and password work and false if they are
     * wrong or don't exist.
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    function user_login ($username, $password) {
        global $CFG, $DB;
        return false;
    }

    function user_authenticated_hook(&$user, $username, $password) {
		global $CFG, $SESSION;


		if (!isset($CFG->loginredir)) {
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
		} else {
			if (array_key_exists("redirect_to_course",$_REQUEST)) {
				if ($_REQUEST["redirect_to_course"]) {
					$courseid = clean_param($_REQUEST["redirect_to_course"], PARAM_RAW);
					if (true || !isset($SESSION->wantsurl)) {
						$SESSION->wantsurl = $CFG->wwwroot . '/' . "course/view.php?id=$courseid";
					}
					else {
						error_log("Not redirecting to course '$courseid': came from other page '$SESSION->wantsurl'");
					}
				}
			} else {             
                      if (!array_key_exists("lp", $_REQUEST)) {
                          
                          // encrypts the user moodle id to get terms acceptance from LP
                          $uid = base64_encode(strval($user->id) . "hardfun");
                          $link = $CFG->landingpage_url . "/students/" . $uid . "/optin";
                          $data = json_decode(file_get_contents($link), true);
                          
                          // Redirects to LP if terms not accepted
                          if ($data['id'] != '' && $data['terms'] != 1) {
                            //redirect($CFG->landingpage_url . '?exec=login-e-termos');
                            
                            $crypt = $password . strval(rand(10, 99));
                            $crypt = base64_encode($crypt);
                            $crypt = 'zwpnb' . strrev($crypt) . 'ec';
                            $crypt = base64_encode($crypt);
                            redirect($CFG->landingpage_url . "/students/" . $uid . "/moodle_login?from_moodle=" . strrev($crypt));
                          }
                      }

                  }
		}
		return true;
    }

    function logoutpage_hook() {
  		global $CFG;
  		global $redirect;
  		if (isset($CFG->logoutredir)) {
  			if ($CFG->logoutredir) {
  				$redirect = $CFG->logoutredir;
  			} else {
  				error_log("'logoutredir' not set in config.php. Not redirecting.");
  			}
  		}
    }
}

?>
