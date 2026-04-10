import { createRouter, createWebHistory } from 'vue-router'
import { authStore } from '@/composables/useAuth.js'

import Home from '@/pages/Home.vue'
import Stub from '@/modules/stub/Stub.vue'
import Login from '@/pages/admin/Login.vue'
import AdminLayout from '@/pages/admin/AdminLayout.vue'
import Dashboard from '@/pages/admin/Dashboard.vue'
import NewsAdmin from '@/pages/admin/NewsAdmin.vue'
import MinistriesAdmin from '@/pages/admin/MinistriesAdmin.vue'
import ScheduleAdmin from '@/pages/admin/ScheduleAdmin.vue'

const isDev = import.meta.env.DEV

const routes = [
    {
        path: '/',
        name: 'home',
        component: isDev ? Home : Stub,
    },
    {
        path: '/admin/login',
        name: 'admin-login',
        component: Login,
    },
    {
        path: '/admin',
        component: AdminLayout,
        meta: { requiresAuth: true },
        children: [
            { path: '', name: 'admin-dashboard', component: Dashboard },
            { path: 'news', name: 'admin-news', component: NewsAdmin },
            { path: 'ministries', name: 'admin-ministries', component: MinistriesAdmin },
            { path: 'schedule', name: 'admin-schedule', component: ScheduleAdmin },
        ],
    },
    { path: '/:pathMatch(.*)*', redirect: '/' },
]

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) return savedPosition
        if (to.hash) return { el: to.hash, behavior: 'smooth', top: 80 }
        return { top: 0 }
    },
})

router.beforeEach((to) => {
    if (to.meta.requiresAuth && !authStore.isAuthed) {
        return { name: 'admin-login', query: { redirect: to.fullPath } }
    }
    if (to.name === 'admin-login' && authStore.isAuthed) {
        return { name: 'admin-dashboard' }
    }
})

export default router
