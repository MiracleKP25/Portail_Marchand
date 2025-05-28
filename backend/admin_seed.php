<?php
require_once './config/config.php';

$db = (new Database())->getConnection();

$email = "admin@marche.local";
$password = password_hash("admin123", PASSWORD_BCRYPT);

$stmt = $db->prepare("INSERT INTO admins (email, password) VALUES (?, ?)");
$stmt->execute([$email, $password]);

echo "Admin ajouté avec succès.";
