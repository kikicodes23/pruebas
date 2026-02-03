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
  <tbody :class="['[&_tr:last-child]:border-0', computedClass]">
    <slot />
  </tbody>
</template>
