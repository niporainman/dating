<?php

// Get full user details
function get_user_details($user_id, $con) {
    $stmt = $con->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Get user interests
function get_user_interests($user_id, $con) {
    $stmt = $con->prepare("SELECT category, value FROM user_interests WHERE user_id = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    
    $interests = [];
    while ($row = $res->fetch_assoc()) {
        $interests[$row['category']][] = strtolower(trim($row['value']));
    }
    return $interests;
}

// Calculate compatibility score
function calculate_compatibility($userA, $userB, $con) {
    $score = 0;
    $total = 0;

    // Age proximity
    $ageA = date_diff(date_create($userA['dob']), date_create('today'))->y;
    $ageB = date_diff(date_create($userB['dob']), date_create('today'))->y;
    $age_diff = abs($ageA - $ageB);
    $score += max(0, 100 - ($age_diff * 5)); // 5% penalty per year
    $total += 100;

    // Location match
    if (strtolower(trim($userA['location'])) == strtolower(trim($userB['location']))) {
        $score += 50;
    }
    $total += 50;

    // Religion match
    if ($userA['religion'] == $userB['religion']) {
        $score += 30;
    }
    $total += 30;

    // Looking for compatibility
    if ($userA['looking_for'] == $userB['looking_for']) {
        $score += 20;
    }
    $total += 20;

    // Interests match
    $interestsA = get_user_interests($userA['user_id'], $con);
    $interestsB = get_user_interests($userB['user_id'], $con);
    $interestScore = 0;
    $interestTotal = 0;

    foreach ($interestsA as $category => $itemsA) {
        $itemsB = $interestsB[$category] ?? [];
        $matches = array_intersect($itemsA, $itemsB);
        $interestScore += count($matches);
        $interestTotal += max(count($itemsA), count($itemsB), 1);
    }

    if ($interestTotal > 0) {
        $score += ($interestScore / $interestTotal) * 100;
        $total += 100;
    }

    // Normalize final score
    return round(($score / $total) * 100);
}

function get_connection_status($user_id, $other_id, $con) {
    $stmt = $con->prepare("SELECT sender, status FROM connections WHERE 
        (sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?)
        LIMIT 1");
    $stmt->bind_param("ssss", $user_id, $other_id, $other_id, $user_id);
    $stmt->execute();
    $stmt->bind_result($sender, $status);
    if ($stmt->fetch()) {
        return ['sender' => $sender, 'status' => $status];
    }
    return ['status' => null];
}

function time_elapsed_string($timestamp, $full = false) {
    if (empty($timestamp)) return "never";

    // Convert to integer if it's not already
    $timestamp = (int)$timestamp;

    // Get current time
    $now = time();
    $diff = $now - $timestamp;

    // SAFETY CHECK
    if ($diff < 0) return "just now";

    $intervals = [
        'year'   => 31536000,
        'month'  => 2592000,
        'day'    => 86400,
        'hour'   => 3600,
        'minute' => 60,
        'second' => 1,
    ];

    $string = [];

    foreach ($intervals as $name => $seconds) {
        if ($diff >= $seconds) {
            $value = floor($diff / $seconds);
            $string[] = "$value $name" . ($value > 1 ? 's' : '');
            $diff -= $value * $seconds;
            if (!$full) break;
        }
    }

    return $string ? implode(', ', $string) . ' ago' : 'just now';
}


function isOnline($last_active) {
    if (empty($last_active)) return false;

    // Make sure it's a datetime string
    if (!is_numeric($last_active)) {
        $last_active = strtotime($last_active);
    }

    return (time() - $last_active) < 300; // Online if active within last 5 minutes
}

/*
// Function to check online status
function isOnline($last_active) {
    if (empty($last_active)) return false;
    return (time() - strtotime($last_active)) < 300;
}
*/

function calculate_compatibility_by_ids($userIdA, $userIdB, $con) {
    // Fetch user A
    $stmtA = $con->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmtA->bind_param("s", $userIdA);
    $stmtA->execute();
    $resultA = $stmtA->get_result();
    $userA = $resultA->fetch_assoc();
    if (!$userA) return 0;

    // Fetch user B
    $stmtB = $con->prepare("SELECT * FROM users WHERE user_id = ?");
    $stmtB->bind_param("s", $userIdB);
    $stmtB->execute();
    $resultB = $stmtB->get_result();
    $userB = $resultB->fetch_assoc();
    if (!$userB) return 0;

    return calculate_compatibility($userA, $userB, $con);
}

function are_friends($userA, $userB, $con) {
    $sql = "SELECT 1 FROM connections 
            WHERE status = 'Accepted' AND 
            ((sender = ? AND receiver = ?) OR (sender = ? AND receiver = ?))
            LIMIT 1";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssss", $userA, $userB, $userB, $userA);
    $stmt->execute();
    $stmt->store_result();
    
    return $stmt->num_rows > 0;
}


