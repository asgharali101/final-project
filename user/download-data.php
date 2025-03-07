<?php

require_once("../connection.php");

$stmt = $conn->query("SELECT * from users LIMIT 1000");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$fileName = "users1000.csv";

$handle = fopen('php://output', "w+");

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$fileName");
fputcsv($handle, ['id', 'role_id', 'first_name', 'last_name', 'email', 'password', 'date_of_birth', 'image_path', 'address']);

foreach ($users as $user) {
    fputcsv($handle, $user);
}

fclose($handle);
exit;
