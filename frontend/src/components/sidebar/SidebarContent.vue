<script setup lang="ts">
import { computed } from "vue";
import { useSidebar } from "@/stores/sidebar.store";
import { ROUTES } from "@/constants/routes";
import { FileUser, Notebook } from "lucide-vue-next";
import SidebarItem from "./SidebarItem.vue";

interface SidebarContentProps {
  isMobile?: boolean;
}

const props = defineProps<SidebarContentProps>();
const sidebarStore = useSidebar();

const isSidebarOpen = computed(() => {
  return !props.isMobile ? sidebarStore.isOpen : true;
});
</script>

<template>
  <SidebarItem
    label="Estudiantes"
    :to="ROUTES.STUDENTS"
    :is-sidebar-open="isSidebarOpen"
    is-index-route
  >
    <FileUser :size="24" />
  </SidebarItem>

  <SidebarItem
    label="Registro de notas"
    :to="ROUTES.GRADES"
    :is-sidebar-open="isSidebarOpen"
  >
    <Notebook :size="24" />
  </SidebarItem>
</template>
