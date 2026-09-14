<template>
  <nav id="breadcrumb" class="mb-4 sm:mb-6" aria-label="Breadcrumb">
    <ol
      class="flex flex-wrap items-center gap-1.5 text-xs sm:text-sm text-gray-500"
    >
      <li
        v-for="(item, index) in items"
        :key="index"
        class="flex items-center gap-1.5"
      >
        <!-- Link for non-last items with href -->
        <Link
          v-if="item.href && index < items.length - 1"
          :href="item.href"
          class="text-gray-500 hover:text-gray-900 transition-colors"
        >
          {{ item.label }}
        </Link>

        <!-- Current/Last item text -->
        <p
          v-else
          class="font-semibold text-gray-900 truncate max-w-xs sm:max-w-md"
        >
          {{ item.label }}
        </p>

        <!-- Separator between items -->
        <p
          v-if="index < items.length - 1"
          class="text-gray-400 select-none"
          aria-hidden="true"
        >
          /
        </p>
      </li>
    </ol>
  </nav>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
  items: {
    type: Object,
    required: true,
    label: {
      type: String,
      required: true,
    },
    href: {
      type: String,
      required: false,
    },
  },
});
</script>
