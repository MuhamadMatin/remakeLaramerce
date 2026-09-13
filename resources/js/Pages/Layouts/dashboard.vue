<template>
  <div>
    <Navbar />
    <slot />
    <Footer />
  </div>
</template>

<script setup lang="ts">
import Navbar from "../Components/navbar.vue";
import Footer from "../Components/footer.vue";
</script>
