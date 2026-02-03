<script setup lang="ts">
import { inject, onMounted, ref } from "vue";

const context = inject<{
  toggle: () => void;
  registerTrigger: (el: HTMLElement) => void;
}>("dropdown-menu");

const elRef = ref<HTMLElement | null>(null);

onMounted(() => {
  if (elRef.value && context) {
    context.registerTrigger(elRef.value);
  }
});

const handleClick = () => {
  context?.toggle();
};
</script>

<template>
  <div ref="elRef" @click="handleClick" class="cursor-pointer inline-flex">
    <slot />
  </div>
</template>
