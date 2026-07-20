document.addEventListener('DOMContentLoaded', async () => {
  const data = await Request.get('/ajax/nutrition');
  if (!data.success) return;

  const { today_logs, totals, goals, meal_types } = data;
  let selectedMealType = '';

  const container = document.getElementById('meals-container');
  const ringCircle = document.querySelector('.progress-ring-circle');

  function updateRing(percent) {
    if (!ringCircle) return;
    const radius = ringCircle.r.baseVal.value;
    const circumference = radius * 2 * Math.PI;
    ringCircle.style.strokeDasharray = `${circumference} ${circumference}`;
    const offset = circumference - (percent / 100 * circumference);
    setTimeout(() => { ringCircle.style.strokeDashoffset = offset; }, 100);
  }

  function getLogsForType(type) {
    return today_logs.filter(l => l.meal_type === type);
  }

  function calcPercent(value, goal) {
    return goal > 0 ? Math.min(100, Math.round(value / goal * 100)) : 0;
  }

  function renderMeals() {
    const caloriesPercent = calcPercent(totals.calories, goals.calorie_goal);
    const kcalLeft = Math.max(0, goals.calorie_goal - totals.calories);

    container.innerHTML = meal_types.map(mt => {
      const logs = getLogsForType(mt.name);
      const first = logs[0];

      if (!first) {
        return `
          <div onclick="openMealModal('${mt.name}')" class="meal-card-hover bg-surface-container-lowest rounded-xl border border-dashed border-outline-variant p-sm flex items-center gap-md group cursor-pointer bg-surface/50">
            <div class="w-16 h-16 rounded-lg bg-surface-container-high flex items-center justify-center shrink-0">
              <span class="material-symbols-outlined text-outline text-[32px]">restaurant</span>
            </div>
            <div class="flex-1 min-w-0">
              <h3 class="font-headline-md text-outline">${mt.name}</h3>
              <p class="font-body-sm text-secondary">Not logged yet</p>
            </div>
            <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-container text-on-primary-container shadow-sm active:scale-90 transition-transform">
              <span class="material-symbols-outlined">add</span>
            </div>
          </div>
        `;
      }

      const sumCalories = logs.reduce((s, l) => s + parseInt(l.calories), 0);
      return `
        <div class="bg-surface-container-lowest rounded-xl border border-surface-variant p-sm flex items-center gap-md transition-all hover:shadow-md">
          <div class="w-16 h-16 rounded-lg bg-surface-container overflow-hidden shrink-0 flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-[28px]">restaurant_menu</span>
          </div>
          <div class="flex-1 min-w-0">
            <div class="flex justify-between items-start">
              <h3 class="font-headline-md text-on-surface truncate">${mt.name}</h3>
              <span class="font-label-caps text-primary px-2 py-1 bg-primary-fixed rounded">${sumCalories} KCAL</span>
            </div>
            <div class="flex flex-wrap gap-1 mt-1">
              ${logs.map(l => `<span class="font-body-sm text-secondary truncate border border-outline-variant/30 rounded-full px-2 py-0.5 text-[11px] flex items-center gap-1">${l.food_name} <button onclick="event.stopPropagation(); deleteLog(${l.id})" class="w-3.5 h-3.5 rounded-full bg-secondary/10 flex items-center justify-center hover:bg-secondary/30 transition-colors flex-shrink-0"><span class="material-symbols-outlined text-[10px] text-secondary">close</span></button></span>`).join('')}
            </div>
          </div>
          <button onclick="event.stopPropagation(); openMealModal('${mt.name}')" class="w-8 h-8 rounded-full bg-primary-container/50 flex items-center justify-center text-primary active:scale-90 transition-transform shrink-0">
            <span class="material-symbols-outlined text-[18px]">add</span>
          </button>
        </div>
      `;
    }).join('');

    document.getElementById('kcal-left').textContent = kcalLeft.toLocaleString();

    const macrosContainer = document.getElementById('macros-container');
    macrosContainer.innerHTML = `
      <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
        <span class="font-label-caps text-label-caps text-primary/70 uppercase">Protein</span>
        <p class="font-display-metrics text-headline-md text-primary">${totals.protein}g</p>
      </div>
      <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
        <span class="font-label-caps text-label-caps text-primary/70 uppercase">Carbs</span>
        <p class="font-display-metrics text-headline-md text-primary">${totals.carbs}g</p>
      </div>
      <div class="bg-primary/5 rounded-lg px-md py-sm flex items-center justify-between">
        <span class="font-label-caps text-label-caps text-primary/70 uppercase">KCAL</span>
        <p class="font-display-metrics text-headline-md text-primary">${totals.calories}</p>
      </div>
    `;

    updateRing(caloriesPercent);
  }

  renderMeals();

  // ── Delete Log ────────────────────────────────────────────
  window.deleteLog = async function (logId) {
    if (!confirm('Remove this item?')) return;
    const result = await Request.post('/ajax/nutrition', {
      action: 'delete',
      log_id: logId,
    });
    if (result.success) {
      const idx = today_logs.findIndex(l => l.id == logId);
      if (idx !== -1) {
        const removed = today_logs[idx];
        totals.calories -= parseInt(removed.calories);
        totals.protein -= parseInt(removed.protein);
        totals.carbs -= parseInt(removed.carbs);
        totals.fats -= parseInt(removed.fats);
        today_logs.splice(idx, 1);
        renderMeals();
      }
    } else {
      alert(result.message || 'Failed to delete.');
    }
  };

  // ── Load meals dropdown ───────────────────────────────────
  let meals = [];
  fetch('/assets/json/meal.json').then(r => r.json()).then(data => {
    meals = data;
    const select = document.getElementById('meal-select');
    meals.forEach(m => {
      const opt = document.createElement('option');
      opt.value = m.name;
      opt.textContent = m.name + ' (' + m.calories + ' kcal)';
      select.appendChild(opt);
    });
  }).catch(() => {});

  window.selectMeal = function (select) {
    const name = select.value;
    if (!name) return;
    const meal = meals.find(m => m.name === name);
    if (!meal) return;
    document.getElementById('custom-food-input').value = meal.name;
    document.getElementById('custom-calories').value = meal.calories;
    document.getElementById('custom-protein').value = meal.protein;
    document.getElementById('custom-carbs').value = meal.carbs;
    document.getElementById('custom-fats').value = meal.fats;
  };

  // ── Meal Modal ────────────────────────────────────────────
  window.openMealModal = function (mealType) {
    selectedMealType = mealType;
    document.getElementById('meal-modal-title').textContent = 'Log ' + mealType;
    document.getElementById('meal-modal').classList.remove('hidden');
    document.getElementById('meal-modal').classList.add('flex');
  };

  window.closeMealModal = function () {
    document.getElementById('meal-modal').classList.add('hidden');
    document.getElementById('meal-modal').classList.remove('flex');
    document.getElementById('custom-food-input').value = '';
    document.getElementById('custom-calories').value = '';
    document.getElementById('custom-protein').value = '';
    document.getElementById('custom-carbs').value = '';
    document.getElementById('custom-fats').value = '';
    document.getElementById('meal-select').value = '';
  };

  window.logCustomFood = async function () {
    const foodName = document.getElementById('custom-food-input').value.trim();
    const calories = parseInt(document.getElementById('custom-calories').value) || 0;
    const protein = parseInt(document.getElementById('custom-protein').value) || 0;
    const carbs = parseInt(document.getElementById('custom-carbs').value) || 0;
    const fats = parseInt(document.getElementById('custom-fats').value) || 0;

    if (!foodName || !calories) {
      alert('Enter a food name and calories.');
      return;
    }

    const result = await Request.post('/ajax/nutrition', {
      action: 'log',
      meal_type: selectedMealType,
      food_name: foodName,
      calories,
      protein,
      carbs,
      fats,
    });

    if (result.success) {
      today_logs.unshift(result.log);
      totals.calories += calories;
      totals.protein += protein;
      totals.carbs += carbs;
      totals.fats += fats;
      renderMeals();
      closeMealModal();
    } else {
      alert(result.message || 'Failed to log meal.');
    }
  };
});
