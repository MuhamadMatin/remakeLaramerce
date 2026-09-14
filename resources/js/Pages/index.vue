<template>
  <DashboardLayout class="min-h-screen bg-gray-50 font-sans">
    <!-- Hero Banner -->
    <section
      id="hero-section"
      class="bg-gray-900 text-white py-14 sm:py-20 lg:py-28 text-center"
    >
      <div class="max-w-3xl mx-auto px-4">
        <h1
          class="text-2xl sm:text-4xl lg:text-5xl font-bold leading-tight mb-3 sm:mb-4"
        >
          Welcome to E-Commerce Store
        </h1>
        <p class="text-gray-300 text-sm sm:text-base lg:text-lg mb-6 sm:mb-8">
          Discover amazing products at unbeatable prices
        </p>
        <Link
          id="shop-now-btn"
          href="/products"
          class="inline-block bg-white text-gray-900 font-semibold px-6 sm:px-8 py-2.5 sm:py-3 rounded text-sm sm:text-base hover:bg-gray-100 transition-colors shadow"
        >
          Shop Now
        </Link>
      </div>
    </section>

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-10 lg:py-12">
      <!-- Shop by Category -->
      <section
        id="category-section"
        class="mb-10 sm:mb-12 lg:mb-16 overflow-auto"
      >
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6">
          Shop by Category
        </h2>

        <!-- Mobile: 2 cols | Tablet: 3 cols | Desktop: 6 cols -->
        <div class="flex gap-4 overflow-auto">
          <Link
            v-for="category in categories"
            :key="category.id_category"
            :href="`/products?category=${category.slug}`"
            class="group flex flex-col items-center cursor-pointer"
          >
            <!-- Image or Color Box -->
            <div
              class="w-full aspect-square rounded-lg overflow-hidden h-28 w-28 md:h-32 md:w-32 lg:h-40 lg:w-40 mb-2 sm:mb-3 transition-transform duration-200 shadow-sm bg-gray-900 flex items-center justify-center"
            >
              <img
                v-if="category.image_path"
                :src="category.image_path"
                :alt="category.name"
                class="w-full h-full object-cover"
              />
              <p v-else class="text-white font-bold text-3xl sm:text-4xl">
                {{ category.name.charAt(0).toUpperCase() }}
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

      <!-- Newest Products -->
      <section id="newest-products-section">
        <div class="flex items-center justify-between mb-4 sm:mb-6">
          <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
            Newest Products
          </h2>
          <Link
            id="view-all-newest-btn"
            href="/products"
            class="text-sm text-gray-900 hover:text-gray-700 font-medium transition-colors"
          >
            View All →
          </Link>
        </div>

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

      <!-- Brands -->
      <section class="my-12 md:my-16 lg:my-20">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900">
          We're Brands
        </h2>

        <div
          class="mt-8 flex gap-6 overflow-x-auto pb-4 md:mt-10 lg:grid md:gap-x-10 md:gap-y-12 md:overflow-auto md:pb-0 lg:mt-12 lg:grid-cols-3 lg:gap-x-12 lg:gap-y-14"
        >
          <Link
            v-for="brand in brands"
            :key="brand.id_brand"
            :href="`/products?brand=${brand.slug}`"
            class="group block shrink-0 transition-opacity hover:opacity-85 md:shrink"
          >
            <div class="flex items-center lg:justify-center gap-3">
              <div
                v-if="brand.image_path"
                class="flex h-14 w-14 shrink-0 items-center justify-center overflow-hidden p-1 md:h-20 md:w-20"
              >
                <img
                  :src="brand.image_path"
                  :alt="brand.name"
                  class="h-full w-full object-contain"
                />
              </div>
              <span
                v-else
                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-gray-900 text-sm font-bold text-white md:h-11 md:w-11"
              >
                {{ brand.name }}
              </span>
              <h3
                class="text-xl font-bold tracking-tight text-gray-900 transition-colors group-hover:text-gray-700 md:text-2xl lg:text-3xl"
              >
                {{ brand.name }}
              </h3>
            </div>
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
            class="text-sm text-gray-900 hover:text-gray-700 font-medium transition-colors"
          >
            View All →
          </Link>
        </div>

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

      <!-- Features -->
      <section
        class="my-12 -mx-4 bg-white px-4 py-10 md:-mx-6 md:my-16 md:px-6 md:py-14 lg:-mx-8 lg:my-20 lg:px-8 lg:py-16"
      >
        <div
          class="grid grid-cols-1 gap-8 md:grid-cols-2 md:gap-6 lg:grid-cols-4 lg:gap-8"
        >
          <!-- Shipping -->
          <div class="flex flex-col items-center text-center">
            <Icon
              icon="lucide:truck"
              class="h-8 w-8 text-gray-900 md:h-9 md:w-9"
            />
            <h3
              class="mt-3 text-sm font-semibold text-gray-900 md:mt-4 md:text-base"
            >
              Free World-Wide Shipping
            </h3>
            <p class="mt-1 text-xs text-gray-500 md:mt-1.5 md:text-sm">
              Free shipping on all orders over $100
            </p>
          </div>

          <!-- Guarantee -->
          <div class="flex flex-col items-center text-center">
            <Icon
              icon="lucide:rotate-ccw"
              class="h-8 w-8 text-gray-900 md:h-9 md:w-9"
            />
            <h3
              class="mt-3 text-sm font-semibold text-gray-900 md:mt-4 md:text-base"
            >
              Money Back Guarantee
            </h3>
            <p class="mt-1 text-xs text-gray-500 md:mt-1.5 md:text-sm">
              We return money within 30 days
            </p>
          </div>

          <!-- Support -->
          <div class="flex flex-col items-center text-center">
            <Icon
              icon="lucide:headset"
              class="h-8 w-8 text-gray-900 md:h-9 md:w-9"
            />
            <h3
              class="mt-3 text-sm font-semibold text-gray-900 md:mt-4 md:text-base"
            >
              24/7 Online Support
            </h3>
            <p class="mt-1 text-xs text-gray-500 md:mt-1.5 md:text-sm">
              Friendly 24/7 customer support
            </p>
          </div>

          <!-- Payments -->
          <div class="flex flex-col items-center text-center">
            <Icon
              icon="lucide:shield-check"
              class="h-8 w-8 text-gray-900 md:h-9 md:w-9"
            />
            <h3
              class="mt-3 text-sm font-semibold text-gray-900 md:mt-4 md:text-base"
            >
              Secure Online Payments
            </h3>
            <p class="mt-1 text-xs text-gray-500 md:mt-1.5 md:text-sm">
              We possess SSL / Secure Certificate
            </p>
          </div>
        </div>
      </section>
    </main>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
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
  brands: {
    type: Array,
    default: () => [],
  },
});

function addToCart(product: any) {
  console.log("Added to cart:", product.name);
}
</script>
