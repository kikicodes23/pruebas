<script setup lang="ts">
import { inject, ref, watch, nextTick, type Ref, onUnmounted } from "vue";
import { Motion, AnimatePresence } from "motion-v";

const context = inject<{
  isOpen: Ref<boolean>;
  close: () => void;
  triggerRef: Ref<HTMLElement | null>;
}>("dropdown-menu");

const contentRef = ref<HTMLElement | null>(null);
const position = ref({ top: 0, left: 0 });
const transformOrigin = ref("top right");

const updatePosition = () => {
  if (context?.triggerRef.value) {
    const triggerRect = context.triggerRef.value.getBoundingClientRect();
    const contentEl = (contentRef.value as any)?.$el || contentRef.value;

    // Default to bottom-end alignment
    // Since we use position: fixed, we DO NOT add window.scrollY/X
    let top = triggerRect.bottom + 4;
    const left = triggerRect.right;

    if (contentEl) {
      const contentRect = contentEl.getBoundingClientRect();
      const viewportHeight = window.innerHeight;

      // Check for bottom overflow
      if (top + contentRect.height > viewportHeight) {
        // Flip to top
        top = triggerRect.top - contentRect.height - 4;
        transformOrigin.value = "bottom right";
      } else {
        transformOrigin.value = "top right";
      }
    }

    position.value = { top, left };
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
    // contentRef.value is a Component instance (Motion), so we access $el
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
          transformOrigin: transformOrigin,
        }"
        class="fixed z-50 min-w-50 overflow-hidden rounded-md border bg-popover text-popover-foreground shadow-md -translate-x-full"
      >
        <div class="p-1">
          <slot />
        </div>
      </Motion>
    </AnimatePresence>
  </Teleport>
</template>
