<script setup lang="ts">
import { provide, ref } from "vue";

const isOpen = ref(false);
const triggerRef = ref<HTMLElement | null>(null);

const toggle = () => (isOpen.value = !isOpen.value);
const close = () => (isOpen.value = false);
const open = () => (isOpen.value = true);
const registerTrigger = (el: HTMLElement) => (triggerRef.value = el);

provide("dropdown-menu", {
  isOpen,
  toggle,
  close,
  open,
  triggerRef,
  registerTrigger,
});
</script>

<template>
  <div class="relative inline-block text-left">
    <slot />
  </div>
</template>
