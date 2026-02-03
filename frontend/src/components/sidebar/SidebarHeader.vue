<script setup lang="ts">
import { useSidebar } from "@/stores/sidebar.store";
import SidebarCollapseButton from "./SidebarCollapseButton.vue";
import { Motion } from "motion-v";

const sidebarStore = useSidebar();

const variants = {
  open: { opacity: 1, transition: { duration: 0.6 } },
  closed: { opacity: 0 },
};
</script>

<template>
  <div
    class="flex items-center w-full"
    :class="sidebarStore.isOpen ? 'justify-between' : 'justify-end'"
  >
    <Motion
      is="p"
      class="text-xl font-bold block"
      :class="{ hidden: !sidebarStore.isOpen }"
      :animate="sidebarStore.isOpen ? 'open' : 'closed'"
      :variants="variants"
    >
      Menú
    </Motion>
    <SidebarCollapseButton />
  </div>
</template>
