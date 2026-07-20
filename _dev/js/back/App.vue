<!--*
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
 *-->
<template>
  <div class="kj-module-bedrock-vue-demo">
    <puik-alert variant="info" :title="'Vue 3 + PrestaShop UI Kit'">
      This card is rendered by a Vue 3 application styled with PUIK components.
      Replace it with your module interface.
    </puik-alert>

    <p class="kj-module-bedrock-vue-demo__setting">
      Current example setting:
      <strong data-testid="example-setting-value">{{
        exampleSetting || '(empty)'
      }}</strong>
    </p>

    <puik-button
      variant="primary"
      data-testid="counter-button"
      @click="counter += 1"
    >
      Clicked {{ counter }} time(s)
    </puik-button>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { PuikAlert, PuikButton } from '@prestashopcorp/puik-components';

defineProps({
  exampleSetting: {
    type: String,
    default: '',
  },
});

const counter = ref(0);
</script>

<style scoped>
.kj-module-bedrock-vue-demo__setting {
  margin: 1rem 0;
}
</style>
