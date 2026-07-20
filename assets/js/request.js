/**
 * AJAX Request Helper
 * Wrapper around fetch() with JSON handling and error management.
 */

const Request = {
  async post(url, data) {
    try {
      const res = await fetch(url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        body: JSON.stringify(data),
      });
      return this.handleResponse(res);
    } catch (err) {
      return { success: false, message: 'Network error. Please try again.' };
    }
  },

  async get(url) {
    try {
      const res = await fetch(url, {
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
      });
      return this.handleResponse(res);
    } catch (err) {
      return { success: false, message: 'Network error. Please try again.' };
    }
  },

  async del(url) {
    try {
      const res = await fetch(url, {
        method: 'DELETE',
        headers: { 'Content-Type': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
      });
      return this.handleResponse(res);
    } catch (err) {
      return { success: false, message: 'Network error. Please try again.' };
    }
  },

  async handleResponse(res) {
    const contentType = res.headers.get('content-type') || '';
    if (!contentType.includes('application/json')) {
      return { success: false, message: 'Unexpected server response.' };
    }
    const data = await res.json();
    if (!res.ok) {
      return { success: false, message: data.message || 'Server error.' };
    }
    return data;
  },
};
