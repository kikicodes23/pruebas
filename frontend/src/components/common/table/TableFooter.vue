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
  <tfoot
    :class="[
      'border-t bg-muted/50 font-medium [&>tr]:last:border-b-0',
      computedClass,
    ]"
  >
    <slot />
  </tfoot>
</template>
