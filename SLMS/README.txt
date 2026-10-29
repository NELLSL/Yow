SLMS - Student Learning Management System
Stack: HTML, CSS, JavaScript, PHP, MySQL (XAMPP), edit with Notepad++

SETUP
1. Extract the SLMS folder to C:\xampp\htdocs\SLMS
2. Start Apache and MySQL in XAMPP Control Panel.
3. Open http://localhost/phpmyadmin
4. Import database.sql (choose the file from the SLMS folder).
5. Open http://localhost/SLMS/setup.php once to create demo accounts.
6. Open http://localhost/SLMS/
7. DELETE setup.php after initial setup.

DEMO SIGN-INS
Student: student1 / Student123!
Teacher: teacher1 / Teacher123!
Admin: admin1 / Admin123!

WHAT'S INCLUDED
- Login with PHP sessions and password verification.
- Student dashboard, subjects/material listing, assignment answer submissions, grade view.
- Teacher dashboard, subject/activity listing, submission review and grading.
- Admin dashboard, account listing, subject listing, basic system counts.
- MySQL schema for users, subjects, enrollments, materials, activities, submissions, announcements.

IMPORTANT LIMITATIONS
- This is a classroom starter/prototype, not production-ready.
- Demo setup only adds starter users and one subject; the student is not auto-enrolled.
- To demonstrate subjects, create an enrollment using phpMyAdmin, e.g.:
  INSERT INTO enrollments(student_id,subject_id)
  SELECT u.id,s.id FROM users u CROSS JOIN subjects s
  WHERE u.username='student1' AND s.subject_code='IS101';
- Forgot password is informational only; no email reset is configured.
- Teacher resource upload and activity creation, admin account/class management, quiz engine,
  and announcement posting are not yet implemented as forms.
- Student submission currently supports text answers; file submission is not implemented.
- Do not expose setup.php, error details, or uploads directly in a production deployment.
- Use HTTPS, CSRF protection, stronger upload validation/storage, rate limiting, audit logging,
  backups, and proper account provisioning before real student use.
