<?php
require_once __DIR__ . '/../includes/auth.php'; require_role(['student']); require __DIR__ . '/../config/database.php';
$pageTitle='Assignments and Quizzes'; $id=(int)$_SESSION['user_id']; $notice='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $activityId=(int)($_POST['activity_id']??0); $answer=trim($_POST['answer_text']??'');
    $q=$pdo->prepare('SELECT a.id,a.due_at FROM activities a JOIN enrollments en ON en.subject_id=a.subject_id WHERE a.id=? AND en.student_id=?'); $q->execute([$activityId,$id]); $activity=$q->fetch();
    if(!$activity){$notice='Activity not found or you are not enrolled.';}
    elseif($activity['due_at'] && strtotime($activity['due_at'])<time()){$notice='The due date has passed. Submission is closed.';}
    elseif($answer===''){$notice='Please enter your answer before submitting.';}
    else {
        try{$ins=$pdo->prepare("INSERT INTO submissions(activity_id,student_id,answer_text) VALUES(?,?,?)");$ins->execute([$activityId,$id,$answer]);$notice='Your answer was submitted.';}
        catch(PDOException $e){$notice='You have already submitted this activity.';}
    }
}
$q=$pdo->prepare("SELECT a.id,a.title,a.instructions,a.activity_type,a.due_at,s.subject_name,sub.status,sub.score FROM activities a JOIN subjects s ON s.id=a.subject_id JOIN enrollments en ON en.subject_id=s.id LEFT JOIN submissions sub ON sub.activity_id=a.id AND sub.student_id=? WHERE en.student_id=? ORDER BY a.due_at IS NULL,a.due_at");
$q->execute([$id,$id]);$activities=$q->fetchAll(); require __DIR__ . '/../includes/header.php'; ?>
<?php if($notice): ?><div class="alert"><?= e($notice) ?></div><?php endif; ?>
<section class="panel"><div class="panel-head"><h3>Activities</h3></div><?php if(!$activities): ?><p class="empty">No assignments or quizzes available.</p><?php endif; ?>
<?php foreach($activities as $a): ?><article class="activity-card"><div class="panel-head"><div><span class="tag"><?= e(ucfirst($a['activity_type'])) ?></span><h3><?= e($a['title']) ?></h3><small class="muted"><?= e($a['subject_name']) ?> · Due <?= e($a['due_at'] ?: 'No deadline') ?></small></div><span class="status"><?= e($a['status'] ? ucfirst($a['status']) : 'Pending') ?></span></div><p><?= nl2br(e($a['instructions'])) ?></p>
<?php if(!$a['status']): ?><form method="post" class="submit-form"><input type="hidden" name="activity_id" value="<?= (int)$a['id'] ?>"><label>Your answer</label><textarea name="answer_text" rows="3" required placeholder="Type your answer here..."></textarea><button class="btn" type="submit">Submit answer</button></form><?php else: ?><p class="muted">Submission received. <?= $a['score']!==null?'Score: '.e($a['score']):'Waiting for teacher review.' ?></p><?php endif; ?></article><?php endforeach; ?></section>
<?php require __DIR__ . '/../includes/footer.php'; ?>
