<script setup lang="ts">
import { provide, ref, watch } from "vue";

const props = defineProps<{
  modelValue?: string;
  defaultValue?: string;
  placeholder?: string;
}>();

const emit = defineEmits(["update:modelValue"]);

const isOpen = ref(false);
const selectedValue = ref(props.modelValue || props.defaultValue || "");
const triggerRef = ref<HTMLElement | null>(null);

watch(
  () => props.modelValue,
  (val) => {
    if (val !== undefined) selectedValue.value = val;
  },
);

const select = (value: string) => {
  selectedValue.value = value;
  emit("update:modelValue", value);
  isOpen.value = false;
};

const toggle = () => (isOpen.value = !isOpen.value);
const close = () => (isOpen.value = false);
const open = () => (isOpen.value = true);
const registerTrigger = (el: HTMLElement) => (triggerRef.value = el);

provide("select", {
  isOpen,
  selectedValue,
  select,
  toggle,
  close,
  open,
  triggerRef,
  registerTrigger,
  placeholder: props.placeholder,
});
</script>

<template>
  <div class="relative inline-block w-full text-left">
    <slot />
  </div>
</template>
