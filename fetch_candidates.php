<?php
include("config.php");

$sql = "SELECT candidates.id, candidates.name, candidates.course, candidates.year, positions.id as position_id, positions.description 
        FROM candidates 
        JOIN positions ON candidates.position_id = positions.id 
        ORDER BY positions.id";
$result = $conn->query($sql);

$candidates = [];

if ($result) {
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $candidates[$row['position_id']]['description'] = $row['description'];
            $candidates[$row['position_id']]['candidates'][] = [
                'id' => $row['id'],
                'name' => $row['name'],
                'course' => $row['course'],
                'year' => $row['year']
            ];
        }
    } else {
        error_log("No candidates found.");
    }
} else {
    error_log("Error executing query: " . $conn->error);
}

header('Content-Type: application/json');
echo json_encode($candidates);

$conn->close();
?>
