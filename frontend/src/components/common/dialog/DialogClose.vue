<script setup lang="ts">
import { inject } from "vue";

const context = inject<{
  close: () => void;
}>("dialog");
</script>

<template>
  <div @click="context?.close" class="inline-flex">
    <slot />
  </div>
</template>
