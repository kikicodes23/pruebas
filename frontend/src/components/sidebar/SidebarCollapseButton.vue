<script setup lang="ts">
import { useSidebar } from "@/stores/sidebar.store";
import { SidebarClose, SidebarOpen } from "lucide-vue-next";

const sidebarStore = useSidebar();
</script>

<template>
  <button
    @click="sidebarStore.toggle"
    class="h-auto w-auto px-3 py-3 hover:bg-gray-100 rounded-md cursor-pointer flex items-center justify-center transition-colors"
  >
    <SidebarClose v-if="sidebarStore.isOpen" :size="24" />
    <SidebarOpen v-else :size="24" />
  </button>
</template>
