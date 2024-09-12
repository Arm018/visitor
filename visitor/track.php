<?php

include 'db.php';

$data = json_decode(file_get_contents('php://input'), true);

$ip = isset($data['ip']) ? trim($data['ip']) : null;
$city = isset($data['city']) ? trim($data['city']) : null;
$device = isset($data['device']) ? trim($data['device']) : null;

if (!empty($ip) && !empty($city) && !empty($device)) {
    $sql = "INSERT INTO visits (ip, city, device, visit_time) VALUES (:ip, :city, :device, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['ip' => $ip, 'city' => $city, 'device' => $device]);

}

?>
