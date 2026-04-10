# Фронтенд-конвенции (Vue 3)

Эти правила действуют строго во всём `src/`. Не отклоняться без явного разрешения.

## Отступы

**4 пробела**, всегда. Никаких табов, никаких 2 пробелов. Распространяется на `.vue`, `.js`, `.css`, `.html`. Внутри `.vue` — и `<script>`, и `<template>`, и любые вложенные CSS — тоже 4 пробела.

## Vue: только Options API

- Используем `export default { ... }` с `data()`, `computed`, `methods`, `watch`, `mounted` и т.д.
- **Не использовать** `<script setup>`, `setup()`, `defineProps`, `defineEmits`, `ref`/`computed` внутри компонентов.
- Composition API допустим **только** в отдельных `.js` файлах стора (см. ниже).

## Shared state — reactive-сторы

Для общего состояния между компонентами — модульный файл с `reactive({...})`, экспортирующий объект стора. Компоненты импортируют стор напрямую и читают через `computed`, пишут через методы стора.

```js
// src/composables/useXxx.js
import { reactive } from 'vue'

export const xxxStore = reactive({
  items: [],
  add(item) { this.items.push(item) },
})
```

```vue
<script>
import { xxxStore } from '@/composables/useXxx.js'

export default {
  computed: {
    items() { return xxxStore.items },
  },
  methods: {
    onAdd() { xxxStore.add({ ... }) },
  },
}
</script>
```

`setup()` в компонентах — **запрещён**.

## Props — массив строк

```js
// ✅ правильно
props: ['label', 'href', 'variant']

// ❌ неправильно
props: {
  label: { type: String, required: true },
  href: String,
}
```

Без типов, без `required`, без дефолтов в описании props. Если нужен дефолт — подставлять в шаблоне или в `computed`.

## Стили — всегда отдельным файлом

```vue
<style src="./component-name.css"></style>
```

- Файл стилей лежит рядом с `.vue`, имя в kebab-case: `header.css`, `card-grid.css`, `admin.css`.
- **Не использовать** `<style scoped>`, `<style>` с инлайн-CSS, SCSS, CSS modules, Tailwind.
- Один `.vue` — один `.css` (если компоненту вообще нужны стили).
- Переиспользование: можно подключать общий `.css` из нескольких `.vue` через тот же `<style src="..."/>`.

## Именование классов (BEM-вариант проекта)

**Блок** — одно слово (или camelCase для составных), строчными:
```
.section
.card
.cardGrid        // если из двух слов — camelCase внутри блока
```

**Элемент** — через двойное подчёркивание, camelCase для составных:
```
.section__wrapper
.section__wrapperBlock
.card__media
.card__title
```

**Модификатор / состояние** — через двойное тире:
```
.section--active
.menu--opened
.btn--filled
.btn--outlined
.card__title--muted
```

### Правила
- Только один блок на корневом элементе компонента.
- Элементы пишутся от имени блока (`block__element`), не вкладываются цепочкой (`block__el__subEl` — **нельзя**, разбить на новый блок).
- Состояния применяются к блоку или элементу: `section--active`, `card__title--muted`.
- Не использовать утилитарные классы (`.mt-10`, `.flex`), не использовать id в CSS, не использовать теги в селекторах (`.card h3` → `.card__title`).

## Структура компонента

```
modules/
  feature-name/
    FeatureName.vue
    feature-name.css
```

Порядок секций в `.vue`:

```vue
<script>
export default {
  name: 'FeatureName',
  components: { ... },
  props: ['a', 'b'],
  emits: ['update'],
  data() { return {} },
  computed: {},
  methods: {},
}
</script>

<template>
  <div class="featureName">...</div>
</template>

<style src="./feature-name.css"></style>
```

## Шаблоны

- События: `@click`, `@submit.prevent`.
- Биндинг классов с состояниями: `:class="{ 'section--active': isActive }"`.
- `v-model` поддерживается (он совместим с Options API через `props: ['modelValue']` + `emits: ['update:modelValue']`).
