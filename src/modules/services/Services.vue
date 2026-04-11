<script>
import { api } from '@/config/fetch.js'
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
    name: 'Services',
    components: { CardGrid },
    data() {
        return {
            items: [],
            isReady: false,
        }
    },
    mounted() {
        this.getData()
    },
    methods: {
        getData() {
            this.items.length > 0 && (this.items.length = 0)
            api.fetch('/ministries/get', null, (res) => {
                if (res.error) {
                    api.growl(res.message, 'danger')
                    return
                }
                this.items = res.ministries
                this.isReady = true
            })
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
