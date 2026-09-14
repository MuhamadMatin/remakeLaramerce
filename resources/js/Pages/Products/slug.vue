<template>
  <div class="min-h-screen bg-gray-50 font-sans">
    <!-- Navbar -->
    <Navbar />

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10">
      <!-- Breadcrumb -->
      <Breadcrumb
        :items="[
          { label: 'Home', href: '/' },
          { label: 'Shop', href: '/products' },
          {
            label: product.category.name,
            href: `/products?category=${product.category.slug}`,
          },
          { label: product.name },
        ]"
      />

      <!-- Product Detail Card -->
      <div
        class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 lg:p-10"
      >
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-12">
          <!-- Image Gallery -->
          <div class="flex flex-col">
            <!-- Main Product Image -->
            <div
              class="w-full aspect-square bg-gray-100 rounded-xl overflow-hidden mb-4 border border-gray-100"
            >
              <ZoomImg
                :src="selectedImage"
                :alt="product.name"
                class="w-full h-full object-cover"
                zoom-type="move"
                trigger="click"
              />
            </div>

            <!-- Thumbnail Gallery -->
            <div
              v-if="
                selectedVariant?.images && selectedVariant.images.length > 1
              "
              class="flex items-center gap-3 overflow-x-auto pb-2 scrollbar-none"
            >
              <button
                v-for="(img, id) in selectedVariant.images"
                :key="id"
                type="button"
                @click="selectedImage = img.image_path"
                class="relative w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100 transition-all cursor-pointer"
                :class="
                  selectedImage === img.image_path
                    ? 'border-2 border-gray-900 shadow-sm'
                    : 'border border-gray-200 hover:border-gray-300 opacity-75 hover:opacity-100'
                "
              >
                <img
                  :src="img.image_path"
                  :alt="`${product.name} thumbnail ${id + 1}`"
                  class="w-full h-full object-cover"
                />
              </button>
            </div>
          </div>

          <div class="flex flex-col justify-start">
            <!-- Product Title -->
            <h1
              class="text-2xl sm:text-3xl font-bold text-gray-900 leading-tight mb-3"
            >
              {{ product.name }}
            </h1>

            <!-- Product Price -->
            <div class="flex items-baseline gap-3 mb-4">
              <span class="text-2xl sm:text-3xl font-bold text-gray-900">
                ${{ selectedVariant.price }}
              </span>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-100 my-2"></div>

            <!-- Description -->
            <p class="text-sm sm:text-base text-gray-600 leading-relaxed mb-6">
              {{ product.description }}
            </p>

            <!-- Variants -->
            <div class="mb-6">
              <label class="text-sm font-semibold text-gray-700 block mb-2">
                Variant:
              </label>
              <div class="flex flex-wrap gap-2 max-h-52 overflow-auto">
                <button
                  v-for="(variant, idx) in product.variants"
                  :key="variant.id_product_variant"
                  type="button"
                  @click="selectVariant(variant)"
                  class="px-3 py-1.5 rounded-lg text-sm font-medium border transition-colors cursor-pointer"
                  :class="
                    selectedVariant?.id_product_variant ===
                    variant.id_product_variant
                      ? 'bg-gray-900 text-white border-gray-900 shadow-xs'
                      : 'bg-white text-gray-700 border-gray-200 hover:bg-gray-50'
                  "
                >
                  {{
                    variant.name ||
                    variant.color ||
                    variant.size ||
                    `Variant ${idx + 1}`
                  }}
                </button>
              </div>
            </div>

            <p class="text-sm font-semibold text-gray-700 block mb-4">
              Available: {{ maxStock }}
            </p>

            <!-- Quantity Selector -->
            <div class="flex items-center gap-4 mb-6">
              <div
                class="flex items-center border border-gray-200 rounded-lg overflow-hidden bg-white shadow-xs"
              >
                <button
                  type="button"
                  id="btn-decrement-qty"
                  @click="decrementQty"
                  class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 active:bg-gray-200 transition-colors disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
                  :disabled="quantity <= 1 || !inStock"
                >
                  <Icon icon="lucide:minus" class="w-4 h-4" />
                </button>

                <p
                  class="w-12 text-center text-sm font-semibold text-gray-900 select-none"
                >
                  {{ inStock ? quantity : 0 }}
                </p>

                <button
                  type="button"
                  id="btn-increment-qty"
                  @click="incrementQty"
                  class="w-10 h-10 flex items-center justify-center text-gray-600 hover:bg-gray-100 active:bg-gray-200 transition-colors disabled:opacity-40 disabled:cursor-not-allowed cursor-pointer"
                  :disabled="quantity >= maxStock || !inStock"
                >
                  <Icon icon="lucide:plus" class="w-4 h-4" />
                </button>
              </div>
            </div>

            <!-- Add to Cart Button -->
            <div class="flex flex-col md:flex-row mb-6 gap-2">
              <button
                type="button"
                id="btn-add-to-cart"
                @click="addToCart"
                :disabled="!inStock"
                class="w-full text-gray-800 border-gray-800 hover:bg-gray-100 font-semibold py-3.5 px-6 rounded-xl transition-all duration-150 flex items-center justify-center gap-2 shadow-sm disabled:bg-gray-300 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer"
              >
                <Icon icon="lucide:shopping-cart" class="w-5 h-5" />
                <p>{{ inStock ? "Buy Now" : "Out of Stock" }}</p>
              </button>
              <button
                type="button"
                id="btn-add-to-cart"
                @click="addToCart"
                :disabled="!inStock"
                class="w-full bg-gray-900 hover:bg-gray-700 active:bg-black text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-150 flex items-center justify-center gap-2 shadow-sm disabled:bg-gray-300 disabled:cursor-not-allowed disabled:shadow-none cursor-pointer"
              >
                <Icon icon="lucide:shopping-cart" class="w-5 h-5" />
                <p>{{ inStock ? "Add Cart" : "Out of Stock" }}</p>
              </button>
            </div>

            <div class="border-t border-gray-100 pt-4 space-y-2">
              <div class="flex items-center justify-between text-sm">
                <p class="text-gray-500 font-medium">SKU:</p>
                <p class="font-mono text-gray-700">{{ selectedVariant.sku }}</p>
              </div>
              <div class="flex items-center justify-between text-sm">
                <p class="text-gray-500 font-medium">Category:</p>
                <p class="font-medium text-gray-900">
                  {{ product.category.name }}
                </p>
              </div>
              <div class="flex items-center justify-between text-sm">
                <p class="text-gray-500 font-medium">Store:</p>
                <p class="font-medium text-gray-900">
                  {{ product.store.name }}
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Description & Reviews -->
      <section class="mt-8 sm:mt-10 lg:mt-12">
        <div
          class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden"
        >
          <!-- Tab Headers -->
          <div
            class="border-b border-gray-200 px-4 sm:px-6 lg:px-8 flex gap-6 sm:gap-8"
          >
            <button
              type="button"
              id="tab-description"
              @click="activeTab = 'description'"
              class="py-4 text-sm sm:text-base font-semibold transition-colors cursor-pointer border-b-2 -mb-px"
              :class="
                activeTab === 'description'
                  ? 'border-gray-900 text-gray-900'
                  : 'border-transparent text-gray-500 hover:text-gray-700'
              "
            >
              Description
            </button>
            <button
              type="button"
              id="tab-reviews"
              @click="activeTab = 'reviews'"
              class="py-4 text-sm sm:text-base font-semibold transition-colors cursor-pointer border-b-2 -mb-px"
              :class="
                activeTab === 'reviews'
                  ? 'border-gray-900 text-gray-900'
                  : 'border-transparent text-gray-500 hover:text-gray-700'
              "
            >
              Reviews (0)
            </button>
          </div>

          <!-- Tab Content -->
          <div class="p-5 sm:p-6 lg:p-8">
            <div
              v-show="activeTab === 'description'"
              class="text-sm sm:text-base text-gray-600 leading-relaxed space-y-4"
            >
              <p>
                {{
                  product.description ||
                  "No description available for this product."
                }}
              </p>
            </div>

            <div
              v-show="activeTab === 'reviews'"
              class="text-center py-8 text-gray-500"
            >
              <Icon
                icon="lucide:message-square"
                class="w-10 h-10 text-gray-300 mx-auto mb-2"
              />
              <p class="font-medium text-gray-700">No reviews yet</p>
              <p class="text-xs sm:text-sm text-gray-400 mt-1">
                Be the first to review this product!
              </p>
            </div>
          </div>
        </div>
      </section>

      <!-- Related Products -->
      <section class="mt-10 sm:mt-14 lg:mt-16">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6">
          Related Products
        </h2>

        <div
          v-if="related_products"
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6"
        >
          <Card
            v-for="relProduct in related_products"
            :key="relProduct.id_product"
            :product="relProduct"
            @addToCart="addRelatedToCart"
          />
        </div>
        <div
          v-else
          class="text-center py-8 text-gray-400 bg-white rounded-xl border border-gray-100"
        >
          <p class="text-sm">No related products found.</p>
        </div>
      </section>
    </main>

    <!-- Footer -->
    <Footer />
  </div>
