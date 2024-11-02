<?php
// Set up a MySQL database connection.
$server = "db:3306"; //DDEV users: change to “db:3306!”
$database = "mobile";
$user = "mobile";
$password = "mobile";
// Create a new mysqli object to connect to the database.
$mysqli = new mysqli($server, $user, $password, $database);


// Fetch a list of manufacturer IDs and titles from the database and store them in an associative array.
$manufacturers = array();
// Execute a query to retrieve all manufacturers, ordered by title.
$manufacturer_handle = $mysqli->query("select id, title from manufacturers order by title");
// Loop through each row in the result set.
while ($row = $manufacturer_handle->fetch_assoc()) {
 // Add each manufacturer id and title to the $manufacturers array.
 $manufacturers [$row["id"]] = $row["title"];
}


// Fetch a list of country IDs and titles from the database and store them in an associative array.
$countries = array();
// Execute a query to retrieve all countries, ordered by title.
$country_handle = $mysqli->query("select id, title from countries order by title");
// Loop through each row in the result set.
while ($row = $country_handle->fetch_assoc()) {
    // Add each country id and title to the $countries array.
    $countries[$row["id"]] = $row["title"];
}


// Collect and sanitize the current inputs from GET data.
$year = isset($_GET['year']) && is_numeric($_GET['year']) ? (int)$_GET['year'] : null;
$manufacturer = isset($_GET['manufacturer']) && is_numeric($_GET['manufacturer']) ? (int)$_GET['manufacturer'] : null;
$country = isset($_GET['country']) && is_numeric($_GET['country']) ? (int)$_GET['country'] : null;

// Prepare a SQL query to fetch cars information based on input criteria.
$query = "SELECT
            manufacturers.title as manufacturer,
            models.title as model,
            colors.title as color,
            COUNT(*) as count
          FROM cars
          INNER JOIN models ON cars.model_id = models.id
          INNER JOIN manufacturers ON models.manufacturer_id = manufacturers.id
          INNER JOIN colors ON cars.color_id = colors.id
          INNER JOIN countries ON cars.source_country_id = countries.id
          WHERE cars.registration_year = ?
            AND manufacturers.id = ?
            AND countries.id = ?
          GROUP BY manufacturer, model, color
          ORDER BY count DESC";

// Prepare the SQL query for execution.
$stmt = $mysqli->prepare($query);

// Check if the SQL statement was prepared successfully.
if ($stmt === false) {
    // If preparation failed, terminate the script and show the error.
    die('Prepare failed: ' . htmlspecialchars($mysqli->error));
}

// Bind the input parameters to the prepared statement.
$stmt->bind_param('iii', $year, $manufacturer, $country);

// Execute the prepared statement.
$stmt->execute();

// Store the results of the query.
$result = $stmt->get_result();

// Fetch all rows from the result as an associative array.
$results = $result->fetch_all(MYSQLI_ASSOC);

// Close the prepared statement.
$stmt->close();

require_once("../task2/logger.php");

$logPath = '../task2/logger.txt';

$logger = new Logger($logPath);

// Include the view file to display the results to the user.
require("view.php");
?>
