/**
 * Form Validator
 * Usage: validate(formElement, { field: rules })
 */

const Validator = {
  errors: {},

  rules: {
    required(value, msg) {
      return value.trim() ? '' : (msg || 'This field is required');
    },
    email(value, msg) {
      return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value) ? '' : (msg || 'Invalid email address');
    },
    minLength(value, min, msg) {
      return value.length >= min ? '' : (msg || `Minimum ${min} characters required`);
    },
    maxLength(value, max, msg) {
      return value.length <= max ? '' : (msg || `Maximum ${max} characters allowed`);
    },
    match(value, target, msg) {
      return value === target ? '' : (msg || 'Fields do not match');
    },
    password(value, msg) {
      const hasUpper = /[A-Z]/.test(value);
      const hasLower = /[a-z]/.test(value);
      const hasDigit = /\d/.test(value);
      const hasSymbol = /[!@#$%^&*(),.?":{}|<>]/.test(value);
      return value.length >= 8 && hasUpper && hasLower && hasDigit && hasSymbol
        ? '' : (msg || 'Must be 8+ chars with uppercase, lowercase, number & symbol');
    },
  },

  validate(form, fieldRules) {
    this.errors = {};
    const data = this.getData(form);

    for (const [field, rules] of Object.entries(fieldRules)) {
      const value = data[field] || '';
      for (const rule of rules) {
        const error = this.runRule(rule, value, data);
        if (error) {
          this.errors[field] = error;
          break;
        }
      }
    }

    this.showErrors(form);
    return Object.keys(this.errors).length === 0;
  },

  runRule(rule, value, data) {
    if (typeof rule === 'string') {
      return this.rules[rule] ? this.rules[rule](value) : '';
    }
    if (Array.isArray(rule)) {
      const [name, ...args] = rule;
      const lastArg = args[args.length - 1];
      const msg = typeof lastArg === 'string' ? args.pop() : undefined;
      return this.rules[name] ? this.rules[name](value, ...args, msg) : '';
    }
    return '';
  },

  getData(form) {
    const data = {};
    const fd = new FormData(form);
    for (const [key, val] of fd) {
      data[key] = val;
    }
    return data;
  },

  showErrors(form) {
    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

    for (const [field, msg] of Object.entries(this.errors)) {
      const input = form.querySelector(`[name="${field}"]`);
      if (!input) continue;
      input.classList.add('input-error');
      const errorEl = document.createElement('p');
      errorEl.className = 'field-error text-primary text-[12px] font-semibold mt-1 px-1';
      errorEl.textContent = msg;
      input.parentNode.after(errorEl);
    }
  },

  clearErrors(form) {
    form.querySelectorAll('.field-error').forEach(el => el.remove());
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
  },
};
