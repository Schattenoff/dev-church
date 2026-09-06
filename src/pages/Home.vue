<script>
import siteConfig from '@/config/site.js'
import { sectionsStore } from '@/composables/useSections.js'
import Header from '@/modules/header/Header.vue'
import Footer from '@/modules/footer/Footer.vue'
import Menu from '@/modules/menu/Menu.vue'
import Schedule from '@/modules/schedule/Schedule.vue'
import Services from '@/modules/services/Services.vue'
import News from '@/modules/news/News.vue'
import Button from '@/modules/ui/button/Button.vue'

export default {
    name: 'Home',
    components: {Header, Footer, Menu, Schedule, Services, News, Button},
    data() {
        return {
            menuOpen: false,
        }
    },
    computed: {
        config() {
            return siteConfig
        },
        sections() {
            return sectionsStore
        },
    },
    mounted() {
        const script = document.createElement('script')
        script.src = 'https://api-maps.yandex.ru/services/constructor/1.0/js/?um=constructor%3A7160b2669a09f60433b1bfbdf720306b3317d892efc72cf6c005d264edbc572c&width=100%25&height=480&lang=ru_RU&scroll=true'
        script.async = true
        script.charset = 'utf-8'
        document.getElementById('yandex-map').appendChild(script)
    },
}
</script>

<template>
    <div class="layout">
        <Header @toggle-menu="menuOpen = !menuOpen"/>
        <Menu v-model:open="menuOpen"/>
        <main class="layout__main">
            <section class="hero">
                <div class="container">
                    <div class="hero__content">
                        <h1 class="hero__title">Добро пожаловать на сайт церкви «Добрая весть» г. Витебска</h1>
                    </div>
                </div>
            </section>
            <section v-show="sections.hasServices" id="services" class="section">
                <div class="container">
                    <Services/>
                </div>
            </section>
            <section v-show="sections.hasSchedule" id="schedule" class="section section--alt">
                <div class="container">
                    <Schedule/>
                </div>
            </section>
            <section v-show="sections.hasNews" id="news" class="section">
                <div class="container">
                    <News/>
                </div>
            </section>
            <section id="about" class="section">
                <div class="container aboutPreview">
                    <img src="/images/about/new-building.jpg" alt="Здание церкви «Добрая весть»" class="aboutPreview__image" loading="lazy">
                    <div class="aboutPreview__body">
                        <h2 class="section__title aboutPreview__title">О нас</h2>
                        <p class="aboutPreview__text">
                            Церковь «Добрая весть» ведёт свою историю с 1948 года. Она родилась в доме витебских христиан, прошла через годы гонений, 44 года не имела собственного здания и в 1992 году обрела дом на улице Чайковского.
                        </p>
                        <p class="aboutPreview__text">
                            Сегодня это большая и дружная христианская семья, где есть место всем поколениям. Мы открыты для общения и гостеприимны, растём духовно и благодарим Бога за тот путь, которым Он нас ведёт.
                        </p>
                        <Button label="Читать историю" href="/about" variant="filled" class="aboutPreview__link"/>
                    </div>
                </div>
            </section>
            <section id="contacts" class="section">
                <div class="container">
                    <h2 class="section__title">Контакты</h2>
                    <p class="contacts__info">
                        <a :href="`tel:${config.contacts.phone.replace(/\s|-/g, '')}`"
                           class="contacts__link">{{ config.contacts.phone }}</a>
                        {{ config.contacts.address }}
                    </p>
                    <div id="yandex-map" class="contacts__map"></div>
                </div>
            </section>
        </main>
        <Footer/>
    </div>
</template>
