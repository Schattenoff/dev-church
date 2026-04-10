<script>
import { authStore } from '@/composables/useAuth.js'

export default {
    name: 'AdminLayout',
    computed: {
        links() {
            return [
                { to: '/admin', label: 'Обзор', exact: true },
                { to: '/admin/news', label: 'Новости' },
                { to: '/admin/ministries', label: 'Служения' },
                { to: '/admin/schedule', label: 'Расписание' },
            ]
        },
    },
    methods: {
        onLogout() {
            authStore.logout()
            this.$router.push('/admin/login')
        },
    },
}
</script>

<template>
    <div class="admin">
        <aside class="admin__sidebar">
            <div class="admin__brand">Админ-панель</div>
            <nav class="admin__nav">
                <router-link
                    v-for="link in links"
                    :key="link.to"
                    :to="link.to"
                    :exact-active-class="link.exact ? 'admin__navLink--active' : ''"
                    active-class="admin__navLink--active"
                    class="admin__navLink"
                >
                    {{ link.label }}
                </router-link>
            </nav>
            <div class="admin__footer">
                <router-link to="/" class="admin__footerLink">← На сайт</router-link>
                <button class="admin__logout" @click="onLogout">Выйти</button>
            </div>
        </aside>
        <main class="admin__main">
            <router-view />
        </main>
    </div>
</template>

<style src="./admin.css"></style>
