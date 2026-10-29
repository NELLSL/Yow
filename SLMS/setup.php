<?php
// Run once after importing database.sql: http://localhost/SLMS/setup.php
// DELETE or rename this file after setup for safety.
require __DIR__ . '/config/database.php';

$demoUsers = [
    ['Sample Student', 'student1', 'student@slms.local', 'Student123!', 'student'],
    ['Sample Teacher', 'teacher1', 'teacher@slms.local', 'Teacher123!', 'teacher'],
    ['System Administrator', 'admin1', 'admin@slms.local', 'Admin123!', 'admin'],
];
$insertUser = $pdo->prepare(
    'INSERT IGNORE INTO users (full_name, username, email, password_hash, role) VALUES (?, ?, ?, ?, ?)'
);
foreach ($demoUsers as $user) {
    $insertUser->execute([$user[0], $user[1], $user[2], password_hash($user[3], PASSWORD_DEFAULT), $user[4]]);
}
$teacherId = (int)$pdo->query("SELECT id FROM users WHERE username='teacher1'")->fetchColumn();
$pdo->prepare('INSERT IGNORE INTO subjects (subject_code, subject_name, teacher_id, description) VALUES (?, ?, ?, ?)')
    ->execute(['IS101', 'Introduction to Information Systems', $teacherId, 'Sample subject for system testing.']);

echo '<h2>SLMS demo setup complete.</h2>';
echo '<p>Sample accounts (change passwords before real use):</p><ul>';
echo '<li>Student: student1 / Student123!</li><li>Teacher: teacher1 / Teacher123!</li><li>Admin: admin1 / Admin123!</li></ul>';
echo '<p><a href="index.php">Go to login</a></p>';
