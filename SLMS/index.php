<?php
session_start();
require __DIR__ . '/config/database.php';
if (!empty($_SESSION['user_id'])) {
    $role = $_SESSION['role'] ?? 'student';
    header('Location: ' . ($role === 'admin' ? 'admin/dashboard.php' : ($role === 'teacher' ? 'teacher/dashboard.php' : 'student/dashboard.php')));
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identity = trim($_POST['identity'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $pdo->prepare('SELECT id, full_name, username, password_hash, role FROM users WHERE username = ? OR email = ? LIMIT 1');
    $stmt->execute([$identity, $identity]);
    $user = $stmt->fetch();
    if ($user && password_verify($password, $user['password_hash'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id'];
        $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];
        $destination = $user['role'] === 'admin' ? 'admin/dashboard.php' : ($user['role'] === 'teacher' ? 'teacher/dashboard.php' : 'student/dashboard.php');
        header("Location: $destination");
        exit;
    }
    $error = 'Invalid username/email or password.';
}
?>
<!doctype html>
<html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>SLMS | Sign in</title><link rel="stylesheet" href="css/style.css"></head>
<body class="login-page"><main class="login-card">
<div class="brand-mark">S</div><p class="eyebrow">STUDENT LEARNING</p><h1>Welcome to SLMS</h1>
<p class="muted">Sign in to continue to your learning space.</p>
<?php if ($error): ?><div class="alert error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div><?php endif; ?>
<form method="post" action="index.php">
<label for="identity">Email or username</label><input id="identity" name="identity" autocomplete="username" required>
<label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required>
<div class="form-row"><label class="check"><input type="checkbox" id="showPassword"> Show password</label><a href="forgot-password.php">Forgot password?</a></div>
<button class="btn full" type="submit">Log in</button>
</form><p class="login-foot">Learning today, leading tomorrow.</p>
</main><script src="js/script.js"></script></body></html>
