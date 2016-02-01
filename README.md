# wptools
Set of bash tools for initializing and deploying Wordpress sites

Current tools included:
* wpinit - site initialization script
* wploy - site deployment script

**First, to get these scripts to work, you must have a couple of things:**
* JQ installed on local system (homebrew install: brew install jq)
* WP-CLI installed on local system (for installing Wordpress and other commands)
* WP-CLI installed on production host (for activating the Code Freeze plugin when pulling from production to staging)

## wpinit

After copying wptools to your system, copy the wpinit.config.sample file to a file simply called wpinit.config

For list of available wpinit commands, do:
```
wpinit -h
```

### New Site
For each project, wpinit uses a short, descriptive project identifier. This should be whatever you want the main directory for your site to be called. All directories, databases and usernames will be based off of the project id for the sake of automation.

To initialize a new site, use the following command:
```
wpinit new project_id
```

Without any parameters set for the wordpress username, password or production domain name, the "new" command automatically generates these for you - a string of 10 random characters for the username, a string of 32 random characters for the password and then the domain is set to project_id.local_url_base.

You can set your own parameters for the "new" command by doing:
```
wpinit new project_id -d test.com -u test_admin -p Password01
```

#### Test Site
To create a test site (mostly useful for making sure everything is set up correctly), you can run:
```
wpinit new project_id -t
```
This operation won't set up your wploy configuration, site plugins, terminal shortcut or editor (SublimeText, etc.) project or run any custom functions set in the wpinit.config file.

## wploy

For list of available wploy commands, do:
```
wploy -h
```
