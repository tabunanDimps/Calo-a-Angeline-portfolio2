<?php
session_start(); // Start the session at the beginning

include 'config.php';

// Collect the form data
$votes = [];
foreach ($_POST as $key => $value) {
    if (strpos($key, 'position_') === 0) {
        $positionId = str_replace('position_', '', $key);
        $candidateId = $value;
        $votes[] = ['position_id' => $positionId, 'candidate_id' => $candidateId];
    }
}

// Get the voter's IdNumber from the session
$voterId = $con->real_escape_string($_SESSION['IdNumber']);

// Insert the votes into the database
foreach ($votes as $vote) {
    $positionId = $con->real_escape_string($vote['position_id']);
    $candidateId = $con->real_escape_string($vote['candidate_id']);
    $sql = "INSERT INTO votes (position_id, candidate_id, voter_id) VALUES ('$positionId', '$candidateId', '$voterId')";
    if (!$con->query($sql)) {
        echo '<p>Error submitting vote: ' . $con->error . '</p>';
        exit;
    }
}

$con->close();

header('Location: thankyou.php');
?>
