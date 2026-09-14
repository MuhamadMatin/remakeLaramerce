<template>
  <DashboardLayout class="min-h-screen bg-gray-50 font-sans">
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
      <div class="flex flex-col lg:flex-row lg:gap-8 lg:items-start">
        <!-- Sidebar -->
        <aside
          class="w-full lg:w-64 lg:flex-shrink-0 mb-6 lg:mb-0 lg:sticky lg:top-20"
        >
          <span class="flex gap-3 justify-between">
            <!-- Breadcrumb -->
            <Breadcrumb
              :items="[{ label: 'Home', href: '/' }, { label: 'Shop' }]"
            />
            <p
              @click="clearAllFilterSearch()"
              class="text-sm font-medium text-gray-900 hover:text-gray-700 hover:underline transition-colors cursor-pointer"
            >
              Clear
            </p>
          </span>

          <!-- Mobile toggle button -->
          <button
            class="lg:hidden w-full flex items-center justify-between bg-white border border-gray-200 rounded-lg px-4 py-3 mb-3 shadow-sm"
            @click="showCategoryFilter = !showCategoryFilter"
          >
            <span class="font-semibold text-sm text-gray-900">Filter</span>
            <Icon
              :icon="
                showCategoryFilter ? 'lucide:chevron-up' : 'lucide:chevron-down'
              "
              class="w-4 h-4 text-gray-500"
            />
          </button>

          <!-- Category -->
          <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden"
            :class="showCategoryFilter ? 'block' : 'hidden lg:block'"
          >
            <button
              type="button"
              class="w-full px-4 py-3 flex items-center justify-between font-bold text-sm text-gray-900 hover:bg-gray-50 transition-colors hover:cursor-pointer"
              :class="{ 'border-b border-gray-100': isCategoryOpen }"
              @click="isCategoryOpen = !isCategoryOpen"
            >
              <p>Categories</p>
              <Icon
                :icon="
                  isCategoryOpen ? 'lucide:chevron-up' : 'lucide:chevron-down'
                "
                class="w-4 h-4 text-gray-500"
              />
            </button>
            <ul v-show="isCategoryOpen" class="py-2">
              <li>
                <Link
                  href="/products"
                  class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-gray-50 hover:cursor-pointer flex items-center justify-between text-gray-600 hover:text-gray-900"
                >
                  <p>All Categories</p>
                </Link>
              </li>
              <li v-for="category in categories" :key="category.id_category">
                <span
                  @click="categoryFilter(category.slug)"
                  class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-gray-50 hover:cursor-pointer flex items-center justify-between hover:text-gray-900"
                  :class="
                    selectedCategory === category.slug
                      ? 'bg-gray-100 text-gray-900 font-semibold'
                      : 'text-gray-600'
                  "
                >
                  <p class="truncate">{{ category.name }}</p>
                  <p class="text-gray-400 text-xs ml-1">
                    ({{ category.products_count }})
                  </p>
                </span>
              </li>
            </ul>
          </div>

          <!-- Brand -->
          <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mt-6"
            :class="showBrandFilter ? 'block' : 'hidden lg:block'"
          >
            <button
              type="button"
              class="w-full px-4 py-3 flex items-center justify-between font-bold text-sm text-gray-900 hover:bg-gray-50 transition-colors hover:cursor-pointer"
              :class="{ 'border-b border-gray-100': isBrandOpen }"
              @click="isBrandOpen = !isBrandOpen"
            >
              <p>Brands</p>
              <Icon
                :icon="
                  isBrandOpen ? 'lucide:chevron-up' : 'lucide:chevron-down'
                "
                class="w-4 h-4 text-gray-500"
              />
            </button>

            <ul v-show="isBrandOpen" class="py-2">
              <li>
                <Link
                  href="/products"
                  class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-gray-50 hover:cursor-pointer flex items-center justify-between text-gray-600 hover:text-gray-900"
                >
                  <p>All Brands</p>
                </Link>
              </li>
              <li v-for="brand in brands" :key="brand.id_brand">
                <span
                  @click="sortFilter(brand.slug)"
                  class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-gray-50 hover:cursor-pointer flex items-center justify-between hover:text-gray-900"
                  :class="
                    selectedSort === brand.slug
                      ? 'bg-gray-100 text-gray-900 font-semibold'
                      : 'text-gray-600'
                  "
                >
                  <p class="truncate">{{ brand.name }}</p>
                </span>
              </li>
            </ul>
          </div>

          <!-- Sorting -->
          <div
            class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden mt-6"
            :class="showCategoryFilter ? 'block' : 'hidden lg:block'"
          >
            <button
              type="button"
              class="w-full px-4 py-3 flex items-center justify-between font-bold text-sm text-gray-900 hover:bg-gray-50 transition-colors hover:cursor-pointer"
              :class="{ 'border-b border-gray-100': isSortingOpen }"
              @click="isSortingOpen = !isSortingOpen"
            >
              <p>Sorting By</p>
              <Icon
                :icon="
                  isSortingOpen ? 'lucide:chevron-up' : 'lucide:chevron-down'
                "
                class="w-4 h-4 text-gray-500"
              />
            </button>

            <ul v-show="isSortingOpen" class="py-2">
              <li v-for="sorting in sortArray" :key="sorting.value">
                <span
                  @click="sortFilter(sorting.value)"
                  class="w-full text-left px-4 py-2 text-sm transition-colors hover:bg-gray-50 hover:cursor-pointer flex items-center justify-between hover:text-gray-900"
                  :class="
                    selectedSort === sorting.value
                      ? 'bg-gray-100 text-gray-900 font-semibold'
                      : 'text-gray-600'
                  "
                >
                  <p class="truncate">{{ sorting.name }}</p>
                </span>
              </li>
            </ul>
          </div>
        </aside>

        <!-- Products -->
        <div class="flex-1 min-w-0">
          <div
            class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6 sm:mb-8"
          >
            <div>
              <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                All Products
              </h1>
              <p class="text-sm text-gray-500 mt-1">
                Showing {{ products.data.length }} products
              </p>
            </div>
          </div>

          <!-- Infinite Scroll -->
          <InfiniteScroll data="products" :buffer="300" only-next preserve-url>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-5 md:gap-4">
              <Card
                v-for="product in products.data"
                :key="product.id_product"
                :product="product"
                @add-to-cart="addToCart"
              />
            </div>

            <!-- Loading -->
            <template #loading>
              <div class="flex justify-center items-center py-8">
                <div
                  class="w-8 h-8 border-4 border-gray-300 border-t-gray-900 rounded-full animate-spin"
                />
              </div>
            </template>

            <!-- Next -->
            <template #next="{ loading, hasMore }">
              <div v-if="loading" class="flex justify-center items-center py-8">
                <div
                  class="w-8 h-8 border-4 border-gray-300 border-t-gray-900 rounded-full animate-spin"
                />
              </div>
              <div v-else-if="!hasMore" class="text-center py-8">
                <p class="text-gray-400 text-sm">All products loaded</p>
              </div>
            </template>
          </InfiniteScroll>

          <!-- If Empty -->
          <div
            v-if="!products.data || products.data.length === 0"
            class="text-center py-16"
          >
            <Icon
              icon="lucide:package-search"
              class="w-16 h-16 text-gray-300 mx-auto mb-4"
            />
            <p class="text-gray-500 text-lg font-medium">No products found</p>
          </div>
        </div>
      </div>
    </main>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref, watch } from "vue";
