<script setup lang="ts">
import MobileSidebar from "@/components/mobileSidebar/MobileSidebar.vue";
</script>

<template>
  <header
    class="h-14 py-2 px-5 border-b flex justify-between items-center sticky top-0 z-50 bg-background/60 backdrop-blur-sm backdrop-filter w-full"
  >
    <div class="flex items-center gap-2">
      <div class="gap-2 items-center flex">
        <img src="/logo.png" alt="Logo" class="h-8" />
        <h1 class="font-bold">Sistema Académico UCA</h1>
      </div>
    </div>

    <MobileSidebar />
  </header>
</template>
