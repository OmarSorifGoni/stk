const translations = {
  ja: {
    siteTitle: '留学生サポートサイト',
    siteSubtitle: '日本で生活する留学生を応援します',
    pageTitle: {
      index: '留学生サポートサイト',
      university: '大学情報',
      senmon: '専門学校情報',
      job: 'アルバイト情報',
      life: '生活サポート',
      contact: 'お問い合わせ'
    },
    nav: {
      home: 'ホーム',
      university: '🎓大学情報',
      senmon: '🎓専門学校情報',
      job: '✨ アルバイト',
      life: '🏠生活サポート',
      contact: '📩お問い合わせ'
    },
    heroTitle: 'Welcome International Students',
    heroText: '大学・仕事・生活情報を簡単に探せます。',
    heroButton: '大学情報を見る',
    card1Title: '🌍 多言語対応',
    card1Text: '日本語・English・বাংলা に対応できます。',
    card2Title: '📱 スマホ完全対応',
    card2Text: 'スマホ・タブレット・PCで快適に使えます。',
    card3Title: '🤖 AIチャット',
    card3Text: '必要に応じてAI相談を利用できます。',
    jobTitle: '留学生歓迎アルバイト',
    jobText: 'コンビニ、レストラン、ホテルなど。',
    supportTitle: '面接サポート',
    supportText: '履歴書や日本語面接の練習もできます。',
    lifeTitle: '🏠 家探し',
    lifeText: '寮・アパート情報を紹介できます。',
    travelTitle: '🚆 交通情報',
    travelText: '空港からの移動や電車情報。',
    clinicTitle: '🏥 病院情報',
    clinicText: '外国人対応病院を探せます。',
    contactTitle: 'お問い合わせフォーム',
    contactName: '名前',
    contactEmail: 'メール',
    contactMessage: 'お問い合わせ内容を入力してください',
    submit: '送信',
    sending: '送信中...',
    success: 'お問い合わせを送信しました。',
    error: '送信に失敗しました。時間をおいて再度お試しください。',
    chatGreeting: 'こんにちは。留学・学校・生活のことで相談できます。何を知りたいですか？',
    chatPlaceholder: '例: 大学選びを教えて',
    chatSend: '送信',
    chatError: '送信できませんでした。もう一度お試しください。',
    footer: '© 2026 留学生サポートサイト'
  },
  en: {
    siteTitle: 'International Student Support',
    siteSubtitle: 'Supporting international students living in Japan',
    pageTitle: {
      index: 'International Student Support',
      university: 'University Information',
      senmon: 'Vocational School Information',
      job: 'Part-time Job Information',
      life: 'Life Support',
      contact: 'Contact Us'
    },
    nav: {
      home: 'Home',
      university: '🎓 University',
      senmon: '🎓 Vocational Schools',
      job: '✨ Jobs',
      life: '🏠 Life Support',
      contact: '📩 Contact'
    },
    heroTitle: 'Welcome International Students',
    heroText: 'Easily find university, job, and daily life information.',
    heroButton: 'View University Info',
    card1Title: '🌍 Multi-language support',
    card1Text: 'Available in Japanese, English, and Bengali.',
    card2Title: '📱 Mobile-friendly design',
    card2Text: 'Works smoothly on smartphones, tablets, and PCs.',
    card3Title: '🤖 AI Chat',
    card3Text: 'You can use AI consultation whenever needed.',
    jobTitle: 'Part-time Jobs for International Students',
    jobText: 'Convenience stores, restaurants, hotels, and more.',
    supportTitle: 'Interview Support',
    supportText: 'Practice resumes and Japanese interview skills.',
    lifeTitle: '🏠 Housing Search',
    lifeText: 'We can introduce dormitory and apartment options.',
    travelTitle: '🚆 Transport Info',
    travelText: 'Airport transfers and train information.',
    clinicTitle: '🏥 Hospital Information',
    clinicText: 'Find hospitals that support foreigners.',
    contactTitle: 'Contact Form',
    contactName: 'Name',
    contactEmail: 'Email',
    contactMessage: 'Please enter your message',
    submit: 'Send',
    sending: 'Sending...',
    success: 'Your message has been sent successfully.',
    error: 'Sending failed. Please try again later.',
    chatGreeting: 'Hello. You can ask about study, school, or daily life in Japan. What would you like to know?',
    chatPlaceholder: 'Example: Help me choose a university',
    chatSend: 'Send',
    chatError: 'Could not send the message. Please try again.',
    footer: '© 2026 International Student Support'
  }
};

const defaultLanguage = () => {
  const urlLang = new URLSearchParams(window.location.search).get('lang');
  if (urlLang && translations[urlLang]) return urlLang;

  localStorage.setItem('preferredLanguage', 'ja');
  return 'ja';
};

function getTranslationValue(lang, key) {
  return key.split('.').reduce((obj, part) => obj && obj[part], translations[lang]);
}

function applyTranslations(lang) {
  const current = translations[lang] || translations.ja;
  const pageKey = document.body.dataset.page || 'index';
  document.documentElement.lang = lang;
  document.title = current.pageTitle?.[pageKey] || current.siteTitle;

  document.querySelectorAll('[data-i18n]').forEach((element) => {
    const value = getTranslationValue(lang, element.dataset.i18n);
    if (value) {
      element.textContent = value;
    }
  });

  document.querySelectorAll('[data-i18n-title]').forEach((element) => {
    const value = getTranslationValue(lang, element.dataset.i18nTitle);
    if (value) {
      element.setAttribute('title', value);
    }
  });

  document.querySelectorAll('[data-i18n-placeholder]').forEach((element) => {
    const value = getTranslationValue(lang, element.dataset.i18nPlaceholder);
    if (value) {
      element.setAttribute('placeholder', value);
    }
  });

  document.querySelectorAll('.lang-btn').forEach((button) => {
    const isActive = button.dataset.lang === lang;
    button.classList.toggle('is-active', isActive);
    button.setAttribute('aria-pressed', String(isActive));
  });

  localStorage.setItem('preferredLanguage', lang);
}

document.addEventListener('DOMContentLoaded', () => {
  const lang = defaultLanguage();
  applyTranslations(lang);

  document.querySelectorAll('.lang-btn').forEach((button) => {
    button.addEventListener('click', () => {
      applyTranslations(button.dataset.lang);
    });
  });
});
