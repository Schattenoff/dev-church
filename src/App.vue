<script>
import Header from '@/modules/header/Header.vue'
import Footer from '@/modules/footer/Footer.vue'
import Menu from '@/modules/menu/Menu.vue'

export default {
  name: 'App',
  components: { Header, Footer, Menu },
  data() {
    return {
      menuOpen: false,
    }
  },
  mounted() {
    const script = document.createElement('script')
    script.src = 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7160b2669a09f60433b1bfbdf720306b3317d892efc72cf6c005d264edbc572c&width=1160&height=580&lang=ru_RU&scroll=true'
    script.async = true
    script.charset = 'utf-8'
    document.getElementById('yandex-map').appendChild(script)
  },
}
</script>

<template>
  <div class="layout">
    <Header @toggle-menu="menuOpen = !menuOpen" />
    <Menu v-model:open="menuOpen" />
    <main class="layout__main">
      <section class="hero">
        <div class="container">
          <div class="hero__content">
            <h1 class="hero__title">Добро пожаловать на сайт церкви «Добрая весть» г. Витебска</h1>
          </div>
        </div>
      </section>
      <section id="services" class="section">
        <div class="container">
          <h2 class="section__title">Служения</h2>
        </div>
      </section>
      <section id="schedule" class="section">
        <div class="container">
          <h2 class="section__title">Расписание</h2>
        </div>
      </section>
      <section id="news" class="section">
        <div class="container">
          <h2 class="section__title">Новости</h2>
        </div>
      </section>
      <section id="about" class="section">
        <div class="container">
          <h2 class="section__title">О нас</h2>
        </div>
      </section>
      <section id="contacts" class="section">
        <div class="container">
          <h2 class="section__title">Контакты</h2>
          <div id="yandex-map" class="contacts__map"></div>
        </div>
      </section>
    </main>
    <Footer />
  </div>
</template>

<style src="./app.css"></style>
