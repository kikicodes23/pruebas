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
  <thead :class="['[&_tr]:border-b', computedClass]">
    <slot />
  </thead>
</template>
