<script>
import { growlStore } from '@/config/fetch.js'

export default {
    name: 'Growl',
    computed: {
        items() { return growlStore.items },
    },
}
</script>

<template>
    <div class="growl">
        <div
            v-for="item in items"
            :key="item.id"
            :class="['growl__item', 'growl__item--' + item.type]"
        >
            {{ item.message }}
        </div>
    </div>
</template>

<style src="./growl.css"></style>
