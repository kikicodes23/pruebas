<script setup lang="ts">
import { provide, ref, watch } from "vue";

const props = defineProps<{
  open?: boolean;
  defaultOpen?: boolean;
}>();

const emit = defineEmits(["update:open"]);

const isOpen = ref(props.defaultOpen || false);

watch(
  () => props.open,
  (val) => {
    if (val !== undefined) isOpen.value = val;
  },
);

watch(isOpen, (val) => {
  emit("update:open", val);
});

const close = () => (isOpen.value = false);
const open = () => (isOpen.value = true);
const toggle = () => (isOpen.value = !isOpen.value);

provide("dialog", {
  isOpen,
  close,
  open,
  toggle,
});
</script>

<template>
  <slot />
</template>
