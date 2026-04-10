<script>
import siteConfig from '@/config/site.js'
import Button from '@/modules/ui/button/Button.vue'

export default {
    name: 'Menu',
    components: { Button },
    props: ['open'],
    emits: ['update:open'],
    computed: {
        config() {
            return siteConfig
        },
    },
    watch: {
        open(val) {
            if (val) {
                document.body.classList.add('menu-open')
                document.addEventListener('keydown', this.onEscape)
            } else {
                document.body.classList.remove('menu-open')
                document.removeEventListener('keydown', this.onEscape)
            }
        },
    },
    beforeUnmount() {
        document.body.classList.remove('menu-open')
        document.removeEventListener('keydown', this.onEscape)
    },
    methods: {
        close() {
            this.$emit('update:open', false)
        },
        onEscape(e) {
            if (e.key === 'Escape') this.close()
        },
    },
}
</script>

<template>
    <Teleport to="body">
        <Transition name="menu">
            <div v-if="open" class="menu-overlay" @click="close">
                <nav class="menu" @click.stop>
                    <button class="menu__close" @click="close">&#x2715;</button>
                    <a
                        v-for="item in config.navigation"
                        :key="item.href"
                        :href="item.href"
                        class="menu__link"
                        @click="close"
                    >
                        {{ item.label }}
                    </a>
                    <Button
                        v-if="config.cta"
                        :label="config.cta.label"
                        :href="config.cta.href"
                        variant="filled"
                        class="menu__cta"
                        @click="close"
                    />
                </nav>
            </div>
        </Transition>
    </Teleport>
</template>

<style src="./menu.css"></style>
