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
  <td
    :class="['p-4 align-middle [&:has([role=checkbox])]:pr-0', computedClass]"
  >
    <slot />
  </td>
</template>
