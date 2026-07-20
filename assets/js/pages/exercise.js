document.addEventListener('DOMContentLoaded', () => {
  const el = document.getElementById('exercise-data');
  if (!el) return;

  const exercise = JSON.parse(el.textContent);
  const today = new Date().toISOString().split('T')[0];
  const key = 'redwellness_today_exercises';

  let stored = {};
  try {
    stored = JSON.parse(localStorage.getItem(key) || '{}');
  } catch (_) {}

  if (stored.date !== today) {
    stored = { date: today, exercises: [] };
  }

  const alreadyExists = stored.exercises.some(e => e.id === exercise.id);
  if (!alreadyExists) {
    stored.exercises.push({
      id: exercise.id,
      name: exercise.name,
      category: exercise.category,
      viewed_at: new Date().toISOString(),
    });
  }

  localStorage.setItem(key, JSON.stringify(stored));
});
