<script>
import { api } from '@/config/fetch.js'

export default {
    name: 'Schedule',
    data() {
        return {
            schedule: [],
            isReady: false,
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            api.fetch('/schedule/get', null, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                this.schedule = res.schedule
                this.isReady = true
            })
        },
    },
}
</script>

<template>
    <div class="schedule">
        <h2 class="schedule__title">Расписание служений</h2>
        <div class="schedule__grid">
            <div v-for="col in schedule" :key="col.day" class="schedule__col">
                <div class="schedule__day">{{ col.day }}</div>
                <div class="schedule__events">
                    <div
                        v-for="event in col.events"
                        :key="event.id"
                        class="schedule__event"
                    >
                        <div class="schedule__time">{{ event.time }}</div>
                        <div class="schedule__name">{{ event.title }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style src="./schedule.css"></style>
