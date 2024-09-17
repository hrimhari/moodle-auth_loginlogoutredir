<?php

defined('MOODLE_INTERNAL') || die();

/**
 * Called when a signup form is about to be rendered. If a login redirection URL is configured then bring the user to
 * said URL once they have signed up and confirmed their account.
 */
function auth_loginlogoutredir_pre_signup_requests() {
    global $SESSION, $CFG;

    if (isset($CFG->loginredir)) {
        $SESSION->wantsurl = $CFG->loginredir;
    }
}