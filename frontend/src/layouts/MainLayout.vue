<script setup lang="ts">
import Sidebar from "@/components/sidebar/Sidebar.vue";
import NavBar from "@/components/navbar/NavBar.vue";
</script>

<template>
  <div class="min-h-screen flex flex-col bg-background text-foreground">
    <NavBar />

    <div class="flex flex-1 relative">
      <Sidebar />
      <main class="flex-1 w-full overflow-hidden">
        <router-view />
      </main>
    </div>
  </div>
</template>
