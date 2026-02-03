<script setup lang="ts">
import { computed } from "vue";
import Button from "@/components/common/Button.vue";
import {
  ChevronLeft,
  ChevronRight,
  ChevronsLeft,
  ChevronsRight,
} from "lucide-vue-next";

interface Props {
  page: number;
  totalPages: number;
  limit?: number; // Optional prop for rows per page
}

const props = withDefaults(defineProps<Props>(), {
  limit: 10,
});

const emit = defineEmits(["update:page", "update:limit"]);

const isFirstPage = computed(() => props.page === 1);
const isLastPage = computed(() => props.page === props.totalPages);

const setPage = (p: number) => {
  if (p >= 1 && p <= props.totalPages) {
    emit("update:page", p);
  }
};

const limits = [10, 20, 30, 40, 50];

const handleLimitChange = (event: Event) => {
  const value = parseInt((event.target as HTMLSelectElement).value);
  emit("update:limit", value);
};
</script>

<template>
  <div
    class="flex flex-col md:flex-row items-center justify-between gap-4 py-4 px-2 w-full"
  >
    <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
      <div class="flex items-center space-x-2">
        <p class="text-sm font-medium">Entradas por página</p>
        <div class="relative">
          <select
            :value="limit"
            @change="handleLimitChange"
            class="h-8 w-18 rounded-md border border-input bg-background px-2 py-1 text-sm ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
          >
            <option v-for="l in limits" :key="l" :value="l">
              {{ l }}
            </option>
          </select>
        </div>
      </div>

      <div class="text-sm font-medium text-center sm:text-left">
        Página {{ page }} de {{ totalPages }}
      </div>
    </div>

    <div class="flex items-center space-x-2">
      <Button
        variant="outline"
        size="icon"
        class="h-8 w-8"
        :disabled="isFirstPage"
        @click="setPage(1)"
        aria-label="Ir a la primera página"
      >
        <ChevronsLeft :size="16" />
      </Button>
      <Button
        variant="outline"
        size="icon"
        class="h-8 w-8"
        :disabled="isFirstPage"
        @click="setPage(page - 1)"
        aria-label="Ir a la página anterior"
      >
        <ChevronLeft :size="16" />
      </Button>
      <Button
        variant="outline"
        size="icon"
        class="h-8 w-8"
        :disabled="isLastPage"
        @click="setPage(page + 1)"
        aria-label="Ir a la página siguiente"
      >
        <ChevronRight :size="16" />
      </Button>
      <Button
        variant="outline"
        size="icon"
        class="h-8 w-8"
        :disabled="isLastPage"
        @click="setPage(totalPages)"
        aria-label="Ir a la última página"
      >
        <ChevronsRight :size="16" />
      </Button>
    </div>
  </div>
</template>
