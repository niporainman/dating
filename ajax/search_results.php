<?php
session_start();
require_once '../minks1.php';
require_once '../functions.php';

$user_id = $_SESSION['user_id'] ?? null;
if (!$user_id) exit;

// Get search filters from POST
$location     = $_POST['location'] ?? '';
$gender       = $_POST['gender'] ?? '';
$looking_for  = $_POST['looking_for'] ?? '';
$min_age      = $_POST['min_age'] ?? '';
$max_age      = $_POST['max_age'] ?? '';
$religion     = $_POST['religion'] ?? '';

// Get current user details
$current_user = get_user_details($user_id, $con);

// Build dynamic SQL query
$sql = "SELECT * FROM users WHERE user_id != ?";
$params = [$user_id];
$types = "s";

if ($location) {
    $sql .= " AND location LIKE ?";
    $params[] = "%$location%";
    $types .= "s";
}
if ($gender) {
    $sql .= " AND gender = ?";
    $params[] = $gender;
    $types .= "s";
}
if ($looking_for) {
    $sql .= " AND looking_for = ?";
    $params[] = $looking_for;
    $types .= "s";
}
if ($min_age) {
    $sql .= " AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) >= ?";
    $params[] = $min_age;
    $types .= "i";
}
if ($max_age) {
    $sql .= " AND TIMESTAMPDIFF(YEAR, dob, CURDATE()) <= ?";
    $params[] = $max_age;
    $types .= "i";
}
if ($religion) {
    $sql .= " AND religion = ?";
    $params[] = $religion;
    $types .= "s";
}

// Execute query
$stmt = $con->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();
$totalResults = $result->num_rows;
$hasResults = false;
if ($totalResults > 0) {
    echo "<div class='col-12 mb-3'><h6><strong>$totalResults</strong> matches found</h6></div>";
}
while ($row = $result->fetch_assoc()) {
    $hasResults = true;
    // Clean variable names for template readability
    $id          = $row['user_id'];
    $firstname        = $row['first_name'] ?? '';
    $lastname        = $row['last_name'] ?? '';
    $age         = date_diff(date_create($row['dob']), date_create('today'))->y;
    $location    = $row['location'];
    $gender      = $row['gender'];
    $profile_pic = $row['profile_pic'] ? "users/$id/{$row['profile_pic']}" : "images/profile_placeholder.jpg";

    // Calculate compatibility score
    $score = calculate_compatibility($current_user, $row, $con);

    // Render card
    include("../friend_card.php");
}
if (!$hasResults) {
    echo '<div class="col-12 text-center text-muted py-5"><h5>No matches found. Try adjusting your search criteria.</h5></div>';
}
?>


