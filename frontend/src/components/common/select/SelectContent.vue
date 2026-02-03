<script setup lang="ts">
import { inject, ref, watch, nextTick, type Ref, onUnmounted } from "vue";
import { Motion, AnimatePresence } from "motion-v";

const context = inject<{
  isOpen: Ref<boolean>;
  close: () => void;
  triggerRef: Ref<HTMLElement | null>;
}>("select");

const contentRef = ref<HTMLElement | null>(null);
const position = ref({ top: 0, left: 0, width: 0, maxHeight: 300 });

const updatePosition = () => {
  if (context?.triggerRef.value) {
    const rect = context.triggerRef.value.getBoundingClientRect();
    const margin = 4;

    // Default open down
    let top = rect.bottom + window.scrollY + margin;
    let availableHeight = window.innerHeight - rect.bottom - margin - 10;

    // Ensure we have at least some space, otherwise just max it out to fit viewport
    position.value = {
      top,
      left: rect.left + window.scrollX,
      width: rect.width,
      // Dynamic max height based on available space below trigger
      maxHeight: Math.max(100, availableHeight),
    };
  }
};

watch(
  () => context?.isOpen.value,
  async (val) => {
    if (val) {
      await nextTick();
      updatePosition();
      window.addEventListener("scroll", updatePosition);
      window.addEventListener("resize", updatePosition);
      document.addEventListener("click", handleClickOutside);
    } else {
      window.removeEventListener("scroll", updatePosition);
      window.removeEventListener("resize", updatePosition);
      document.removeEventListener("click", handleClickOutside);
    }
  },
);

const handleClickOutside = (e: MouseEvent) => {
  if (context?.isOpen.value) {
    // Check if click is outside content and outside trigger
    const el = (contentRef.value as any)?.$el || contentRef.value;
    if (
      el &&
      !el.contains(e.target as Node) &&
      context.triggerRef.value &&
      !context.triggerRef.value.contains(e.target as Node)
    ) {
      context.close();
    }
  }
};

onUnmounted(() => {
  window.removeEventListener("scroll", updatePosition);
  window.removeEventListener("resize", updatePosition);
  document.removeEventListener("click", handleClickOutside);
});

const variants = {
  open: { opacity: 1, scale: 1, y: 0, transition: { duration: 0.1 } },
  closed: { opacity: 0, scale: 0.95, y: -2, transition: { duration: 0.1 } },
} as const;
</script>

<template>
  <Teleport to="body">
    <AnimatePresence>
      <Motion
        v-if="context?.isOpen.value"
        ref="contentRef"
        :initial="variants.closed"
        :animate="variants.open"
        :exit="variants.closed"
        :style="{
          top: `${position.top}px`,
          left: `${position.left}px`,
          minWidth: `${position.width}px`,
        }"
        class="fixed z-50 overflow-hidden rounded-md border bg-popover text-popover-foreground shadow-md"
      >
        <div
          class="overflow-y-auto w-full min-w-full p-1"
          :style="{ maxHeight: `${position.maxHeight}px` }"
        >
          <slot />
        </div>
      </Motion>
    </AnimatePresence>
  </Teleport>
</template>
