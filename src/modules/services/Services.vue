<script>
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
  name: 'Services',
  components: { CardGrid },
  data() {
    return {
      items: [
        { title: 'Воскресное богослужение', bg: 'linear-gradient(135deg, #C8422F, #9E3223)' },
        { title: 'Молодёжное служение', bg: 'linear-gradient(135deg, #3A5BA0, #1F3A78)' },
        { title: 'Детское служение', bg: 'linear-gradient(135deg, #E8A33D, #C27A1A)' },
        { title: 'Служение прославления', bg: 'linear-gradient(135deg, #5A7A3E, #2E4A1F)' },
      ],
    }
  },
}
</script>

<template>
  <div>
    <h2 class="section__title">Служения</h2>
    <CardGrid :items="items" />
  </div>
</template>
