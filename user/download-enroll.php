<?php

require_once("../connection.php");

$stmt = $conn->query("SELECT * from enrollments LIMIT 1000");
$enrolls = $stmt->fetchAll(PDO::FETCH_ASSOC);

$fileName = "enroolments1000.csv";

$handle = fopen('php://output', "w+");

header('Content-Type: text/csv; charset=utf-8');
header("Content-Disposition: attachment; filename=$fileName");
fputcsv($handle, ['id', 'role_id', 'course_id', 'enrolled_at']);

foreach ($enrolls as $enroll) {
    fputcsv($handle, $enroll);
}

fclose($handle);
exit;