</template>

<script setup lang="ts">
import { Icon } from "@iconify/vue";
import { ZoomImg } from "vue3-zoomer";
import { ref, computed, watch } from "vue";
import Navbar from "../Components/navbar.vue";
import Footer from "../Components/footer.vue";
import Breadcrumb from "../Components/breadcrumb.vue";
import Card from "../Components/card.vue";

// Props
const props = defineProps({
  product: {
    type: Object,
    required: true,
  },
  related_products: {
    type: Array,
    default: () => [],
  },
});

// State
const selectedVariant = ref(props.product.variants?.[0]);

const primaryImage = (variant: any) => {
  return (
    variant?.images?.find((img: any) => img.is_primary)?.image_path ??
    variant?.images?.[0]?.image_path ??
    variant?.image_path ??
    ""
  );
};

const selectedImage = ref(primaryImage(selectedVariant.value));
const quantity = ref(1);
const activeTab = ref<"description" | "reviews">("description");

// Watch variant change to reset image
watch(selectedVariant, (newVariant) => {
  selectedImage.value = primaryImage(newVariant);
});

// Computed
const inStock = computed(() => {
  return (selectedVariant.value?.stock ?? 0) > 0;
});

const maxStock = computed(() => {
  return selectedVariant.value?.stock ?? 0;
});

// Methods
function selectVariant(variant: any) {
  selectedVariant.value = variant;
  quantity.value = 1;
}

function incrementQty() {
  if (quantity.value < maxStock.value) {
    quantity.value++;
  }
}

function decrementQty() {
  if (quantity.value > 1) {
    quantity.value--;
  }
}

function addToCart() {
  console.log(
    `Added ${quantity.value} item(s) of "${props.product.name}" (${selectedVariant.value?.name ?? "Default"}) to cart`,
  );
}

function addRelatedToCart(relProduct: any) {
  console.log(`Added related product "${relProduct.name}" to cart`);
}
</script>
