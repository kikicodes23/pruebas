<script setup lang="ts">
import { ref, watch } from "vue";
import { useRoute } from "vue-router";
import { Menu, X } from "lucide-vue-next";
import Button from "@/components/common/Button.vue";
import SidebarContent from "@/components/sidebar/SidebarContent.vue";
import { Motion, AnimatePresence } from "motion-v";

const isOpen = ref(false);
const route = useRoute();

const open = () => (isOpen.value = true);
const close = () => (isOpen.value = false);

// Close on route change
watch(
  () => route.path,
  () => {
    close();
  },
);

const variants = {
  open: {
    x: 0,
    opacity: 1,
    transition: { type: "spring", stiffness: 300, damping: 30 },
  },
  closed: {
    x: "-100%",
    opacity: 0,
    transition: { type: "spring", stiffness: 300, damping: 30 },
  },
} as const;
</script>

<template>
  <div>
    <Button size="icon" variant="outline" class="flex md:hidden" @click="open">
      <Menu :size="20" />
    </Button>

    <Teleport to="body">
      <Transition
        enter-active-class="transition duration-300 ease-out"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition duration-200 ease-in"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div
          v-if="isOpen"
          class="fixed inset-0 z-50 bg-background/80 backdrop-blur-sm"
          @click="close"
        ></div>
      </Transition>

      <AnimatePresence>
        <Motion
          v-if="isOpen"
          class="fixed inset-y-0 left-0 z-50 h-full w-[85%] sm:w-3/4 gap-4 border-r bg-background p-6 shadow-lg sm:max-w-sm flex flex-col"
          initial="closed"
          animate="open"
          exit="closed"
          :variants="variants"
          @click.stop
        >
          <div class="flex flex-col gap-4 overflow-y-auto h-full">
            <div class="flex items-center justify-between">
              <p class="text-2xl font-bold">Menú</p>
              <Button variant="ghost" size="icon" @click="close">
                <X :size="24" />
              </Button>
            </div>

            <div class="flex flex-col gap-4">
              <SidebarContent is-mobile />
            </div>
          </div>
        </Motion>
      </AnimatePresence>
    </Teleport>
  </div>
</template>
