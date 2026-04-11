// Базовый URL API. В проде фронт и API на одном домене → относительный путь.
// В деве — прописать полный адрес хостинга или настроить Vite proxy в vite.config.js.
export const API_BASE = '/api'

async function request(path, options = {}) {
    const url = API_BASE + path
    const res = await fetch(url, {
        headers: options.body instanceof FormData
            ? {}
            : { 'Content-Type': 'application/json' },
        ...options,
    })
    if (!res.ok) {
        let message = 'Request failed: ' + res.status
        try {
            const data = await res.json()
            if (data && data.error) message = data.error
        } catch {}
        throw new Error(message)
    }
    if (res.status === 204) return null
    return res.json()
}

export const api = {
    get(path) { return request(path) },
    post(path, body) { return request(path, { method: 'POST', body: JSON.stringify(body) }) },
    put(path, body) { return request(path, { method: 'PUT', body: JSON.stringify(body) }) },
    del(path) { return request(path, { method: 'DELETE' }) },
    upload(path, file) {
        const fd = new FormData()
        fd.append('file', file)
        return request(path, { method: 'POST', body: fd })
    },
}
