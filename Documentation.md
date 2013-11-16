Documentation
=====

Intro: 
_____
* Welcome new head, tech director, or developer to the SCASi4 project! Started in May 2013, the i4 replaces the SCAS i3 and is used to log client contacts for the Small Claims Advisory Service. 
* This documentation is to serve as guidance for you to continue contributing to the project. I hope this is helpful for anyone hoping to help this organization. Thanks!

How to edit the server and the domain:
_____
* URL: 
	+ i4.masmallclaims.org -> hcs.harvard.edu/~scas/i4

	+ The server is managed by the Harvard Computer Society. To access the server and edit files, you have to first ask HCS to give your fas.harvard.edu account permission to access the SCAS user. Then ssh into your fas.harvard.edu account (this requires an ssh client such as putty on Windows). Once you log into your fas account you can run "ssh scas@hcs.harvard.edu" to edit the server. 
	+ The location of the website is at ~/web/i4

* HOW TO PUSH/PULL: 
	+ You have a number of options to push and pull from the server. 
	+ Currently the server is set up as a local repository to https://github.com/willyxiao/i4.git (look at github section for more info). To update you can simply run "git pull" in the i4 directory. 
	+ Alternatively you can use scp/pscp to push and pull through ssh clients. 

* MYSQL: 
	+ The mysql database, likewise, is managed by the Harvard Computer Society. To edit, you can go to http://hcs.harvard.edu/phpmyadmin. The login and password information should be received by word-of-mouth from previous developers of the project.

* GODADDY ACCOUNT: 
	+ SCAS also has a GoDaddy.com account which registers our domain name: masmallclaims.org. This is where forwarding (such as i4.masmallclaims.org) is set-up and where you can edit those. The login information should also be received by word-of-mouth.

Version control and Github:
_____
* GITHUB: 
	+ The current code for the SCAS website is at https://github.com/willyxiao/i4.git. You can go to that public repository. To become a collaborator, ask Willy!

* INVARIANTS/RULES: 
	+ Releases: 
		- At the end of every semester, the tech director should issue a new "release" of the SCAS i4 by creating a git tag. The current method is for the fall semester to be release v4.x.0 and the spring to be release v4.x.1. In these releases, the "x" represents an incremented variable from the previous year; so in year 1, the relase is v4.1.0, v4.1.1. Then the next year, the releases will be v4.2.0 and v4.2.1. 
	+ Branches: 
		- There are three main branches to the git repository: alpha, beta, and master. All development should occur on alpha, this branch never synchronizes to hcs servers and is used solely for code development. The beta branch should be pushed to for beta testing. On the hcs server, doing a "git checkout beta" will deploy beta branch. Master should always be stable, tested code. 
	+ Necessary files that are ignored:
		- server/constants_passwords.php does not appear in the git repository. Do NOT add or commit this and keep it in the .gitignore file. These include database and server passwords which should not be made public.

* NOTE: 
	+ If you haven't used git before, you should really learn to use it! Google for information about it, but this will decrease development time significantly!

Structure of the i4 code: 
_____
* DIRECTORY STRUCTURE: 
	+ The html/ directory should be the only publicly accessible directory on the i4. This means hcs.harvard.edu/~scas/html/* should be the only regex expression that is allowed to be accessed on the server. Then the html directory's php files will serve as handlers for the rest of the files. 
	+ Each page inside of html/ should include "config.php". This file includes the boiler plate for libraries, it starts php_sessions, and it ensures that anyone accessing a page on the i4 is logged in and has rights. If you do NOT include this and instead write your own boiler plates at the top, there may be a SECURITY FLAW.
	+ Because html/ is the only globally accessible directory, all resources have to be in here. For example html/css/, html/js/, html/img/ etc., 
	
	+ How handling works: 
		- So pages within html/ should be the pages performing all calculations, queries to the database, and handling. Then for a majority of the time, it should be including files inside of templates/ to generate the html of pages. Look at the includes/functions_navigation.php file for the "render" function. This is a great way to understand how the site functions. 

	+ Note: 
		- The ajax.php page is a global page for all ajax requests. Then, the main logic of the ajax request should go inside a file in ajax/ajax_*.php. These ajax calls to the SCAS i4 should all be done through the ajaxBot.js handler (look at .js files for more explanation).

	+ Note: 
		- The includes/ directory is where all commonly used function definitions should go. 
		- The includes/libraries/ are global libraries which can be used not just within the SCASi4 context but for any website. Look at includes/libraries/ALL.php for an explanation.

	+ This file structure is taken from CS50's 2012 Problem Set 7. For more information, go to cs50.net. 
	
* SERVER:
	+ The server/ directory does not interact with browser accesses by the user. Instead, the server (which includes its own server_config.php file) runs periodic updates and other back-end tasks. To call these scripts, you should be able to use "php SOME_TASK_HERE.php" to run it. It would be best to automate these using a CRON job, but since August 2013 that has been down from HCS.
	+ Likewise the data/ directory has cached data from server/*.php calls and other methods.
		
Other things to keep in mind: 
_____
* CSS: 
	+ Done through bootstrap version 2.2.1. Not bootstrap 2.3! This is important to note as many things have changed!

* JAVASCRIPT: 
	+ The core javascript library resides in html/js/scripts.js. There are also javascript "bots" that are used throughout the site. For example, all ajax calls should be filtered through the ajaxBot.sendAjax() function which can be found in ajaxBot.js. This provides some security features and is the interface for accessing items through the html/ajax.php page.
	
* LIBRARIES:
	+ The includes/libraries/ directory has multiple useful library functions. The most useful is probably data_class.php which allows you to quickly update the MySql database from post requests.
	
* NOTE: 
	+ Small note on naming convention: inside of templates/, if one template has too much code so that it's not readable, you should use a php include to add in a sub-template. These sub-templates should be named MAINTEMPLATENAME_subtemplatename.php where MAINTEMPLATENAME is the name of the original template.

For your reference, here is a history of the lead developers of the SCAS i4 project, and their releases. 
_____
* Willy Xiao	willy@chenxiao.us	May 2013 - December 2013	v4.1.0 - v4.1.1
	
