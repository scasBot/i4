<?php
require("../includes/config.php");
require("../includes/profile_class.php");

if (COMPER) {
	redirect(ROOT_PUBLIC);
}

function add_user_from_array($arr) {
	$comper = new Profile();
	$comper->from_array($arr);
	$comper->set("Hidden", 0);
	$comper->push();

	$password = new Password();
	$password->set("UserID", $comper->get_id());
	$password->set("hash", crypt("comper"));
	$password->push();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!empty($_POST["BatchData"])) {
		// split string into array of strings separated by newlines using str_getcsv
		// because str_csv does not recognize newlines as delimiting a row.
		$lines = str_getcsv($_POST["BatchData"], "\n");
		$delim = ",";

		$users = array_map(
			function(&$line) use ($delim) {
				return str_getcsv($line, $delim);
			},
			$lines
		);

		// create associative array using the first row of csv as keys
		array_walk($users, function(&$a) use ($users) {
			$a = array_combine($users[0], $a);
		});

		// remove headers
		array_shift($users);

		foreach ($users as $user) {
			add_user_from_array($user);
		}
	} else {
		if(empty($_POST["YOG"]) || empty($_POST["UserName"]) ||
			!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
			apologize("Sorry, information you entered was incorrect.");
		}

		add_user_from_array($_POST);
	}
}

render("add_user_form.php", array(
	"title" => "New Comper",
));
