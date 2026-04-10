<script>
export default {
    name: 'Modal',
    props: ['open', 'title'],
    emits: ['close'],
    watch: {
        open(val) {
            if (val) {
                document.body.classList.add('modal-open')
                document.addEventListener('keydown', this.onEscape)
            } else {
                document.body.classList.remove('modal-open')
                document.removeEventListener('keydown', this.onEscape)
            }
        },
    },
    beforeUnmount() {
        document.body.classList.remove('modal-open')
        document.removeEventListener('keydown', this.onEscape)
    },
    methods: {
        close() {
            this.$emit('close')
        },
        onEscape(e) {
            if (e.key === 'Escape') this.close()
        },
    },
}
</script>

<template>
    <Teleport to="body">
        <Transition name="modal">
            <div v-if="open" class="modal" @click="close">
                <div class="modal__dialog" @click.stop>
                    <header class="modal__header">
                        <h2 v-if="title" class="modal__title">{{ title }}</h2>
                        <button type="button" class="modal__close" @click="close">&#x2715;</button>
                    </header>
                    <div class="modal__body">
                        <slot />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<style src="./modal.css"></style>
