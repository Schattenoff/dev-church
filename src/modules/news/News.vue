<script>
import CardGrid from '@/modules/ui/card-grid/CardGrid.vue'

export default {
  name: 'News',
  components: { CardGrid },
  data() {
    return {
      items: [
        { title: 'Рукоположение на дьяконское служение', bg: 'linear-gradient(135deg, #6B5D55, #2A201B)' },
        { title: 'Расписание на рождественские праздники', bg: 'linear-gradient(135deg, #C8422F, #9E3223)' },
        { title: 'Концерт «В ожидании Рождества»', bg: 'linear-gradient(135deg, #3A5BA0, #6B2D9E)' },
        { title: 'Благотворительная акция', bg: 'linear-gradient(135deg, #E8A33D, #9E3223)' },
      ],
    }
  },
}
</script>

<template>
  <div>
    <h2 class="section__title">Новости</h2>
    <CardGrid :items="items" />
  </div>
</template>
