import { reactive } from 'vue'
import { api } from '@/config/api.js'

export const contentStore = reactive({
    news: [],
    ministries: [],
    schedule: [],
    loaded: false,
    loading: false,
    error: '',

    async loadAll() {
        if (this.loading) return
        this.loading = true
        this.error = ''
        try {
            const data = await api.get('/content')
            this.news = Array.isArray(data.news) ? data.news : []
            this.ministries = Array.isArray(data.ministries) ? data.ministries : []
            this.schedule = Array.isArray(data.schedule) ? data.schedule : []
            this.loaded = true
        } catch (e) {
            this.error = e.message || 'Не удалось загрузить данные'
            console.error('[content] loadAll failed', e)
        } finally {
            this.loading = false
        }
    },

    async addEvent(day, event) {
        const created = await api.post('/schedule', { day, time: event.time || '', title: event.title || '' })
        const col = this.schedule.find(c => c.day === day)
        if (col) col.events.push({ id: created.id, time: created.time, title: created.title })
    },
    async updateEvent(day, eventId, patch) {
        const col = this.schedule.find(c => c.day === day)
        if (!col) return
        const i = col.events.findIndex(e => e.id === eventId)
        if (i === -1) return
        const next = { ...col.events[i], ...patch }
        await api.put('/schedule/' + eventId, { time: next.time || '', title: next.title || '' })
        col.events[i] = next
    },
    async removeEvent(day, eventId) {
        await api.del('/schedule/' + eventId)
        const col = this.schedule.find(c => c.day === day)
        if (!col) return
        const i = col.events.findIndex(e => e.id === eventId)
        if (i !== -1) col.events.splice(i, 1)
    },

    async addNews(item) {
        const payload = { title: '', description: '', date: '', image: '', ...item }
        const created = await api.post('/news', payload)
        this.news.unshift(created)
    },
    async updateNews(id, patch) {
        const i = this.news.findIndex(n => n.id === id)
        if (i === -1) return
        const next = { ...this.news[i], ...patch }
        const updated = await api.put('/news/' + id, next)
        this.news[i] = updated
    },
    async removeNews(id) {
        await api.del('/news/' + id)
        const i = this.news.findIndex(n => n.id === id)
        if (i !== -1) this.news.splice(i, 1)
    },

    async addMinistry(item) {
        const payload = { title: '', description: '', schedule: '', leader: '', image: '', ...item }
        const created = await api.post('/ministries', payload)
        this.ministries.push(created)
    },
    async updateMinistry(id, patch) {
        const i = this.ministries.findIndex(m => m.id === id)
        if (i === -1) return
        const next = { ...this.ministries[i], ...patch }
        const updated = await api.put('/ministries/' + id, next)
        this.ministries[i] = updated
    },
    async removeMinistry(id) {
        await api.del('/ministries/' + id)
        const i = this.ministries.findIndex(m => m.id === id)
        if (i !== -1) this.ministries.splice(i, 1)
    },
})
