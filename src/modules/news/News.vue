<script>
import { sectionsStore } from '@/composables/useSections.js'
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
    name: 'News',
    components: { CardGrid },
    computed: {
        items() {
            return sectionsStore.news
        },
    },
}
</script>

<template>
    <div>
        <h2 class="section__title">Новости</h2>
        <CardGrid :items="items" />
    </div>
</template>
