document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('loginForm');
  if (!form) return;

  const submitBtn = form.querySelector('button[type="submit"]');
  const originalContent = submitBtn.innerHTML;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const valid = Validator.validate(form, {
      email: ['required', 'email'],
      password: ['required'],
    });

    if (!valid) return;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Logging in...';

    const data = Validator.getData(form);
    const result = await Request.post('/ajax/login', data);

    if (result.success) {
      User.set(result.user);
      submitBtn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Welcome back!';
      submitBtn.classList.replace('bg-primary-container', 'bg-tertiary-container');
      setTimeout(() => {
        window.location.href = result.redirect || '/app';
      }, 1500);
    } else {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalContent;
      alert(result.message || 'Login failed. Please try again.');
    }
  });
});
