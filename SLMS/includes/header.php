<?php
require_once __DIR__ . '/auth.php';
$pageTitle = $pageTitle ?? 'Dashboard';
$role = $_SESSION['role'] ?? 'student';
$name = $_SESSION['full_name'] ?? 'User';
$base = $role === 'student' ? '../' : '../';
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($pageTitle) ?> | SLMS</title><link rel="stylesheet" href="../css/style.css"></head><body>
<div class="app-shell"><aside class="sidebar"><a class="side-brand" href="dashboard.php"><span class="brand-mini">S</span><span>SLMS<small>Learning Portal</small></span></a>
<nav>
<a href="dashboard.php">▦ <span>Dashboard</span></a>
<?php if ($role === 'student'): ?>
<a href="subjects.php">▤ <span>My Subjects</span></a><a href="assignments.php">✓ <span>Assignments & Quizzes</span></a><a href="grades.php">◷ <span>Grades & Progress</span></a>
<?php elseif ($role === 'teacher'): ?>
<a href="subjects.php">▤ <span>Manage Subjects</span></a><a href="activities.php">✓ <span>Activities</span></a><a href="submissions.php">▣ <span>Submissions</span></a>
<?php else: ?>
<a href="users.php">♙ <span>Manage Accounts</span></a><a href="subjects.php">▤ <span>Subjects & Classes</span></a><a href="records.php">▣ <span>System Records</span></a>
<?php endif; ?>
</nav><div class="side-bottom"><a href="../logout.php">↪ <span>Log out</span></a></div></aside>
<main class="main-area"><header class="topbar"><div><span class="eyebrow">STUDENT LEARNING MANAGEMENT SYSTEM</span><h2><?= e($pageTitle) ?></h2></div><div class="user-chip"><div class="avatar"><?= e(strtoupper(substr($name,0,1))) ?></div><div><strong><?= e($name) ?></strong><small><?= e(ucfirst($role)) ?></small></div></div></header><section class="page-content">
