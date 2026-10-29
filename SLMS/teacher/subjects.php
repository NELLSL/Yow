<?php
require_once __DIR__ . '/../includes/auth.php'; require_role(['teacher']); require __DIR__ . '/../config/database.php'; $pageTitle='Manage Subjects';
$q=$pdo->prepare('SELECT subject_code,subject_name,description FROM subjects WHERE teacher_id=? ORDER BY subject_name');$q->execute([$_SESSION['user_id']]);$rows=$q->fetchAll();require __DIR__ . '/../includes/header.php'; ?>
<section class="panel"><div class="panel-head"><h3>My subjects</h3></div><?php if(!$rows): ?><p class="empty">No subjects assigned to your account.</p><?php else: foreach($rows as $s): ?><div class="subject-item"><div class="subject-icon">▤</div><div><strong><?= e($s['subject_name']) ?></strong><small><?= e($s['subject_code']) ?></small><small><?= e($s['description']) ?></small></div></div><?php endforeach; endif; ?><p class="muted section-gap">Ask your administrator to assign subjects. Resource upload can be added next.</p></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
