const User = {
  KEY: 'redwellness_user',

  set(data) {
    const payload = {
      id: data.id,
      name: data.name,
      email: data.email,
      avatar_url: data.avatar_url || null,
    };
    const encoded = encodeURIComponent(JSON.stringify(payload));
    document.cookie = this.KEY + '=' + encoded + '; path=/; max-age=' + (7 * 86400) + '; SameSite=Lax';
  },

  get() {
    try {
      const match = document.cookie.match(new RegExp('(?:^|; )' + this.KEY + '=([^;]*)'));
      if (!match) return null;
      return JSON.parse(decodeURIComponent(match[1]));
    } catch {
      return null;
    }
  },

  clear() {
    document.cookie = this.KEY + '=; path=/; max-age=0; SameSite=Lax';
  },

  initials() {
    const user = this.get();
    if (!user || !user.name) return '?';
    return user.name
      .split(/\s+/)
      .map((w) => w[0])
      .join('')
      .toUpperCase()
      .slice(0, 2);
  },

  avatarUrl() {
    const user = this.get();
    if (user?.avatar_url) return user.avatar_url;
    return null;
  },
};
