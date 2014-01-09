<?php

require("api_config.php"); 

if(!isset($data["API_READ_AUTH"]) || $data["API_READ_AUTH"] != API_READ_AUTH) {
	error("Unauthorized access."); 
}

$stats = array(); 

// Contacts per client
$results = query("SELECT COUNT(*)/COUNT(DISTINCT ClientID) AS res FROM (SELECT ClientID FROM db_Contact UNION ALL SELECT ClientID FROM dbi4_Contacts) AS tmp"); 
$stats["contacts_per_client"] = $results[0]["res"]; 
// Users per client
$results = query("SELECT AVG(user_count) AS res FROM (SELECT COUNT(DISTINCT user) AS user_count FROM (SELECT ClientID, UserID AS user FROM db_Contact UNION ALL SELECT ClientID, UserAddedID AS user FROM dbi4_Contacts UNION ALL SELECT ClientID, UserEditID AS user FROM dbi4_Contacts) AS tmp WHERE ClientID != 0 GROUP BY ClientID) AS tmp2"); 
$stats["users_per_client"] = $results[0]["res"];
 
// Members
$results = query("SELECT COUNT(*) AS res FROM i3_Users WHERE UserName != ''"); 
$stats["members"] = $results[0]["res"]; 
// Current members
$results = query("SELECT COUNT(*) AS res FROM i3_Users WHERE YOG >= IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()) + 1, YEAR(CURDATE()))"); 
$stats["current_members"] = $results[0]["res"]; 
// Current members by grade
$results = query("SELECT COUNT(*) AS members, YOG FROM i3_Users WHERE YOG >= IF(MONTH(CURDATE()) >= 7, YEAR(CURDATE()) + 1, YEAR(CURDATE())) GROUP BY YOG"); 
$stats["current_members_by_grade"] = $results; 
 
// Clients
$results = query("SELECT COUNT(*) AS res FROM db_Clients");
$stats["clients"] = $results[0]["res"]; 
// Clients assisted
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99) UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99)) AS tmp"); 
$stats["clients_assisted"] = $results[0]["res"]; 
// Clients assisted by phone
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID IN (12,20,24,90,91,93) UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID IN (12,20,24,90,91,93)) AS tmp");
$stats["clients_assisted_by_phone"] = $results[0]["res"]; 
// Clients assisted by voicemail
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 10 UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 10) AS tmp");
$stats["clients_assisted_by_voicemail"] = $results[0]["res"];  
// Clients assisted by e-mail
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 16 UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 16) AS tmp");
$stats["clients_assisted_by_email"] = $results[0]["res"];
// Clients assisted by appointment
$results = query("SELECT COUNT(*) AS res FROM (SELECT DISTINCT ClientID FROM db_Contact WHERE ContactTypeID = 30 UNION SELECT DISTINCT ClientID FROM dbi4_Contacts WHERE ContactTypeID = 30) AS tmp");
$stats["clients_assisted_by_appointment"] = $results[0]["res"]; 

// Clients by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts) AS tmp GROUP BY year");
$stats["clients_by_year"] = $results; 
// Clients assisted by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99) UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99)) AS tmp GROUP BY year");
$stats["clients_assisted_by_year"] = $results; 
// Clients assisted by phone by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact WHERE ContactTypeID IN (12,20,24,90,91,93) UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts WHERE ContactTypeID IN (12,20,24,90,91,93)) AS tmp GROUP BY year");
$stats["clients_assisted_by_phone_by_year"] = $results; 
// Clients assisted by voicemail by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact WHERE ContactTypeID = 10 UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts WHERE ContactTypeID = 10) AS tmp GROUP BY year");
$stats["clients_assisted_by_voicemail_by_year"] = $results; 
// Clients assisted by e-mail by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact WHERE ContactTypeID = 16 UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts WHERE ContactTypeID = 16) AS tmp GROUP BY year");
$stats["clients_assisted_by_email_by_year"] = $results; 
// Clients assisted by appointment by year
$results = query("SELECT COUNT(*) AS clients, year FROM (SELECT DISTINCT ClientID, YEAR(Date) AS year FROM db_Contact WHERE ContactTypeID = 30 UNION SELECT DISTINCT ClientID, YEAR(ContactDate) AS year FROM dbi4_Contacts WHERE ContactTypeID = 30) AS tmp GROUP BY year");
$stats["clients_assisted_by_appointment_by_year"] = $results; 

// Clients assisted per member
$results = query("SELECT COUNT(DISTINCT ClientID)/COUNT(DISTINCT user) AS res FROM (SELECT ClientID, UserID AS user FROM db_Contact WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99) UNION SELECT DISTINCT ClientID, UserAddedID AS user FROM dbi4_Contacts WHERE ContactTypeID IN (10,12,16,20,24,30,90,91,93,99)) AS tmp");
$stats["clients_assisted_per_member"] = $results[0]["res"]; 

/* 
// ZIP breakdown
SELECT COUNT(*), ZIP FROM db_Demographics WHERE LENGTH(ZIP) = 5 GROUP BY ZIP
// Household size breakdown
SELECT COUNT(*), SizeHousehold FROM db_Demographics WHERE SizeHousehold IS NOT NULL GROUP BY SizeHousehold
// Household income breakdown
SELECT COUNT(*), HouseholdIncome FROM db_Demographics WHERE HouseholdIncome IS NOT NULL GROUP BY HouseholdIncome
// Race breakdown
SELECT COUNT(*), Race FROM db_Demographics WHERE Race IS NOT NULL AND Race != '' GROUP BY Race
// Gender breakdown
SELECT COUNT(*), Gender FROM db_Demographics WHERE Gender IS NOT NULL AND Gender != '' GROUP BY Gender
// Age breakdown
SELECT COUNT(*), Age FROM db_Demographics WHERE Age IS NOT NULL GROUP BY Age
// Public Assist breakdown
SELECT COUNT(*), PublicAssist FROM db_Demographics WHERE PublicAssist IS NOT NULL GROUP BY PublicAssist

// Appointments
SELECT COUNT(*) FROM db_Appointments WHERE MetWith = 1
// Appointments by year
SELECT COUNT(*), YEAR(Date) AS year FROM db_Appointments WHERE MetWith = 1 GROUP BY year
*/
echo json_encode($stats); 

?>