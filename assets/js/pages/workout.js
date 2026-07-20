document.addEventListener('DOMContentLoaded', async () => {
  const data = await Request.get('/ajax/workout');
  if (!data.success) return;

  const { exercises, plan, logged_exercise_ids, today_day, morning_routine } = data;

  function getLocalCompletedIds() {
    const today = new Date().toISOString().split('T')[0];
    try {
      const stored = JSON.parse(localStorage.getItem('redwellness_completed_today') || '{}');
      if (stored.date === today && Array.isArray(stored.ids)) return stored.ids;
    } catch (_) {}
    return [];
  }

  const loggedSet = new Set([...logged_exercise_ids, ...getLocalCompletedIds()]);
  let selectedDay = today_day;

  const dayNames = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
  const container = document.getElementById('today-exercises-container');

  function getPlanForDay(day) {
    return plan.filter(p => p.day_of_week === day);
  }

  function renderExercises() {
    const currentPlan = getPlanForDay(selectedDay);
    const completedCount = currentPlan.filter(p => loggedSet.has(parseInt(p.exercise_id))).length;

    const allDone = selectedDay === today_day && currentPlan.length > 0 && completedCount === currentPlan.length;
    container.innerHTML = (allDone ? '<div class="flex items-center gap-2 bg-tertiary/10 border border-tertiary/20 rounded-xl px-md py-sm mb-sm"><span class="material-symbols-outlined text-tertiary fill-icon">check_circle</span><span class="font-body-sm font-semibold text-tertiary">All done for today!</span></div>' : '') + currentPlan.map(p => {
      const isCompleted = loggedSet.has(parseInt(p.exercise_id));
      return `
        <div class="exercise-card ${isCompleted ? 'completed' : ''} bg-surface-container-lowest border border-outline-variant p-sm rounded-xl flex items-center gap-md group cursor-pointer hover:shadow-sm no-underline text-on-surface" onclick="window.location.href='/exercise?id=${p.exercise_id}'">
          <div class="w-14 h-14 rounded-lg bg-surface-container overflow-hidden flex-shrink-0 relative flex items-center justify-center">
            <span class="material-symbols-outlined text-primary text-[28px]">fitness_center</span>
            ${isCompleted ? '<div class="absolute inset-0 bg-primary/20 flex items-center justify-center"><span class="material-symbols-outlined text-on-primary fill-icon">check</span></div>' : ''}
          </div>
          <div class="flex-grow min-w-0">
            <span class="font-label-caps text-label-caps text-primary">${p.category || 'General'}</span>
            <h4 class="font-headline-md text-headline-md leading-tight truncate">${p.name}</h4>
            <p class="font-body-sm text-body-sm text-on-surface-variant">${p.sets} Sets \u2022 ${p.reps} Reps</p>
          </div>
          <div class="flex items-center">
            <span class="material-symbols-outlined text-secondary group-hover:translate-x-0.5 transition-transform">chevron_right</span>
          </div>
        </div>
      `;
    }).join('') || '<p class="font-body-sm text-secondary text-center py-sm">No exercises planned for ' + selectedDay + '. Tap the tune icon to add some.</p>';

    const totalEl = document.getElementById('summary-total');
    const doneEl = document.getElementById('summary-done');
    const leftEl = document.getElementById('summary-left');
    if (totalEl) totalEl.textContent = currentPlan.length;
    if (doneEl) doneEl.textContent = completedCount;
    if (leftEl) leftEl.textContent = currentPlan.length - completedCount;
  }

  renderExercises();

  // ── Config modal ──────────────────────────────────────────────
  const allExercises = exercises.map(e => e.name);

  window.openConfigModal = function () {
    document.getElementById('config-modal').classList.remove('hidden');
    document.getElementById('config-modal').classList.add('flex');
  };

  window.closeConfigModal = function () {
    document.getElementById('config-modal').classList.add('hidden');
    document.getElementById('config-modal').classList.remove('flex');
  };

  plan.forEach(p => {
    const tagsEl = document.getElementById('tags-' + p.day_of_week);
    if (!tagsEl) return;
    addTagElement(tagsEl, p.day_of_week, p);
  });

  function addTagElement(container, day, p) {
    const tag = document.createElement('span');
    tag.className = 'exercise-tag flex items-center gap-1 bg-primary/10 border border-primary/30 text-primary rounded-full px-3 py-1 text-sm';
    tag.setAttribute('data-plan-id', p.id || p.id === 0 ? p.id : '');
    tag.innerHTML = `${p.name} <button onclick="removePlanItem(this, '${day}', ${p.id || 0})" class="w-4 h-4 rounded-full bg-primary/20 flex items-center justify-center hover:bg-primary/40 transition-colors"><span class="material-symbols-outlined text-[12px] text-primary">close</span></button>`;
    container.appendChild(tag);
  }

  window.removePlanItem = async function (btn, day, planId) {
    const result = await Request.post('/ajax/workout', {
      action: 'remove_from_plan',
      plan_id: planId,
    });
    if (result.success) {
      btn.closest('.exercise-tag').remove();
      const removedPlan = plan.find(p => (p.id || 0) == planId);
      if (removedPlan && removedPlan.day_of_week === selectedDay) {
        plan.splice(plan.indexOf(removedPlan), 1);
        renderExercises();
      }
    }
  };

  window.addExercise = async function (day) {
    const input = document.getElementById('input-' + day);
    const name = input.value.trim();
    if (!name) return;

    const ex = exercises.find(e => e.name === name);
    if (!ex) {
      alert('Exercise not found in the library.');
      return;
    }

    const result = await Request.post('/ajax/workout', {
      action: 'add_to_plan',
      day_of_week: day,
      exercise_id: ex.id,
      sets: 3,
      reps: 10,
    });

    if (result.success) {
      const tagsEl = document.getElementById('tags-' + day);
      addTagElement(tagsEl, day, result.plan);
      input.value = '';

      plan.push(result.plan);
      if (day === selectedDay) {
        renderExercises();
      }
    } else {
      alert(result.message || 'Failed to add exercise.');
    }
  };

  window.removeExercise = function (btn, day) {
    const tag = btn.closest('.exercise-tag');
    const planId = tag.getAttribute('data-plan-id');
    if (planId) {
      removePlanItem(btn, day, parseInt(planId));
    } else {
      tag.remove();
    }
  };

  window.filterSuggestions = function (input, day) {
    const query = input.value.trim().toLowerCase();
    const container = document.getElementById('suggestions-' + day);
    const existing = Array.from(document.querySelectorAll('#tags-' + day + ' .exercise-tag'))
      .map(el => el.childNodes[0].textContent.trim());
    const filtered = allExercises.filter(name =>
      !existing.includes(name) && (query === '' || name.toLowerCase().includes(query))
    );

    if (filtered.length === 0) {
      container.classList.add('hidden');
      return;
    }

    container.innerHTML = filtered.map(name =>
      `<button onmousedown="selectSuggestion('${day}', '${name}')" class="w-full text-left px-3 py-2 font-body-sm text-on-surface hover:bg-primary/5 transition-colors">${name}</button>`
    ).join('');
    container.classList.remove('hidden');
  };

  window.hideSuggestions = function (day) {
    document.getElementById('suggestions-' + day).classList.add('hidden');
  };

  window.selectSuggestion = function (day, name) {
    document.getElementById('input-' + day).value = name;
    addExercise(day);
  };

  // ── Morning routine ───────────────────────────────────────────
  const morningContainer = document.getElementById('morning-routine-container');

  function renderMorningRoutine() {
    morningContainer.innerHTML = (morning_routine || []).map(item => `
      <div class="exercise-card bg-surface-container-lowest border border-outline-variant p-sm rounded-xl flex items-center gap-md group cursor-pointer hover:shadow-sm" onclick="window.location.href='/exercise?id=${item.exercise_id}'">
        <div class="w-12 h-12 rounded-full bg-surface-container flex items-center justify-center flex-shrink-0">
          <span class="material-symbols-outlined text-primary">wb_sunny</span>
        </div>
        <div class="flex-grow min-w-0">
          <h4 class="font-headline-md text-body-lg font-semibold">${item.name}</h4>
          <p class="font-body-sm text-body-sm text-on-surface-variant">${item.category || ''}</p>
        </div>
        <div class="flex items-center">
          <div class="check-icon hidden">
            <span class="material-symbols-outlined text-[20px] text-tertiary fill-icon">check_circle</span>
          </div>
          <span class="material-symbols-outlined text-[20px] text-secondary group-hover:translate-x-1 transition-transform">chevron_right</span>
        </div>
      </div>
    `).join('') || '<p class="font-body-sm text-secondary text-center py-sm">No morning routine set. Tap the tune icon to add exercises.</p>';
  }

  renderMorningRoutine();

  let morningChanged = false;

  window.openMorningConfig = function () {
    const modal = document.getElementById('morning-config-modal');
    const tagsEl = document.getElementById('morning-tags');
    tagsEl.innerHTML = '';
    (morning_routine || []).forEach(item => {
      addMorningTag(tagsEl, item);
    });
    morningChanged = false;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  };

  window.closeMorningConfig = function () {
    document.getElementById('morning-config-modal').classList.add('hidden');
    document.getElementById('morning-config-modal').classList.remove('flex');
  };

  window.saveMorningConfig = function () {
    closeMorningConfig();
  };

  window.cancelMorningConfig = function () {
    const tagsEl = document.getElementById('morning-tags');
    tagsEl.innerHTML = '';
    (morning_routine || []).forEach(item => {
      addMorningTag(tagsEl, item);
    });
    closeMorningConfig();
  };

  function addMorningTag(container, item) {
    const tag = document.createElement('span');
    tag.className = 'exercise-tag flex items-center gap-1 bg-primary/10 border border-primary/30 text-primary rounded-full px-3 py-1 text-sm';
    tag.setAttribute('data-morning-id', item.id);
    tag.innerHTML = `${item.name} <button onclick="removeMorningItem(this, ${item.id})" class="w-4 h-4 rounded-full bg-primary/20 flex items-center justify-center hover:bg-primary/40 transition-colors"><span class="material-symbols-outlined text-[12px] text-primary">close</span></button>`;
    container.appendChild(tag);
  }

  window.addMorningExercise = async function () {
    const input = document.getElementById('morning-input');
    const name = input.value.trim();
    if (!name) return;

    const ex = exercises.find(e => e.name === name);
    if (!ex) {
      alert('Exercise not found in the library.');
      return;
    }

    const result = await Request.post('/ajax/workout', {
      action: 'add_morning',
      exercise_id: ex.id,
    });

    if (result.success) {
      const tagsEl = document.getElementById('morning-tags');
      addMorningTag(tagsEl, result.item);
      input.value = '';

      morning_routine.push(result.item);
      morningChanged = true;
      renderMorningRoutine();
    } else {
      alert(result.message || 'Failed to add.');
    }
  };

  window.removeMorningItem = async function (btn, itemId) {
    const result = await Request.post('/ajax/workout', {
      action: 'remove_morning',
      item_id: itemId,
    });
    if (result.success) {
      btn.closest('.exercise-tag').remove();
      const idx = morning_routine.findIndex(m => m.id == itemId);
      if (idx !== -1) {
        morning_routine.splice(idx, 1);
        morningChanged = true;
        renderMorningRoutine();
      }
    }
  };

  window.filterMorningSuggestions = function (input) {
    const query = input.value.trim().toLowerCase();
    const container = document.getElementById('morning-suggestions');
    const existing = Array.from(document.querySelectorAll('#morning-tags .exercise-tag'))
      .map(el => el.childNodes[0].textContent.trim());
    const filtered = allExercises.filter(name =>
      !existing.includes(name) && (query === '' || name.toLowerCase().includes(query))
    );

    if (filtered.length === 0) {
      container.classList.add('hidden');
      return;
    }

    container.innerHTML = filtered.map(name =>
      `<button onmousedown="selectMorningSuggestion('${name}')" class="w-full text-left px-3 py-2 font-body-sm text-on-surface hover:bg-primary/5 transition-colors">${name}</button>`
    ).join('');
    container.classList.remove('hidden');
  };

  window.hideMorningSuggestions = function () {
    document.getElementById('morning-suggestions').classList.add('hidden');
  };

  window.selectMorningSuggestion = function (name) {
    document.getElementById('morning-input').value = name;
    addMorningExercise();
  };

  // ── Day selector ──────────────────────────────────────────────
  window.selectDay = function (btn) {
    const pills = document.querySelectorAll('.day-pill');
    pills.forEach((pill, i) => {
      pill.classList.remove('bg-primary', 'text-white', 'border-primary');
      pill.classList.add('bg-surface-container-lowest', 'text-secondary', 'border-outline-variant');
      pill.querySelectorAll('span').forEach(span => {
        span.classList.remove('text-white/80', 'text-white', 'text-white/60');
        if (span.classList.contains('font-display-metrics')) {
          span.classList.add('text-on-surface');
        } else if (span.textContent.length <= 3) {
          span.classList.add('text-secondary');
        } else {
          span.classList.add('text-secondary/60');
        }
      });
    });
    btn.classList.remove('bg-surface-container-lowest', 'border-outline-variant');
    btn.classList.add('bg-primary', 'text-white', 'border-primary');
    btn.querySelectorAll('span').forEach(span => {
      span.classList.remove('text-secondary', 'text-on-surface', 'text-secondary/60');
      if (span.classList.contains('font-display-metrics')) {
        span.classList.add('text-white');
      } else if (span.textContent.length <= 3) {
        span.classList.add('text-white/80');
      } else {
        span.classList.add('text-white/60');
      }
    });

    selectedDay = dayNames[Array.from(pills).indexOf(btn)];
    renderExercises();
  };
});
