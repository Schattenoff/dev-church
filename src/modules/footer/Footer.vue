<script>
import siteConfig from '@/config/site.js'
import Logo from '@/modules/logo/Logo.vue'
import Icon from '@/modules/ui/icon/Icon.vue'

export default {
  name: 'Footer',
  components: { Logo, Icon },
  computed: {
    config() {
      return siteConfig
    },
    year() {
      return new Date().getFullYear()
    },
  },
}
</script>

<template>
  <footer class="footer">
    <div class="container footer__inner">
      <div class="footer__brand">
        <Logo size="md" :show-name="true" class="footer__logo" />
        <p v-if="config.tagline" class="footer__tagline">{{ config.tagline }}</p>
        <div v-if="config.socials && config.socials.length" class="footer__socials">
          <a
            v-for="social in config.socials"
            :key="social.icon"
            :href="social.url"
            :aria-label="social.label"
            class="footer__social-link"
            target="_blank"
            rel="noopener noreferrer"
          >
            <Icon :name="social.icon" :size="22" />
          </a>
        </div>
      </div>

      <div v-if="config.navigation && config.navigation.length" class="footer__nav">
        <h4 class="footer__heading">Навигация</h4>
        <a
          v-for="item in config.navigation"
          :key="item.href"
          :href="item.href"
          class="footer__link"
        >
          {{ item.label }}
        </a>
      </div>

      <div v-if="config.contacts" class="footer__contacts">
        <h4 class="footer__heading">Контакты</h4>
        <p v-if="config.contacts.phone" class="footer__contact-item">
          {{ config.contacts.phone }}
        </p>
        <p v-if="config.contacts.address" class="footer__contact-item">
          {{ config.contacts.address }}
        </p>
      </div>
    </div>

    <div class="footer__bottom">
      <div class="container">
        <p>&copy; {{ year }} {{ config.name }}</p>
      </div>
    </div>
  </footer>
</template>

<style src="./footer.css"></style>