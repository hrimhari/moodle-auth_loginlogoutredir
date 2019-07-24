moodle-auth_loginlogoutredir
============================

Allows you to redirect a user both on login and logout in moodle.

Usage
-----

Set the following options in your Moodle Configuration (config.php):

```
$CFG->loginredir = "{$CFG->wwwroot}/plus/some/different/path";
$CFG->logoutredir = "Any URL you want";
```

Create the folder ```auth/loginlogoutredir``` below your moodle directory.
Either checkout this repository or copy the files from the released files.


* Enable Plugin via Site Administration --> Plugins --> Authentication --> Manage Authentication
* Enable "Login/Logout user redirection".

Afterwards the redirect on login and logout will happen.
