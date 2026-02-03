<script setup lang="ts">
import { inject, computed } from "vue";

const props = defineProps<{
  placeholder?: string;
}>();

const context = inject<{
  selectedValue: { value: string };
  placeholder?: string;
}>("select");

const displayValue = computed(() => {
  if (context?.selectedValue.value) return context.selectedValue.value;
  return props.placeholder || context?.placeholder || "";
});

const hasValue = computed(() => !!context?.selectedValue.value);
</script>

<template>
  <span :class="{ 'text-muted-foreground': !hasValue, truncate: true }">
    {{ displayValue }}
  </span>
</template>
