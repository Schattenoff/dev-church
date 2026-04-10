import { reactive } from 'vue'
import siteConfig from '@/config/site.js'

const NEWS_KEY = 'dc_news'
const MINISTRIES_KEY = 'dc_ministries'
const SCHEDULE_KEY = 'dc_schedule'

const seedNews = [
    { id: 'seed-n-1', title: 'Рукоположение на дьяконское служение', description: '', date: '', image: '' },
    { id: 'seed-n-2', title: 'Расписание на рождественские праздники', description: '', date: '', image: '' },
    { id: 'seed-n-3', title: 'Концерт «В ожидании Рождества»', description: '', date: '', image: '' },
    { id: 'seed-n-4', title: 'Благотворительная акция', description: '', date: '', image: '' },
]

const seedMinistries = [
    { id: 'seed-m-1', title: 'Воскресное богослужение', description: '', schedule: '', leader: '', image: '' },
    { id: 'seed-m-2', title: 'Молодёжное служение', description: '', schedule: '', leader: '', image: '' },
    { id: 'seed-m-3', title: 'Детское служение', description: '', schedule: '', leader: '', image: '' },
    { id: 'seed-m-4', title: 'Служение прославления', description: '', schedule: '', leader: '', image: '' },
]

function load(key, seed) {
    try {
        const raw = localStorage.getItem(key)
        if (!raw) {
            localStorage.setItem(key, JSON.stringify(seed))
            return [...seed]
        }
        const parsed = JSON.parse(raw)
        return Array.isArray(parsed) ? parsed : [...seed]
    } catch {
        return [...seed]
    }
}

function save(key, items) {
    try {
        localStorage.setItem(key, JSON.stringify(items))
    } catch (e) {
        console.error('[content] localStorage save failed', e)
    }
}

function newId() {
    if (typeof crypto !== 'undefined' && crypto.randomUUID) return crypto.randomUUID()
    return 'id-' + Date.now() + '-' + Math.random().toString(36).slice(2, 8)
}

const seedSchedule = siteConfig.schedule.map(col => ({
    day: col.day,
    events: col.events.map(e => ({ id: newId(), time: e.time, title: e.title })),
}))

export const contentStore = reactive({
    news: load(NEWS_KEY, seedNews),
    ministries: load(MINISTRIES_KEY, seedMinistries),
    schedule: load(SCHEDULE_KEY, seedSchedule),

    addEvent(day, event) {
        const col = this.schedule.find(c => c.day === day)
        if (!col) return
        col.events.push({ id: newId(), time: '', title: '', ...event })
        save(SCHEDULE_KEY, this.schedule)
    },
    updateEvent(day, eventId, patch) {
        const col = this.schedule.find(c => c.day === day)
        if (!col) return
        const i = col.events.findIndex(e => e.id === eventId)
        if (i !== -1) {
            col.events[i] = { ...col.events[i], ...patch }
            save(SCHEDULE_KEY, this.schedule)
        }
    },
    removeEvent(day, eventId) {
        const col = this.schedule.find(c => c.day === day)
        if (!col) return
        const i = col.events.findIndex(e => e.id === eventId)
        if (i !== -1) {
            col.events.splice(i, 1)
            save(SCHEDULE_KEY, this.schedule)
        }
    },

    addNews(item) {
        this.news.unshift({ id: newId(), title: '', description: '', date: '', image: '', ...item })
        save(NEWS_KEY, this.news)
    },
    updateNews(id, patch) {
        const i = this.news.findIndex(n => n.id === id)
        if (i !== -1) {
            this.news[i] = { ...this.news[i], ...patch }
            save(NEWS_KEY, this.news)
        }
    },
    removeNews(id) {
        const i = this.news.findIndex(n => n.id === id)
        if (i !== -1) {
            this.news.splice(i, 1)
            save(NEWS_KEY, this.news)
        }
    },

    addMinistry(item) {
        this.ministries.push({ id: newId(), title: '', description: '', schedule: '', leader: '', image: '', ...item })
        save(MINISTRIES_KEY, this.ministries)
    },
    updateMinistry(id, patch) {
        const i = this.ministries.findIndex(m => m.id === id)
        if (i !== -1) {
            this.ministries[i] = { ...this.ministries[i], ...patch }
            save(MINISTRIES_KEY, this.ministries)
        }
    },
    removeMinistry(id) {
        const i = this.ministries.findIndex(m => m.id === id)
        if (i !== -1) {
            this.ministries.splice(i, 1)
            save(MINISTRIES_KEY, this.ministries)
        }
    },
})
