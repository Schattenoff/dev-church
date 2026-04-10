<script>
import { contentStore } from '@/composables/useContent.js'

export default {
    name: 'AdminDashboard',
    computed: {
        newsCount() { return contentStore.news.length },
        ministriesCount() { return contentStore.ministries.length },
        eventsCount() {
            return contentStore.schedule.reduce((sum, c) => sum + c.events.length, 0)
        },
    },
}
</script>

<template>
    <div>
        <h1 class="admin__title">Обзор</h1>
        <p class="admin__hint">Добро пожаловать. Здесь можно управлять контентом сайта.</p>
        <div class="admin__stats">
            <router-link to="/admin/news" class="admin__stat">
                <span class="admin__statValue">{{ newsCount }}</span>
                <span class="admin__statLabel">Новостей</span>
            </router-link>
            <router-link to="/admin/ministries" class="admin__stat">
                <span class="admin__statValue">{{ ministriesCount }}</span>
                <span class="admin__statLabel">Служений</span>
            </router-link>
            <router-link to="/admin/schedule" class="admin__stat">
                <span class="admin__statValue">{{ eventsCount }}</span>
                <span class="admin__statLabel">Событий в расписании</span>
            </router-link>
        </div>
    </div>
</template>

<style src="./admin.css"></style>
