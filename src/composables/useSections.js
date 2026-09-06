import { reactive } from 'vue'
import { api } from '@/config/fetch.js'

const REQUESTS = [
    ['services', '/ministries/get', 'ministries'],
    ['schedule', '/schedule/get', 'schedule'],
    ['news', '/news/get', 'news'],
]

export const sectionsStore = reactive({
    services: [],
    schedule: [],
    news: [],
    ready: false,
    loading: false,

    get hasServices() { return this.services.length > 0 },
    get hasNews() { return this.news.length > 0 },
    get hasSchedule() { return this.schedule.some(col => col.events && col.events.length > 0) },

    load() {
        if (this.ready || this.loading) return
        this.loading = true
        let pending = REQUESTS.length
        REQUESTS.forEach(([key, url, field]) => {
            api.fetch(url, null, (res) => {
                if (res.error) api.growl(res.message, 'danger')
                else this[key] = res[field] || []
                if (--pending === 0) {
                    this.ready = true
                    this.loading = false
                }
            })
        })
    },
})

const HREF_TO_KEY = {
    '/#services': 'hasServices',
    '/#schedule': 'hasSchedule',
    '/#news': 'hasNews',
}

export function filterNavigation(items) {
    if (!sectionsStore.ready) return []
    return items.filter(item => {
        const key = HREF_TO_KEY[item.href]
        return key ? sectionsStore[key] : true
    })
}
