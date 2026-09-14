<template>
  <span
    class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium border"
    :class="badgeClass"
  >
    <!-- Icon -->
    <svg v-if="icon" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" :d="icon" />
    </svg>
    <span>{{ label }}</span>
  </span>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
  label: {
    type: String,
    required: true,
  },
  variant: {
    type: String,
    default: 'default',
  },
})

// Variant map
const variants = {
  blue: 'bg-gray-100 text-gray-900 border-gray-200',
  emerald: 'bg-emerald-50 text-emerald-600 border-emerald-200',
  rose: 'bg-rose-50 text-rose-600 border-rose-200',
  amber: 'bg-amber-50 text-amber-600 border-amber-200',
  default: 'bg-gray-50 text-gray-600 border-gray-200',
}

// Icon map
const icons = {
  blue: 'M12 4v16m8-8H4',
  emerald: 'M5 13l4 4L19 7',
  rose: 'M6 18L18 6M6 6l12 12',
  amber: 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
}

const badgeClass = computed(() => {
  return variants[props.variant] || variants.default
})

const icon = computed(() => {
  return icons[props.variant] || null
})
</script>
