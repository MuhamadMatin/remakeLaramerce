<template>
  <DashboardLayout> profile {{ user }}</DashboardLayout>
</template>

<script setup lang="ts">
import DashboardLayout from "../Layouts/Dashboard/dashboard.vue";

const props = defineProps({
  user: {
    type: Object,
  },
});
</script>
