/**
 * Register Page Handler
 * Validates form and submits registration via AJAX.
 */

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registrationForm');
  if (!form) return;

  const submitBtn = form.querySelector('button[type="submit"]');
  const originalContent = submitBtn.innerHTML;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const valid = Validator.validate(form, {
      name: ['required'],
      email: ['required', 'email'],
      password: [['minLength', 8, 'Minimum 8 characters required']],
      terms: ['required'],
    });

    if (!valid) return;

    submitBtn.disabled = true;
    submitBtn.innerHTML = '<span class="material-symbols-outlined animate-spin">sync</span> Creating...';

    const data = Validator.getData(form);
    const result = await Request.post('/ajax/register', data);

    if (result.success) {
      submitBtn.innerHTML = '<span class="material-symbols-outlined">check_circle</span> Welcome!';
      submitBtn.classList.replace('bg-primary-container', 'bg-tertiary-container');
      setTimeout(() => {
        window.location.href = result.redirect || '/app';
      }, 1500);
    } else {
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalContent;
      alert(result.message || 'Registration failed. Please try again.');
    }
  });
});
