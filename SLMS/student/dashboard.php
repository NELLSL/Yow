<?php
require_once __DIR__ . '/../includes/auth.php'; require_role(['student']); require __DIR__ . '/../config/database.php';
$pageTitle='Student Dashboard'; $id=(int)$_SESSION['user_id'];
$stmt=$pdo->prepare('SELECT s.id,s.subject_code,s.subject_name FROM subjects s JOIN enrollments en ON en.subject_id=s.id WHERE en.student_id=? ORDER BY s.subject_name');
$stmt->execute([$id]); $subjects=$stmt->fetchAll();
$stmt=$pdo->prepare("SELECT a.id,a.title,a.activity_type,a.due_at,s.subject_name FROM activities a JOIN subjects s ON s.id=a.subject_id JOIN enrollments en ON en.subject_id=s.id LEFT JOIN submissions sub ON sub.activity_id=a.id AND sub.student_id=? WHERE en.student_id=? AND sub.id IS NULL ORDER BY a.due_at IS NULL, a.due_at LIMIT 5");
$stmt->execute([$id,$id]); $pending=$stmt->fetchAll();
$announcements=$pdo->query('SELECT title,body,created_at FROM announcements ORDER BY created_at DESC LIMIT 4')->fetchAll();
require __DIR__ . '/../includes/header.php'; ?>
<div class="welcome"><div><p class="eyebrow light">YOUR LEARNING SPACE</p><h1>Welcome back, <?= e($_SESSION['full_name']) ?>!</h1><p>Keep learning. You're making progress one step at a time.</p></div><div class="welcome-icon">✦</div></div>
<div class="stats-grid"><article class="stat-card"><span>Enrolled subjects</span><strong><?= count($subjects) ?></strong><small>Current subjects</small></article><article class="stat-card"><span>Pending activities</span><strong><?= count($pending) ?></strong><small>Needs your attention</small></article><article class="stat-card"><span>Announcements</span><strong><?= count($announcements) ?></strong><small>Recent school updates</small></article></div>
<div class="content-grid"><section class="panel"><div class="panel-head"><h3>My subjects</h3><a href="subjects.php">View all</a></div>
<?php if (!$subjects): ?><p class="empty">No subjects yet. Ask your teacher or admin to enroll you.</p><?php else: ?><div class="subject-list"><?php foreach($subjects as $s): ?><div class="subject-item"><div class="subject-icon">▤</div><div><strong><?= e($s['subject_name']) ?></strong><small><?= e($s['subject_code']) ?></small></div></div><?php endforeach; ?></div><?php endif; ?></section>
<section class="panel"><div class="panel-head"><h3>Pending activities</h3><a href="assignments.php">View all</a></div>
<?php if (!$pending): ?><p class="empty">You're all caught up!</p><?php else: foreach($pending as $a): ?><div class="activity-row"><div><strong><?= e($a['title']) ?></strong><small><?= e($a['subject_name']) ?> · <?= e(ucfirst($a['activity_type'])) ?></small><small>Due: <?= e($a['due_at'] ?: 'No deadline') ?></small></div><span class="status">Pending</span></div><?php endforeach; endif; ?></section></div>
<section class="panel section-gap"><div class="panel-head"><h3>Recent announcements</h3></div><?php if(!$announcements): ?><p class="empty">No announcements posted.</p><?php else: foreach($announcements as $a): ?><div class="announcement"><strong><?= e($a['title']) ?></strong><p><?= nl2br(e($a['body'])) ?></p><small><?= e($a['created_at']) ?></small></div><?php endforeach; endif; ?></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
