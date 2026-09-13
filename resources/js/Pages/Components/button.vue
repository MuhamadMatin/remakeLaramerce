<template>
  <component
    :is="href ? Link : 'button'"
    :href="href || undefined"
    :type="href ? undefined : type"
    :disabled="disabled || loading"
    :class="[
      'inline-flex items-center justify-center font-medium transition-colors cursor-pointer select-none disabled:opacity-50 disabled:cursor-not-allowed',
      sizeClasses[size] || sizeClasses.md,
      variantClasses[variant] || variantClasses.primary,
    ]"
    @click="handleClick"
  >
    <!-- Icon -->
    <slot name="icon">
      <Icon
        v-if="loading"
        icon="eos-icons:loading"
        :class="iconSizeClasses[size] || iconSizeClasses.md"
      />
      <Icon
        v-else-if="icon"
        :icon="icon"
        :class="iconSizeClasses[size] || iconSizeClasses.md"
      />
    </slot>

    <!-- Content -->
    <slot />
  </component>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";

// Props
const props = defineProps({
  size: {
    type: String,
    default: "md",
    validator: (value: string) => ["sm", "md", "lg"].includes(value),
  },
  variant: {
    type: String,
    default: "primary",
    validator: (value: string) =>
      ["primary", "second", "third"].includes(value),
  },
  icon: {
    type: String,
    default: "",
  },
  href: {
    type: String,
    default: "",
  },
  loading: {
    type: Boolean,
    default: false,
  },
  type: {
    type: String as () => "button" | "submit" | "reset",
    default: "button",
  },
  disabled: {
    type: Boolean,
    default: false,
  },
});

// Emits
const emit = defineEmits({
  click: null,
});

// Click
const handleClick = (event: MouseEvent) => {
  if (!props.disabled && !props.loading) {
    emit("click", event);
  }
};

// Sizes
const sizeClasses: Record<string, string> = {
  sm: "px-3 py-1.5 text-xs rounded-md gap-1.5",
  md: "px-4 py-2 text-sm rounded-lg gap-2",
  lg: "px-5 py-2.5 text-base rounded-lg gap-2.5",
};

// Variants
const variantClasses: Record<string, string> = {
  primary: "bg-gray-900 hover:bg-gray-800 active:bg-black text-white shadow-xs",
  second:
    "bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white shadow-xs",
  third:
    "bg-white hover:bg-gray-50 active:bg-gray-100 text-gray-700 border border-gray-300 shadow-xs",
};

// Icon sizes
const iconSizeClasses: Record<string, string> = {
  sm: "w-3.5 h-3.5",
  md: "w-4 h-4",
  lg: "w-5 h-5",
};
</script>
