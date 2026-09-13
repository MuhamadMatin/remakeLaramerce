<template>
  <Head :title="`${props.status} - ${errorContent.title}`" />

  <div class="bg-gray-100 text-center">
    <div class="flex flex-col justify-center items-center h-full">
      <!-- Status -->
      <h1 class="text-8xl font-extrabold text-blue-400">
        {{ props.status }}
      </h1>

      <!-- Message -->
      <p class="text-4xl font-medium text-gray-800 mt-2">
        {{ errorContent.title }}
      </p>
      <p class="text-xl text-gray-800 mt-4">
        {{ errorContent.description }}
      </p>

      <Link
        href="/"
        class="mt-4 inline-flex items-center gap-1.5 text-sm md:text-base font-medium text-blue-600 hover:text-blue-700 hover:underline transition-colors"
      >
        <p>&larr;</p>
        <p>Back to Home</p>
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Head, Link } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { computed } from "vue";

// Props
const props = defineProps({
  status: {
    type: Number,
  },
});

// Error data
const errorMap: Record<number, { title: string; description: string }> = {
  401: {
    title: "Unauthorized",
    description:
      "You are not authorized to access this page. Please log in to continue.",
  },
  402: {
    title: "Payment Required",
    description:
      "Payment is required before you can access this service or content.",
  },
  403: {
    title: "Forbidden",
    description:
      "Access to this page is restricted. You do not have the required permissions.",
  },
  404: {
    title: "Page Not Found",
    description:
      "Sorry, the page you are looking for could not be found or has been moved.",
  },
  419: {
    title: "Page Expired",
    description:
      "Your session has expired due to inactivity. Please refresh the page and try again.",
  },
  429: {
    title: "Too Many Requests",
    description:
      "You have sent too many requests in a short period of time. Please wait a moment and try again.",
  },
  500: {
    title: "Internal Server Error",
    description: "We apologize for the inconvenience. Please try again later.",
  },
  503: {
    title: "Service Unavailable",
    description:
      "The server is temporarily down for maintenance. Please check back soon.",
  },
};

// Computed
const errorContent = computed(() => {
  return (
    errorMap[props.status] ?? {
      title: "An Error Occurred",
      description: "An unexpected error has occurred. Please try again later.",
    }
  );
});
</script>
