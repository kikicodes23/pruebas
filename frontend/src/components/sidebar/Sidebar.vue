<script setup lang="ts">
import { useSidebar } from "@/stores/sidebar.store";
import SidebarHeader from "./SidebarHeader.vue";
import SidebarContent from "./SidebarContent.vue";
import { Motion } from "motion-v";

const sidebarStore = useSidebar();

const variants = {
  open: { width: "256px" },
  closed: { width: "80.8px" },
};
</script>

<template>
  <Motion
    is="aside"
    :initial="sidebarStore.isOpen ? 'open' : 'closed'"
    :animate="sidebarStore.isOpen ? 'open' : 'closed'"
    :variants="variants"
    class="top-14 z-30 h-[calc(100vh-56px)] hidden md:flex md:flex-col md:gap-4 md:sticky shrink-0 border-r border-border py-6 px-4 overflow-y-auto overflow-x-hidden bg-background"
  >
    <SidebarHeader />
    <SidebarContent />
  </Motion>
</template>
