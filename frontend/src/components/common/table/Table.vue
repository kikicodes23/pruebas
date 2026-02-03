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
  <div class="relative w-full overflow-auto">
    <table :class="['w-full caption-bottom text-sm', computedClass]">
      <slot />
    </table>
  </div>
</template>
