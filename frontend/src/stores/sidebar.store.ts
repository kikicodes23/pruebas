import { defineStore } from "pinia";
import { ref } from "vue";

export const useSidebar = defineStore("sidebar", () => {
  const isOpen = ref(true);

  function toggle() {
    isOpen.value = !isOpen.value;
  }

  return { isOpen, toggle };
});
