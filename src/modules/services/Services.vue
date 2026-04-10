<script>
import { contentStore } from '@/composables/useContent.js'
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
    name: 'Services',
    components: { CardGrid },
    computed: {
        items() { return contentStore.ministries },
    },
}
</script>

<template>
    <div>
        <h2 class="section__title">Служения</h2>
        <CardGrid :items="items" />
    </div>
</template>