import { Icon } from "@iconify/vue";
import debounce from "../../debounce.js";
import { Link, InfiniteScroll, router, usePage } from "@inertiajs/vue3";
import { searchProducts } from "../../useSearch.js";
import DashboardLayout from "../Layouts/dashboard.vue";
import Breadcrumb from "../Components/breadcrumb.vue";
import Card from "../Components/card.vue";

// Props
const props = defineProps({
  categories: {
    type: Array,
    default: () => [],
  },
  brands: {
    type: Array,
    default: () => [],
  },
  products: {
    type: Object,
    default: () => ({ data: [] }),
  },
});

const sortArray = ref([
  { name: "Newest", value: "newest" },
  { name: "Oldest", value: "oldest" },
  { name: "Price: Low to High", value: "price-asc" },
  { name: "Price: High to Low", value: "price-desc" },
  { name: "Name: A-Z", value: "name-asc" },
  { name: "Name: Z-A", value: "name-desc" },
]);

const showBrandFilter = ref(false);
const showCategoryFilter = ref(false);
const isCategoryOpen = ref(true);
const isBrandOpen = ref(true);
const isSortingOpen = ref(true);
const selectedCategory = ref("");
const selectedBrand = ref("");
const selectedSort = ref("newest");

function brandFilter(slug: string) {
  selectedBrand.value = slug;
  applyFilter();
}

function categoryFilter(slug: string) {
  selectedCategory.value = slug;
  applyFilter();
}

function sortFilter(value: string) {
  selectedSort.value = value;
  applyFilter();
}

function clearAllFilterSearch() {
  searchProducts.value = "";
  selectedCategory.value = "";
  selectedBrand.value = "";
  selectedSort.value = "";
  applyFilter();
}

watch(searchProducts, () => {
  applyFilter();
});

// Filter request
const applyFilter = debounce(() => {
  router.get(
    "/products",
    {
      search: searchProducts.value,
      category: selectedCategory.value,
      brand: selectedBrand.value,
      sorting: selectedSort.value,
    },
    {
      preserveState: true,
      preserveScroll: true,
      replace: true,
    },
  );
}, 500);

function addToCart(product: any) {
  console.log("Added to cart:", product.name);
}
</script>
