<script setup lang="ts">
import {
  CheckCircle2,
  AlertCircle,
  Info,
  AlertTriangle,
} from "lucide-vue-next";
import { computed } from "vue";

const props = withDefaults(
  defineProps<{
    variant?: "success" | "error" | "info" | "warning";
  }>(),
  {
    variant: "info",
  },
);

const classes = computed(() => {
  switch (props.variant) {
    case "success":
      return "bg-green-100 border-green-400 text-green-700";
    case "error":
      return "bg-red-100 border-red-400 text-red-700";
    case "warning":
      return "bg-yellow-100 border-yellow-400 text-yellow-700";
    case "info":
    default:
      return "bg-blue-100 border-blue-400 text-blue-700";
  }
});

const Icon = computed(() => {
  switch (props.variant) {
    case "success":
      return CheckCircle2;
    case "error":
      return AlertCircle;
    case "warning":
      return AlertTriangle;
    case "info":
    default:
      return Info;
  }
});
</script>

<template>
  <div
    class="border px-4 py-3 rounded relative flex items-center gap-2"
    :class="classes"
  >
    <Icon class="h-5 w-5 shrink-0" />
    <span>
      <slot />
    </span>
  </div>
</template>
