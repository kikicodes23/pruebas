<script setup lang="ts">
import { inject, type Ref } from "vue";
import { Motion, AnimatePresence } from "motion-v";
import { X } from "lucide-vue-next";

const context = inject<{
  isOpen: Ref<boolean>;
  close: () => void;
}>("dialog");

const overlayVariants = {
  hidden: { opacity: 0 },
  visible: { opacity: 1, transition: { duration: 0.2 } },
};

const contentVariants = {
  hidden: { opacity: 0, scale: 0.95, y: -10 },
  visible: {
    opacity: 1,
    scale: 1,
    y: 0,
    transition: { duration: 0.2, delay: 0.05 },
  },
};
</script>

<template>
  <Teleport to="body">
    <AnimatePresence>
      <div
        v-if="context?.isOpen.value"
        class="fixed inset-0 z-50 flex items-center justify-center isolate"
      >
        <!-- Overlay -->
        <Motion
          :initial="overlayVariants.hidden"
          :animate="overlayVariants.visible"
          :exit="overlayVariants.hidden"
          class="fixed inset-0 bg-black/50 backdrop-blur-sm"
          @click="context.close"
        />

        <!-- Content -->
        <Motion
          :initial="contentVariants.hidden"
          :animate="contentVariants.visible"
          :exit="contentVariants.hidden"
          class="relative z-50 grid w-full max-w-lg gap-4 border bg-background p-6 shadow-lg duration-200 sm:rounded-lg max-h-[85vh] overflow-y-auto"
        >
          <slot />
          <button
            class="absolute right-4 top-4 rounded-sm opacity-70 ring-offset-background transition-opacity hover:opacity-100 focus:outline-none focus:ring-2 focus:ring-ring focus:ring-offset-2 disabled:pointer-events-none data-[state=open]:bg-accent data-[state=open]:text-muted-foreground"
            @click="context.close"
          >
            <X class="h-4 w-4" />
            <span class="sr-only">Close</span>
          </button>
        </Motion>
      </div>
    </AnimatePresence>
  </Teleport>
</template>
