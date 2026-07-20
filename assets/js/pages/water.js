/**
 * Water Page Handler
 * Fetches, creates, and deletes water log entries via AJAX.
 */

document.addEventListener('DOMContentLoaded', () => {
  const logContainer = document.getElementById('water-log-container');
  const litersEl = document.getElementById('current-liters');
  const msgEl = document.getElementById('hydration-msg');
  const ring = document.querySelector('.progress-ring-circle');
  const circumference = 691;

  let totalMl = 0;
  let goalLiters = 2.5;
  let pendingDeleteBtn = null;
  let pendingDeleteAmount = 0;
  let pendingDeleteId = 0;

  function updateProgress() {
    const liters = totalMl / 1000;
    const percent = Math.min(100, Math.round((liters / goalLiters) * 100));
    litersEl.textContent = liters.toFixed(1);
    msgEl.textContent = percent >= 100
      ? 'You hit your goal! Great job staying hydrated!'
      : `You're ${percent}% hydrated today. Keep pushing!`;
    const offset = Math.max(0, circumference - (percent / 100 * circumference));
    if (ring) ring.style.strokeDashoffset = offset;
  }

  function prependLog(log) {
    const now = new Date();
    const timeStr = log.time || now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
    const displayLabel = log.description || 'Manual Entry';

    const newItem = document.createElement('div');
    newItem.className = 'flex items-center justify-between p-sm bg-surface-container-lowest border border-outline-variant/30 rounded-xl opacity-0 translate-y-4 transition-all duration-300';
    newItem.setAttribute('data-id', log.id);
    newItem.innerHTML = `
      <div class="flex items-center gap-sm">
        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
          <span class="material-symbols-outlined text-primary">local_drink</span>
        </div>
        <div>
          <p class="font-body-lg font-bold text-on-surface">${log.amount}ml</p>
          <p class="font-body-sm text-secondary">${displayLabel}</p>
        </div>
      </div>
      <div class="flex items-center gap-xs">
        <p class="font-label-caps text-label-caps text-secondary-fixed-dim">${timeStr}</p>
        <button onclick="confirmDelete(this, ${log.amount}, ${log.id})" class="w-8 h-8 rounded-full flex items-center justify-center text-secondary hover:text-error hover:bg-error-container/30 transition-colors active:scale-90">
          <span class="material-symbols-outlined text-[18px]">delete</span>
        </button>
      </div>
    `;
    logContainer.prepend(newItem);
    setTimeout(() => newItem.classList.remove('opacity-0', 'translate-y-4'), 10);
  }

  // ── Load today's logs ──────────────────────────────────────────
  (async function loadLogs() {
    const result = await Request.get('/ajax/water_log');
    if (result.success) {
      totalMl = result.total_ml || 0;
      goalLiters = result.goal_liters || 2.5;
      (result.logs || []).forEach(prependLog);
      updateProgress();
    }
  })();

  // ── Quick add buttons ──────────────────────────────────────────
  window.logWater = async function (amount, label) {
    const result = await Request.post('/ajax/water_log', {
      amount: amount,
      description: label || 'Manual Entry',
    });
    if (result.success) {
      totalMl += amount;
      prependLog(result.log);
      updateProgress();
    }
  };

  // ── Custom volume modal ────────────────────────────────────────
  window.openCustomVolumeModal = function () {
    const modal = document.getElementById('custom-volume-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  };

  window.closeCustomVolumeModal = function () {
    const modal = document.getElementById('custom-volume-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  };

  window.confirmCustomVolume = function () {
    const input = document.getElementById('custom-ml');
    const descInput = document.getElementById('custom-desc');
    const amount = parseInt(input.value);
    const label = descInput.value.trim();
    if (amount > 0) {
      logWater(amount, label || '');
      input.value = '300';
      descInput.value = '';
      closeCustomVolumeModal();
    }
  };

  // ── Delete ─────────────────────────────────────────────────────
  window.confirmDelete = function (btn, amount, id) {
    pendingDeleteBtn = btn.closest('.flex.items-center.justify-between');
    pendingDeleteAmount = amount;
    pendingDeleteId = id;
    document.getElementById('delete-modal-desc').textContent = `This will remove ${amount}ml and adjust your progress.`;
    const modal = document.getElementById('confirm-delete-modal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  };

  window.closeConfirmDelete = function () {
    const modal = document.getElementById('confirm-delete-modal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
    pendingDeleteBtn = null;
    pendingDeleteAmount = 0;
    pendingDeleteId = 0;
  };

  window.executeDelete = async function () {
    if (pendingDeleteBtn && pendingDeleteId) {
      const result = await Request.del('/ajax/water_log?id=' + pendingDeleteId);
      if (result.success) {
        totalMl = Math.max(0, totalMl - pendingDeleteAmount);
        pendingDeleteBtn.style.transition = 'opacity 0.2s, transform 0.2s';
        pendingDeleteBtn.style.opacity = '0';
        pendingDeleteBtn.style.transform = 'translateX(20px)';
        setTimeout(() => pendingDeleteBtn.remove(), 200);
        updateProgress();
      }
    }
    closeConfirmDelete();
  };
});
