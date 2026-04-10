// UI-only auth stub. Not real security — anyone can bypass in devtools.
import { reactive } from 'vue'

const STORAGE_KEY = 'dc_auth'
const VALID_USER = 'admin'
const VALID_PASS = 'admin'

export const authStore = reactive({
    isAuthed: typeof localStorage !== 'undefined' && localStorage.getItem(STORAGE_KEY) === '1',

    login(username, password) {
        if (username === VALID_USER && password === VALID_PASS) {
            localStorage.setItem(STORAGE_KEY, '1')
            this.isAuthed = true
            return true
        }
        return false
    },

    logout() {
        localStorage.removeItem(STORAGE_KEY)
        this.isAuthed = false
    },
})
