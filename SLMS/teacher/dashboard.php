<?php
require_once __DIR__ . '/../includes/auth.php'; require_role(['teacher']); require __DIR__ . '/../config/database.php'; $pageTitle='Teacher Dashboard'; $id=(int)$_SESSION['user_id'];
$q=$pdo->prepare('SELECT COUNT(*) FROM subjects WHERE teacher_id=?');$q->execute([$id]);$subjects=(int)$q->fetchColumn();
$q=$pdo->prepare('SELECT COUNT(*) FROM activities WHERE created_by=?');$q->execute([$id]);$activities=(int)$q->fetchColumn();
$q=$pdo->prepare("SELECT COUNT(*) FROM submissions sub JOIN activities a ON a.id=sub.activity_id WHERE a.created_by=? AND sub.status='submitted'");$q->execute([$id]);$reviews=(int)$q->fetchColumn();
require __DIR__ . '/../includes/header.php'; ?>
<div class="welcome"><div><p class="eyebrow light">TEACHER WORKSPACE</p><h1>Hello, <?= e($_SESSION['full_name']) ?>!</h1><p>Manage your classes, learning resources, and student work.</p></div><div class="welcome-icon">✦</div></div>
<div class="stats-grid"><article class="stat-card"><span>My subjects</span><strong><?= $subjects ?></strong></article><article class="stat-card"><span>Activities created</span><strong><?= $activities ?></strong></article><article class="stat-card"><span>Submissions to review</span><strong><?= $reviews ?></strong></article></div>
<section class="panel"><div class="panel-head"><h3>Teacher tools</h3></div><div class="quick-links"><a class="quick-link" href="subjects.php"><strong>Manage subjects</strong><small>Upload learning materials</small></a><a class="quick-link" href="activities.php"><strong>Assignments & quizzes</strong><small>Create classroom activities</small></a><a class="quick-link" href="submissions.php"><strong>Review submissions</strong><small>Provide grades and feedback</small></a></div><p class="muted">Subject creation, resource upload, activity creation and grading screens are starter placeholders in this first version.</p></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
