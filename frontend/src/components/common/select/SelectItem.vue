<script setup lang="ts">
import { inject, computed } from "vue";
import { Check } from "lucide-vue-next";

const props = defineProps<{
  value: string;
}>();

const context = inject<{
  selectedValue: { value: string };
  select: (value: string) => void;
}>("select");

const isSelected = computed(() => context?.selectedValue.value === props.value);

const handleClick = () => {
  context?.select(props.value);
};
</script>

<template>
  <div
    @click="handleClick"
    :data-state="isSelected ? 'checked' : 'unchecked'"
    class="relative flex w-full cursor-default select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-sm outline-none focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50 hover:bg-accent hover:text-accent-foreground cursor-pointer"
  >
    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
      <Check v-if="isSelected" class="h-4 w-4" />
    </span>
    <slot>
      <span>{{ value }}</span>
    </slot>
  </div>
</template>
