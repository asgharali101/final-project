<?php

try {
    $conn = new PDO("mysql:host=localhost;dbname=lms", "root", "");
} catch (\Throwable $th) {
    echo "error in your Databse Connection" . $th->getMessage();
}
