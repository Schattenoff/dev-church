<script>
import { sectionsStore } from '@/composables/useSections.js'
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
    name: 'Services',
    components: { CardGrid },
    computed: {
        items() {
            return sectionsStore.services
        },
    },
}
</script>

<template>
    <div>
        <h2 class="section__title">Служения</h2>
        <CardGrid :items="items" />
    </div>
</template>
