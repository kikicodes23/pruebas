<script setup lang="ts">
import { computed } from "vue";
import { RouterLink, useRoute } from "vue-router";
import { Motion } from "motion-v";
import { ROUTES } from "@/constants/routes";

interface SidebarItemProps {
  label: string;
  to: string;
  isIndexRoute?: boolean;
  isSidebarOpen?: boolean;
}

const props = defineProps<SidebarItemProps>();
const route = useRoute();

const isActive = computed(() => {
  return (
    route.path.includes(props.to) ||
    (props.isIndexRoute && route.path === ROUTES.HOME)
  );
});

const variants = {
  open: { opacity: 1, transition: { duration: 0.6 } },
  closed: { opacity: 0 },
};
</script>

<template>
  <RouterLink
    :to="to"
    class="px-3 py-3 relative rounded-md flex gap-3 items-center w-full overflow-hidden transition-colors"
    :class="isActive ? 'bg-primary text-primary-foreground' : 'hover:bg-muted'"
  >
    <slot></slot>

    <Motion
      is="p"
      class="absolute left-12 truncate block"
      :animate="isSidebarOpen ? 'open' : 'closed'"
      :variants="variants"
    >
      {{ label }}
    </Motion>
  </RouterLink>
</template>
