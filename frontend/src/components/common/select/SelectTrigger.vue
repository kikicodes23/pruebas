<script setup lang="ts">
import { inject, onMounted, ref } from "vue";
import { ChevronDown } from "lucide-vue-next";

const context = inject<{
  toggle: () => void;
  registerTrigger: (el: HTMLElement) => void;
  isOpen: { value: boolean };
}>("select");

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
  <div
    ref="elRef"
    @click="handleClick"
    :data-state="context?.isOpen.value ? 'open' : 'closed'"
    class="flex h-9 w-full items-center justify-between rounded-md border border-input bg-transparent px-3 py-2 text-sm shadow-sm ring-offset-background placeholder:text-muted-foreground focus:outline-none focus:ring-1 focus:ring-ring disabled:cursor-not-allowed disabled:opacity-50 cursor-pointer"
  >
    <slot />
    <ChevronDown class="h-4 w-4 opacity-50" />
  </div>
</template>
