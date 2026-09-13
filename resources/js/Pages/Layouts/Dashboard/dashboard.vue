<template>
  <div>
    <div class="flex flex-col lg:flex-row">
      <Sidebar />
      <div class="flex-1 min-w-0">
        <slot />
      </div>
    </div>
    <Footer />
  </div>
</template>

<script setup lang="ts">
import Sidebar from "../../Components/sidebar.vue";
import Footer from "../../Components/footer.vue";
</script>
