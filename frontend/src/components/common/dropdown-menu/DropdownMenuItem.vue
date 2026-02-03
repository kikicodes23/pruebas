<script setup lang="ts">
import { inject } from "vue";

const context = inject<{
  close: () => void;
}>("dropdown-menu");

const handleClick = () => {
  context?.close();
};
</script>

<template>
  <div
    @click="handleClick"
    class="relative flex select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors hover:bg-accent hover:text-accent-foreground data-disabled:pointer-events-none data-disabled:opacity-50 cursor-pointer"
  >
    <slot />
  </div>
</template>
