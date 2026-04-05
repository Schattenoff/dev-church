export default {
  name: 'Добрая весть',
  tagline: 'Место встречи с Богом',

  contacts: {
    phone: '+375 44 461-68-62',
    address: 'Витебск, ул. Чайковского, 6',
  },

  socials: [
    { icon: 'instagram', url: 'https://instagram.com/', label: 'Instagram' },
  ],

  schedule: [
    { day: 'понедельник', events: [{ time: '19:00', title: 'Молодежка' }] },
    { day: 'вторник', events: [{ time: '19:00', title: 'Разбор Библии' }] },
    { day: 'среда', events: [] },
    { day: 'четверг', events: [{ time: '19:00', title: 'Молитва' }] },
    { day: 'пятница', events: [{ time: '19:00', title: 'Молодежная домашка' }] },
    { day: 'суббота', events: [] },
    { day: 'воскресенье', events: [
      { time: '10:00', title: 'Утреннее служение' },
      { time: '18:00', title: 'Вечернее служение' },
    ] },
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
