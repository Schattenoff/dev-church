export default {
  name: 'Добрая весть',
  tagline: 'Место встречи с Богом',

  colors: {
    primary: '#2AABCB',
    primaryDark: '#228FA8',
    text: '#1A1A1A',
    textSecondary: '#555555',
    background: '#FFFFFF',
    backgroundAlt: '#F5F7FA',
    footerBg: '#1A1A1A',
    footerText: '#CCCCCC',
  },

  contacts: {
    phone: '+375 44 461-68-62',
    address: 'Витебск, ул. Чайковского, 6',
  },

  socials: [
    // { icon: 'youtube', url: 'https://youtube.com/', label: 'YouTube' },
  ],

  navigation: [
    { label: 'Служения', href: '#services' },
    { label: 'Расписание', href: '#schedule' },
    { label: 'Новости', href: '#news' },
    { label: 'О нас', href: '#about' },
    { label: 'Контакты', href: '#contacts' },
  ],

  cta: {
    label: 'Пожертвовать',
    href: '#donate',
  },
}
