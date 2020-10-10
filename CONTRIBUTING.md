Documentation
=====

Intro:
-----
Welcome new head, tech director, or developer to the SCASi4 project! Started in May 2013, the i4 replaces the SCAS i3 and is used to log client contacts for the Small Claims Advisory Service.
This documentation is to serve as guidance for you to continue contributing to the project. Thanks for your service!

Getting Started:
-----
This will teach you to get started working on the i4 locally. Before getting started you should make a GitHub account, you should also talk to the previous tech director to add you as a collaborator on github.com/scasbot/i4 and to transfer the username and password for the bluehost.com account to you. Once those are done, follow these steps to make your first change to the i4!

1. If you don't already have an account, make one for github.com.
2. Make a fork of this repository and clone it by running `git clone https://github.com/USERNAME/i4` in your terminal. This makes a copy of the repository for you to work on locally.
3. Download MySQL [here](https://dev.mysql.com/downloads/mysql/) and start the MySQL server. If you're not familiar with MySQL, you can find its documentation [here](https://dev.mysql.com/doc/refman/8.0/en/).
4. Run the following commands in your terminal:

	```
	cd i4
	git checkout beta
	git pull origin beta
	mysql -u root -p
	```
	Enter the password you set up during configuration. Once in the MySQL command line tool run the following:
	```
	create database masmallc_scas;
	use masmallc_scas;
	source server/structure.sql
	exit
	```

5. Copy server/hash.json.example to server/hash.json. Edit hash.json so that database is masmallc_scas. The username should be `root` by default, and the password should be whatever you set during the installation of MySQL.
6. Start the local server by running `php -S localhost:8000` and opening [http://localhost:8000](http://localhost:8000) in your browser. You might have to run `ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';`, replacing password with the password you set if you get an error when running the server.
7. Open `templates/login_form.php` and change something that appears on the page. For example, you can change the placeholder for the login input to "Enter monkey's name..." or something like that. Verify the change in the browser.
8. Run in the terminal:
	```
	git status
	git commit -am "[YOUR NAME]'s first commit"
	git push origin master
	```
9. Open a pull request from your fork to the branch `beta` by going to the [upstream repository](https://github.com/scasBot/i4) and clicking new pull request. Merge it into beta.
10. SSH into the webserver, following the instructions in the next section. Go to `public_html/i4` and run the following:
	```
	git checkout beta
	git pull origin beta
	```

10. Now if you head to [i4.masmallclaims.org](i4.masmallclaims.org), you will see your changes! Woohoo!

11. So now you've made your first commit :) To make further changes to the i4, you should do the following:

* Read the rest of this documentation! This is serious!
* In order to be able to login in the local website, you must 'seed' the development database with information. You can either copy a sample of the data from the actual server (google how to copy mysql database) or you can just insert fake values into the development server. Remember the way to access mysql from the terminal is `mysql` and then `use masmallc_scas`. From there you will be able to use mysql commands as you learned in basic CS courses. Alternatively you can connect your development website to the real database on Bluehost (left up to you to figure out how - involves editing bluehost.com and hash.json in your development account).
	Here are some values to help you get started quickly - this creates a new user with the password `password`. The `>` character indicates that you'll enter the command within the MySQL command line interface.
	```
	$ mysql
	> use masmallc_scas;
	> INSERT INTO i3_Users (UserName, Email, YOG, Comper, Admin) 
		VALUES (
		NAME, EMAIL, YOG, 0, 1);
	> INSERT INTO i3_Passwords (UserID, hash)
		VALUES (
		1872, '$1$lY4gAXb8$XSasmifG6g1vuiekAhyLp/');
	```
* Learn about git and github, reading specifically about the commands: `status`, `log`, `commit`, `push`, `pull`, and `checkout`.
* If you ever need help, feel free to reach out to any of the previous tech directors; they will be happy to assist you (especially Willy)!

How to edit the server and the domain:
-----
URL:
*	i4.masmallclaims.org
*	The server is managed by Bluehost. To access the server and edit files on the server, you can ask the old executive directors or the old tech directors for the username and password. You should be able to run: "ssh USERNAME@masmallclaims.org" and type the password they give you when prompted. To learn about Bluehost, you can also login with the same credentials on bluehost.com and learn about managing things like the mysql database and the domain name.
* The location of the website is at ~/publi_html/i4

 HOW TO PUSH/PULL:
*	You have a number of options to push and pull from the server.
*	Currently the server is set up as a local repository to https://github.com/scasBot/i4.git (look at github section for more info). To update you can simply run "git pull" in the i4 directory.

 MYSQL:
*	The mysql database, likewise, is managed by bluehost. Passwords, username, database name etc., should be kept in a file called hash.json inside of /server, you can find an example of the structure of hash.json in server/hash.json.example. This file should be included in .gitignore.

GODADDY ACCOUNT:
*	SCAS also has a GoDaddy.com account which registers our domain name: masmallclaims.org. This is where forwarding (such as i4.masmallclaims.org) is set-up and where you can edit those. The login information should also be received by word-of-mouth.
*	We now also own scas.info, which we should be making more use of by the time you read this!

Version control and Github:
-----
 GITHUB:
*	The current code for the SCAS website is at https://github.com/scasBot/i4.git. You can go to that public repository. To become a collaborator, ask the current tech director!

 INVARIANTS/RULES:
*	Branches:
	+ There are two main branches to the git repository: beta and master. All development should occur on new development branches, this branch never synchronizes to bluehost servers and is used solely for code development. The beta branch should be pushed to for beta testing. On bluehost, doing a "git checkout beta" will deploy beta branch. Master should always be stable, tested code. After testing beta for a while, you can go back to the master branch and "git merge beta && git push origin master" to synchronize master with beta.
*	Necessary files that are ignored:
	+ server/hash.json does not appear in the git repository. Do NOT add or commit this and DO keep it in the .gitignore file. These include database and server passwords which should not be made public.

NOTE:
*	If you haven't used git before, you should really learn to use it! Google for information about it, but this will decrease development time significantly!

Structure of the i4 code:
-----
DIRECTORY STRUCTURE:
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

SERVER:
+ The server/ directory does not interact with browser accesses by the user. Instead, the server (which includes its own server_config.php file) runs periodic updates and other back-end tasks. To call these scripts, you should be able to use "php SOME_TASK_HERE.php" to run it.
+ Likewise the data/ directory has cached data from server/*.php calls and other methods.

API:
+ The html/api directory is a RESTful API. Look at READ_AUTH, WRITE_AUTH, and ACCESS_AUTH for what to provide. The api_config.php file should be included for all of the api uses.

Other things to keep in mind:
-----

CSS:
+ Done through bootstrap version 2.2.1. Not bootstrap 2.3! This is important to note as many things have changed!

JAVASCRIPT:
+ The core javascript library resides in html/js/scripts.js. There are also javascript "bots" that are used throughout the site. For example, all ajax calls should be filtered through the ajaxBot.sendAjax() function which can be found in ajaxBot.js. This provides some security features and is the interface for accessing items through the html/ajax.php page.

LIBRARIES:
+ The includes/libraries/ directory has multiple useful library functions. The most useful is probably data_class.php which allows you to quickly update the MySql database from post requests.

NOTE:
+ Small note on naming convention: inside of templates/, if one template has too much code so that it's not readable, you should use a php include to add in a sub-template. These sub-templates should be named MAINTEMPLATENAME_subtemplatename.php where MAINTEMPLATENAME is the name of the original template.

History:  
-----
For your reference, here is a history of the lead developers of the SCAS i4 project, and their releases.
+ Ife Omidiran    	omidiran@college.harvard.edu January 2019 - Present
+ David Xu	davidxu@college.harvard.edu	January 2016 - December 2016
+ Elton Lossner	eltonlossner@college.harvard.edu	January 2016 - December 2017
+ Chris Lim    	klim01@college.harvard.edu	January 2014 - December 2015	i4.2.0 - i4.2.1
+ Willy Xiao	willyxiao@gmail.com	May 2013 - December 2013	v4.1.0 - i4.1.1
