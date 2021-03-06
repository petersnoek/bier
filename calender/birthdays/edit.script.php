<?php
require_once "../common/settings.script.php";

$db = new mysqli($settings["db_server"], $settings["db_user"], $settings["db_password"], $settings["db_name"]);
$id = $db->escape_string($_GET["id"]);

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    // Get information on the birthday the user wants to delete from the database.
    $result = $db->query("select * from birthdays where id='$id'");
    $birthday = $result->fetch_assoc();
    
    if ($birthday == NULL) {
        // The birthday doesn't exist, so we should respond with an HTTP 404.
        http_response_code(404);
        include("../common/not_found.php");
        exit();
    }
    
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update the birthday in the database.
    $person = $db->escape_string($_POST["person"]);
    $day = $db->escape_string($_POST["day"]);
    $month = $db->escape_string($_POST["month"]);
    $year = $db->escape_string($_POST["year"]);
    
    $db->query("update birthdays set person='$person', day='$day', month='$month', year='$year' where id='$id'");
    
    // Tell the browser to go back to the index page.
    header("Location: ./");
    exit();
}