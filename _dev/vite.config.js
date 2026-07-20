/**
 * Copyright since 2019 Kaudaj
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Academic Free License 3.0 (AFL-3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to info@kaudaj.com so we can send you a copy immediately.
 *
 * @author    Kaudaj <info@kaudaj.com>
 * @copyright Since 2019 Kaudaj
 * @license   https://opensource.org/licenses/AFL-3.0 Academic Free License 3.0 (AFL-3.0)
 */
import { dirname, resolve } from 'node:path';
import { fileURLToPath } from 'node:url';
import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';

const here = dirname(fileURLToPath(import.meta.url));

export default defineConfig({
  plugins: [vue()],
  build: {
    // Bundles land in views/ next to the templates; never wipe that directory.
    outDir: resolve(here, '../views'),
    emptyOutDir: false,
    rollupOptions: {
      input: {
        back: resolve(here, 'js/back/index.js'),
        front: resolve(here, 'js/front/index.js'),
      },
      output: {
        entryFileNames: 'js/[name].js',
        chunkFileNames: 'js/chunks/[name]-[hash].js',
        assetFileNames: (assetInfo) =>
          (assetInfo.names ?? []).some((name) => name.endsWith('.css'))
            ? 'css/[name][extname]'
            : 'assets/[name][extname]',
      },
    },
  },
});
