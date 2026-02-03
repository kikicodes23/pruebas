<script setup lang="ts">
import { computed, useSlots } from "vue";
import { ArrowLeft } from "lucide-vue-next";
import Button from "@/components/common/Button.vue";

interface Props {
  title?: string;
  backRoute?: string;
}

defineProps<Props>();

const slots = useSlots();
const hasActions = computed(() => !!slots.actions);
</script>

<template>
  <article
    class="p-4 sm:p-8 w-full min-h-[calc(100dvh-56px)] bg-muted/50 flex flex-col gap-4 overflow-auto items-center"
  >
    <div
      v-if="title || backRoute || hasActions"
      class="flex flex-col sm:flex-row justify-between items-start w-full gap-3"
    >
      <div class="flex items-center gap-3">
        <router-link v-if="backRoute" :to="backRoute">
          <Button variant="ghost" size="icon">
            <ArrowLeft :size="24" />
          </Button>
        </router-link>

        <h2 v-if="title" class="text-xl font-bold">{{ title }}</h2>
      </div>

      <div v-if="hasActions" class="w-full sm:w-fit">
        <slot name="actions"></slot>
      </div>
    </div>

    <slot></slot>
  </article>
</template>
