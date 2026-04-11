import { reactive } from 'vue'

const API_BASE = '/api'

export const growlStore = reactive({
    items: [],
})

let growlId = 0

function showGrowl(message, type = 'info') {
    if (!message) return
    const id = ++growlId
    growlStore.items.push({ id, message, type })
    setTimeout(() => {
        const i = growlStore.items.findIndex(x => x.id === id)
        if (i !== -1) growlStore.items.splice(i, 1)
    }, 4000)
}

function buildPayload(payload) {
    if (!payload) return { meta: {}, data: {} }
    return {
        meta: payload.meta || {},
        data: payload.data || {},
    }
}

function safeCallback(cb, res) {
    if (typeof cb === 'function') cb(res)
}

export const api = {
    fetch(url, payload, callback) {
        fetch(API_BASE + url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(buildPayload(payload)),
        })
            .then(res => res.json())
            .then(data => safeCallback(callback, data))
            .catch(err => {
                console.error('[api]', url, err)
                safeCallback(callback, { error: true, message: 'Ошибка сети' })
            })
    },
    upload(url, file, callback) {
        const fd = new FormData()
        fd.append('file', file)
        fetch(API_BASE + url, { method: 'POST', body: fd })
            .then(res => res.json())
            .then(data => safeCallback(callback, data))
            .catch(err => {
                console.error('[api upload]', url, err)
                safeCallback(callback, { error: true, message: 'Ошибка сети' })
            })
    },
    growl: showGrowl,
}
