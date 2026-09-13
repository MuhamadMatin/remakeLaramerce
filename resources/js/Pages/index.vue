<template>
  <DashboardLayout class="min-h-screen bg-gray-50 font-sans">
    <!-- Hero Banner -->
    <section
      id="hero-section"
      class="bg-blue-600 text-white py-14 sm:py-20 lg:py-28 text-center"
    >
      <div class="max-w-3xl mx-auto px-4">
        <h1
          class="text-2xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-3 sm:mb-4"
        >
          Welcome to E-Commerce Store
        </h1>
        <p class="text-blue-100 text-sm sm:text-base lg:text-lg mb-6 sm:mb-8">
          Discover amazing products at unbeatable prices
        </p>
        <Link
          id="shop-now-btn"
          href="/products"
          class="inline-block bg-white text-blue-600 font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded text-sm sm:text-base hover:bg-blue-50 transition-colors shadow"
        >
          Shop Now
        </Link>
      </div>
    </section>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
      <!-- Shop by Category -->
      <section id="category-section" class="mb-10 sm:mb-12 lg:mb-16 overflow-auto">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">
          Shop by Category
        </h2>

        <!-- Mobile: 2 cols | Tablet: 3 cols | Desktop: 6 cols -->
        <div
          class="flex gap-4 overflow-auto"
        >
          <Link
            v-for="category in categories"
            :key="category.id_category"
            :href="`/products?category=${category.slug}`"
            class="group flex flex-col items-center cursor-pointer"
          >
            <!-- Image or Color Box -->
            <div
              class="w-full aspect-square rounded-lg overflow-hidden h-28 w-28 md:h-32 md:w-32 lg:h-40 lg:w-40 mb-2 sm:mb-3 transition-transform duration-200 shadow-sm bg-blue-600 flex items-center justify-center"
            >
              <img
                v-if="category.image_path"
                :src="category.image_path"
                :alt="category.name"
                class="w-full h-full object-cover"
              />
              <p v-else class="text-white font-bold text-3xl sm:text-4xl">

                {{ category.name.charAt(0).toUpperCase()}}
              </p>
            </div>

            <p
              class="text-center text-xs sm:text-sm font-semibold text-gray-800 leading-tight"
            >
              {{ category.name }}
            </p>
            <p class="text-center text-xs text-gray-500 mt-0.5">
              {{ category.products_count }} items
            </p>
          </Link>
        </div>
      </section>

      <!-- Featured Products -->
      <section id="featured-products-section" class="mb-10 sm:mb-12 lg:mb-16">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
          <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            Featured Products
          </h2>
          <Link
            id="view-all-featured-btn"
            href="/products"
            class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors"
          >
            View All →
          </Link>
        </div>

        <!-- Mobile: 1 col | Tablet: 2-3 cols | Desktop: 4 cols -->
        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5"
        >
          <Card
            v-for="product in featured_products"
            :key="product.id_product"
            :product="product"
            @addToCart="addToCart"
          />
        </div>
      </section>

      <!-- Newest Products -->
      <section id="newest-products-section">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
          <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            Newest Products
          </h2>
          <Link
            id="view-all-newest-btn"
            href="/products"
            class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors"
          >
            View All →
          </Link>
        </div>

        <!-- Mobile: 1 col | Tablet: 2-3 cols | Desktop: 4 cols -->
        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-5"
        >
          <Card
            v-for="product in newest_products"
            :key="product.id_product"
            :product="product"
            @addToCart="addToCart"
          />
        </div>
      </section>
    </main>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import Card from "./Components/card.vue";
import DashboardLayout from "./Layouts/dashboard.vue";

// Props
defineProps({
  categories: {
    type: Array,
    default: () => [],
  },
  featured_products: {
    type: Array,
    default: () => [],
  },
  newest_products: {
    type: Array,
    default: () => [],
  },
});

function addToCart(product: any) {
  console.log("Added to cart:", product.name);
}
</script>


