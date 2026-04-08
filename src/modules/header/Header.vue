<script>
import siteConfig from '@/config/site.js'
import Logo from '@/modules/logo/Logo.vue'
import Nav from '@/modules/nav/Nav.vue'
import Button from '@/modules/ui/button/Button.vue'

export default {
    name: 'Header',

    components: {
        Logo,
        Nav,
        Button
    },


    data() {
        return {
            isScrolled: false,
        }
    },

    computed: {
        config() {
            return siteConfig
        },
    },

    mounted() {
        window.addEventListener('scroll', this.handleScroll)
    },

    beforeUnmount() {
        window.removeEventListener('scroll', this.handleScroll)
    },

    methods: {
        handleScroll() {
            this.isScrolled = window.scrollY > 10
        },
    },
}
</script>

<template>
    <header class="header" :class="{ 'header--scrolled': isScrolled }">
        <div class="container header__inner">
            <Logo size="sm" :showName="true"/>
            <Nav :items="config.navigation" class="header__nav"/>
            <Button
                v-if="config.cta"
                :label="config.cta.label"
                :href="config.cta.href"
                variant="outlined"
                class="header__cta"
            />
            <button class="header__burger" @click="$emit('toggle-menu')">
                <span></span>
            </button>
        </div>
    </header>
</template>

<style src="./header.css" ></style>
