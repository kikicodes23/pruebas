<script setup lang="ts">
import { type HTMLAttributes, computed } from "vue";

const props = defineProps<{
  class?: HTMLAttributes["class"];
}>();

const computedClass = computed(() => {
  return props.class;
});
</script>

<template>
  <caption :class="['mt-4 text-sm text-muted-foreground', computedClass]">
    <slot />
  </caption>
</template>
