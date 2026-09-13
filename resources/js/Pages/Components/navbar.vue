<template>
  <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div
        class="flex flex-wrap items-center gap-y-2 py-2 md:flex-nowrap md:h-16"
      >
        <!-- Logo -->
        <Link href="/" class="flex-shrink-0 flex items-center gap-2 order-1">
          <Icon icon="lucide:store" class="w-8 h-8 text-blue-600" />
          <p class="text-blue-600 font-bold text-lg sm:text-xl tracking-tight">
            Store
          </p>
        </Link>

        <div class="relative w-full order-3 md:mx-16 md:order-2 lg:mx-24">
          <input
            type="text"
            v-model="searchInput"
            placeholder="Search products..."
            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent bg-gray-50"
            @input="handleSearch"
          />
          <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
            <Icon icon="lucide:search" class="w-4 h-4" />
          </span>
        </div>

        <div
          class="w-fit flex items-center gap-3 sm:gap-4 ml-auto order-2 md:order-3"
        >
          <!-- Login Button -->
          <Link
            :href="!$page.props.auth.user ? '/login' : 'dashboard'"
            id="login-btn"
            class="text-sm font-medium transition-colors"
            :class="
              $page.url.startsWith('/login')
                ? 'text-blue-600 font-semibold'
                : 'text-gray-700 hover:text-blue-600'
            "
          >
            <Icon :icon="!$page.props.auth.user ? 'carbon:login' : 'akar-icons:home-alt1'" class="w-6 h-6" />
          </Link>

          <!-- Cart Icon -->
          <Link
            href="/cart"
            class="relative transition-colors inline-flex items-center justify-center p-1"
            :class="
              $page.url.startsWith('/cart')
                ? 'text-blue-600 font-semibold'
                : 'text-gray-700 hover:text-blue-600'
            "
          >
            <Icon icon="lucide:shopping-cart" class="w-6 h-6" />
            <p
              v-if="cartCount > 0"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center font-bold"
            >
              {{ cartCount }}
            </p>
          </Link>
        </div>
      </div>
    </div>
  </header>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Icon } from "@iconify/vue";
import { Link, router, usePage } from "@inertiajs/vue3";
import debounce from "../../debounce.js";
import { searchProducts } from "../../useSearch.js";

const cartCount = ref(0);
const searchInput = ref("");

const handleSearch = debounce(() => {
  searchProducts.value = searchInput.value;
}, 500);

// Navigation Links
// const navLinks = ref([
//   { label: "Home", href: "/" },
//   { label: "Shop", href: "/products" },
//   { label: "Electronics", href: "/products?category=electronics" },
//   { label: "Fashion & Apparel", href: "/products?category=fashion" },
//   { label: "Home & Garden", href: "/products?category=home-garden" },
//   { label: "Sports & Outdoors", href: "/products?category=sports" },
//   { label: "Books & Media", href: "/products?category=books" },
// ]);

function addToCart(product: { id: number; name: string; price: number }) {
  cartCount.value++;
  console.log("Added to cart:", product.name);
}
</script>
