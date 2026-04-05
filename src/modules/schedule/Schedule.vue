<script>
import siteConfig from '@/config/site.js'

export default {
  name: 'Schedule',
  computed: {
    config() {
      return siteConfig
    },
  },
}
</script>

<template>
  <div class="schedule">
    <h2 class="schedule__title">Расписание служений</h2>
    <div class="schedule__grid">
      <div v-for="col in config.schedule" :key="col.day" class="schedule__col">
        <div class="schedule__day">{{ col.day }}</div>
        <div class="schedule__events">
          <div
            v-for="(event, i) in col.events"
            :key="i"
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
