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
  <th
    :class="[
      'h-12 px-4 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0',
      computedClass,
    ]"
  >
    <slot />
  </th>
</template>
