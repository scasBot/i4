<?php
require("../includes/config.php");
require("../includes/profile_class.php");

if (COMPER) {
	redirect(ROOT_PUBLIC);
}

function add_user_from_array($arr) {
	$user = new Profile();
	$user->from_array($arr);
	$user->set("Hidden", 0);
	if ($user->get("Comper") == null) {
		$user->set("Comper", 0);
	}
	$user->push();

	$password = new Password();
	$password->set("UserID", $user->get_id());
	$password->set("hash", crypt("comper"));
	$password->push();
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {
	// Now supports batch adding users.
	// Format should be a CSV with a header field that matches db fields
	// (i.e. UserName, Email, YOG, Comper) and each row should be separated by
	// newlines.
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
	"title" => "New User",
));
