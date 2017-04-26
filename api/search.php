<?php

require_once '../include/mysql.php';
header('Content-type: application/json');

if (!isset($_GET['term']) || empty($_GET['term'])) {
	exit('{"me":"what??"}');
}

$searchTerm = $_GET['term'] . '%';

$stmt = $connection->prepare('select name from baby_names where name like ?');
$stmt->bind_param('s', $searchTerm);

if ($stmt->execute()) {
	$response = [];
	foreach($stmt->get_result() as $row) {
		$response[] = $row['name'];
	}
} else {
	$response = ['error' => $stmt->error];
}

echo json_encode($response);
