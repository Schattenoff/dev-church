import { fileURLToPath, URL } from 'node:url'

import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import Components from 'unplugin-vue-components/vite'
import svgLoader from 'vite-svg-loader'
import imagePresets, { formatPreset } from 'vite-plugin-image-presets'

export default defineConfig({

  base: '/',

  server: {
    host: true,
  },

  build: {
    target: 'es2015',
    rollupOptions: {
      output: {
        chunkFileNames: 'js/[name]-[hash].js',
        entryFileNames: 'js/[name]-[hash].js',

        assetFileNames: ({ name }) => {
          if (/\.(gif|jpe?g|png|svg)$/.test(name ?? '')) {
            return 'img/[name]-[hash][extname]'
          }

          if (/\.css$/.test(name ?? '')) {
            return 'css/[name]-[hash][extname]'
          }

          if (/\.woff2?$/.test(name ?? '')) {
            return 'font/[name]-[hash][extname]'
          }

          if (/\.mp3$/.test(name ?? '')) {
            return 'media/[name]-[hash][extname]'
          }

          return '[name]-[hash][extname]'
        },
      },
    },
  },

  plugins: [

    vue(),

    svgLoader(),

    Components({
      dirs: ['src/components'],
    }),

    imagePresets({
      full: formatPreset({
        loading: 'eager',
        formats: {
          avif: { quality: 80 },
          webp: { quality: 80 },
          png: { quality: 80 },
        },
      }),
    }, {
      assetsDir: 'img',
    }),
  ],

  resolve: {
    alias: {
      '@': fileURLToPath(new URL('./src', import.meta.url)),
    },
  },
})
