<script setup lang="ts">
import { inject } from "vue";

const context = inject<{
  toggle: () => void;
}>("dialog");

const handleClick = () => {
  context?.toggle();
};
</script>

<template>
  <div @click="handleClick" class="inline-flex cursor-pointer">
    <slot />
  </div>
</template>
