<script setup lang="ts">
interface Props {
  class?: string;
}

defineProps<Props>();
</script>

<template>
  <div :class="['animate-pulse rounded-md bg-muted', $props.class]" />
</template>
