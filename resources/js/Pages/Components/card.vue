<template>
  <div
    class="bg-white rounded-lg overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200 flex flex-col"
  >
    <!-- Product Image -->
    <div class="relative overflow-hidden bg-gray-100 w-full h-48">
      <img
        :src="product.variants[0]?.images?.[0]?.image_path"
        :alt="product.name"
        class="w-full h-full object-cover transition-transform duration-300"
      />
      <!-- Badges -->
      <div class="absolute top-2 left-2 flex flex-col gap-1">
        <p
          v-if="product.is_featured ?? product.featured"
          class="bg-yellow-500 text-white text-xs font-bold px-1.5 py-0.5 rounded"
        >
          Featured
        </p>
        <p
          v-if="product.discount"
          class="bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded"
        >
          -{{ product.discount }}%
        </p>
      </div>

      <!-- Out of Stock Badge -->
      <div v-if="product.variants.length <= 0" class="absolute top-2 right-2">
        <p
          class="bg-gray-800 text-white text-xs font-semibold px-2 py-1 rounded"
        >
          Out of Stock
        </p>
      </div>
    </div>

    <!-- Product Info -->
    <div class="p-3 sm:p-4 flex flex-col flex-1">
      <p class="text-xs text-gray-500 mb-1">
        {{ product.category.name }}
      </p>

      <Link
        :href="`/products/${product.slug}`"
        class="text-sm sm:text-base font-semibold text-blue-600 hover:text-blue-800 transition-colors leading-snug mb-2"
      >
        {{ product.name }}
      </Link>

      <!-- Star Rating -->
      <div v-if="product.rating" class="flex items-center gap-1 mb-2">
        <div class="flex">
          <span
            v-for="star in 5"
            :key="star"
            class="text-sm"
            :class="
              star <= product.rating ? 'text-yellow-400' : 'text-gray-300'
            "
          >
            ★
          </span>
        </div>
        <p v-if="product.reviewCount" class="text-xs text-gray-500">
          ({{ product.reviewCount }})
        </p>
      </div>

      <!-- Price -->
      <div class="flex items-center gap-2 mb-3 mt-auto">
        <p class="text-base sm:text-lg font-bold text-gray-900">
          ${{ product.variants[0].price }}
        </p>
      </div>

      <!-- Add to Cart / Out of Stock -->
      <button
        v-if="product.variants.length > 0"
        :id="`addToCart-${product.id_product}`"
        @click="$emit('addToCart', product)"
        class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2 sm:py-2.5 rounded text-sm transition-colors duration-150 cursor-pointer"
      >
        Add to Cart
      </button>
      <button
        v-else
        disabled
        class="w-full bg-gray-200 text-gray-500 font-semibold py-2 sm:py-2.5 rounded text-sm cursor-not-allowed"
      >
        Out of Stock
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";

defineProps({
  product: {
    type: Object,
    required: true,
  },
});

defineEmits(["addToCart"]);
</script>
