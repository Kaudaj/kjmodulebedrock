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
import { createApp } from 'vue';
import '@prestashopcorp/puik-theme/base';
import '@prestashopcorp/puik-theme/font';
import '@prestashopcorp/puik-theme/puik-alert';
import '@prestashopcorp/puik-theme/puik-button';
import '../../css/back/back.scss';
import App from './App.vue';

// Entry point of the back-office bundle, loaded on the module settings page.
document.addEventListener('DOMContentLoaded', () => {
  document.body.classList.add('kj-module-bedrock-back-loaded');

  const host = document.getElementById('kj-module-bedrock-vue-app');

  if (host) {
    createApp(App, { exampleSetting: host.dataset.exampleSetting || '' }).mount(
      host,
    );
  }
});
