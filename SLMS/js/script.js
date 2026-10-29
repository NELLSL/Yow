document.addEventListener('DOMContentLoaded', function () {
  const showPassword = document.getElementById('showPassword');
  const passwordInput = document.getElementById('password');
  if (showPassword && passwordInput) {
    showPassword.addEventListener('change', function () {
      passwordInput.type = this.checked ? 'text' : 'password';
    });
  }
});
