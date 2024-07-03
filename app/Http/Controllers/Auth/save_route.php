<?php
// Save the posted route data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // For demonstration purposes, save to a file
    $file = 'routes.json';
    if (file_exists($file)) {
        $currentData = json_decode(file_get_contents($file), true);
        $currentData[] = $data;
    } else {
        $currentData = [$data];
    }

    file_put_contents($file, json_encode($currentData));

    echo json_encode(['status' => 'success']);
}
?>
