<template>
  <div class="min-h-screen bg-gray-50 font-sans flex flex-col justify-between">
    <!-- Navbar -->
    <Navbar />

    <!-- Main -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8 lg:py-10 flex-1 w-full">
      <!-- Breadcrumb -->
      <Breadcrumb
        :items="[
          { label: 'Home', href: '/' },
          { label: 'Shopping Cart' },
        ]"
      />

      <!-- Page Title -->
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight mb-6 sm:mb-8">
        Shopping Cart
      </h1>

      <!-- Cart Has Items -->
      <div v-if="cartItems.length > 0" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start">
        <!-- Cart Items List & Actions -->
        <div class="lg:col-span-8 flex flex-col gap-4">
          <!-- Cart Items Cards -->
          <div
            v-for="item in cartItems"
            :key="item.id"
            :id="`cart-item-${item.id}`"
            class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sm:p-6 transition-shadow"
          >
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
              <!-- Left: Image & Product Info -->
              <div class="flex items-center gap-4 min-w-0 flex-1">
                <a :href="`/products/${item.slug}`" class="flex-shrink-0">
                  <div class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 rounded-xl overflow-hidden border border-gray-100 flex items-center justify-center">
                    <img
                      :src="item.image"
                      :alt="item.name"
                      class="w-full h-full object-cover"
                    />
                  </div>
                </a>

                <div class="min-w-0 flex-1">
                  <a
                    :href="`/products/${item.slug}`"
                    class="font-semibold text-gray-900 hover:text-blue-600 transition-colors text-sm sm:text-base leading-snug line-clamp-2"
                  >
                    {{ item.name }}
                  </a>
                  <p class="text-blue-600 font-semibold text-sm sm:text-base mt-1">
                    ${{ item.price.toFixed(2) }}
                  </p>
                </div>
              </div>

              <!-- Right: Controls (Quantity, Delete, Subtotal) -->
              <div class="flex items-center justify-between sm:justify-end gap-4 w-full sm:w-auto pt-2 sm:pt-0 border-t sm:border-t-0 border-gray-100">
                <!-- Quantity & Delete -->
                <div class="flex items-center gap-2">
                  <!-- Quantity Selector -->
                  <div class="inline-flex items-center border border-gray-200 rounded-lg bg-white overflow-hidden shadow-2xs">
                    <button
                      type="button"
                      :id="`btn-decrement-${item.id}`"
                      @click="decrementItemQty(item)"
                      class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 active:bg-gray-200 transition-colors cursor-pointer disabled:opacity-40 disabled:cursor-not-allowed"
                      :disabled="item.quantity <= 1"
                      aria-label="Decrease quantity"
                    >
                      <Icon icon="lucide:minus" class="w-3.5 h-3.5" />
                    </button>
                    <span class="w-9 h-8 flex items-center justify-center text-xs sm:text-sm font-semibold text-gray-900 border-x border-gray-200 select-none">
                      {{ item.quantity }}
                    </span>
                    <button
                      type="button"
                      :id="`btn-increment-${item.id}`"
                      @click="incrementItemQty(item)"
                      class="w-8 h-8 flex items-center justify-center text-gray-500 hover:bg-gray-100 active:bg-gray-200 transition-colors cursor-pointer"
                      aria-label="Increase quantity"
                    >
                      <Icon icon="lucide:plus" class="w-3.5 h-3.5" />
                    </button>
                  </div>

                  <!-- Remove Item Button -->
                  <button
                    type="button"
                    :id="`btn-remove-${item.id}`"
                    @click="removeItem(item.id)"
                    class="text-red-500 hover:text-red-600 hover:bg-red-50 p-1.5 rounded-lg transition-colors cursor-pointer"
                    title="Remove item"
                    aria-label="Remove item"
                  >
                    <Icon icon="lucide:trash-2" class="w-4 h-4" />
                  </button>
                </div>

                <!-- Item Total Price -->
                <div class="text-right min-w-[70px] sm:min-w-[80px]">
                  <span class="text-base sm:text-lg font-bold text-gray-900">
                    ${{ (item.price * item.quantity).toFixed(2) }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Action Buttons -->
          <div class="flex items-center justify-between pt-2 px-1 text-sm font-medium">
            <!-- Clear Cart -->
            <button
              type="button"
              id="btn-clear-cart"
              @click="clearCart"
              class="text-red-600 hover:text-red-700 hover:underline cursor-pointer transition-colors"
            >
              Clear Cart
            </button>

            <!-- Continue Shopping -->
            <Link
              href="/products"
              id="link-continue-shopping"
              class="text-blue-600 hover:text-blue-700 hover:underline inline-flex items-center gap-1.5 transition-colors"
            >
              <p>&larr;</p>
              <p>Continue Shopping</p>
            </Link>
          </div>
        </div>

        <!-- Order Summary -->
        <div class="lg:col-span-4">
          <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 lg:sticky lg:top-24">
            <h2 class="text-lg font-bold text-gray-900 mb-6">
              Order Summary
            </h2>

            <!-- Summary Breakdown -->
            <div class="space-y-4 text-sm">
              <!-- Subtotal -->
              <div class="flex items-center justify-between">
                <span class="text-gray-500">
                  Subtotal ({{ totalItemsCount }} items)
                </span>
                <span class="font-medium text-gray-400">
                  ${{ subtotal.toFixed(2) }}
                </span>
              </div>

              <!-- Shipping -->
              <div class="flex items-center justify-between">
                <p class="text-gray-500">Shipping</p>
                <p class="text-xs sm:text-sm text-gray-400">
                  Calculated at checkout
                </p>
              </div>

              <!-- Divider -->
              <div class="border-t border-gray-100 pt-4 mt-4">
                <!-- Total -->
                <div class="flex items-center justify-between">
                  <p class="text-base font-bold text-gray-900">Total</p>
                  <p class="text-xl font-bold text-blue-600">
                    ${{ subtotal.toFixed(2) }}
                  </p>
                </div>
              </div>
            </div>

            <!-- Login to Checkout Button -->
            <Link
              id="btn-checkout"
              href="/login"
              class="w-full mt-6 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 px-4 rounded-xl text-sm sm:text-base transition-colors duration-150 shadow-sm flex items-center justify-center gap-2 text-center"
            >
              Login to Checkout
            </Link>

            <!-- Create Account Sublink -->
            <p class="text-center mt-3 text-sm text-gray-500">
              Or
              <Link
                href="/register"
                class="text-blue-600 hover:text-blue-700 hover:underline font-medium"
              >
                create an account
              </Link>
            </p>

            <!-- Value Propositions / Benefits -->
            <div class="mt-8 pt-6 border-t border-gray-100 space-y-3 text-xs sm:text-sm text-gray-600">
              <div class="flex items-center gap-2">
                <Icon icon="lucide:check" class="w-4 h-4 text-emerald-500 flex-shrink-0" />
                <p>Secure Checkout</p>
              </div>
              <div class="flex items-center gap-2">
                <Icon icon="lucide:check" class="w-4 h-4 text-emerald-500 flex-shrink-0" />
                <p>Free Shipping on orders over $100</p>
              </div>
              <div class="flex items-center gap-2">
                <Icon icon="lucide:check" class="w-4 h-4 text-emerald-500 flex-shrink-0" />
                <p>Easy Returns</p>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Empty Cart -->
      <div
        v-else
        id="empty-cart-container"
        class="bg-white rounded-2xl border border-gray-100 shadow-sm p-10 sm:p-16 text-center max-w-2xl mx-auto my-6 sm:my-10"
      >
        <!-- Large Cart Icon -->
        <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-5 text-gray-400">
          <Icon icon="lucide:shopping-cart" class="w-10 h-10" />
        </div>

        <!-- Empty State Title -->
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 mb-2">
          Your cart is empty
        </h2>

        <!-- Empty State Subtitle -->
        <p class="text-sm text-gray-500 mb-8 max-w-sm mx-auto">
          Add some products to get started!
        </p>

        <!-- Start Shopping Button -->
        <Link
          href="/products"
          id="btn-start-shopping"
          class="inline-flex items-center justify-center bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-3 px-8 rounded-xl text-sm sm:text-base transition-colors shadow-sm"
        >
          Start Shopping
        </Link>
      </div>
    </main>

    <Footer />
  </div>
</template>

<script setup lang="ts">
import { ref, computed } from "vue";
import { Icon } from "@iconify/vue";
import { Link } from "@inertiajs/vue3";
import Navbar from "./Components/navbar.vue";
import Footer from "./Components/footer.vue";
import Breadcrumb from "./Components/breadcrumb.vue";

// Cart Items State
const cartItems = ref([
  {
    id: 1,
    name: "Dolor Sed Porro",
    slug: "dolor-sed-porro",
    price: 45.81,
    quantity: 1,
    image:
      "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&q=80",
  },
]);

// Computed Calculations
const totalItemsCount = computed(() => {
  return cartItems.value.reduce((total, item) => total + item.quantity, 0);
});

const subtotal = computed(() => {
  return cartItems.value.reduce(
    (sum, item) => sum + item.price * item.quantity,
    0
  );
});

// Methods
function incrementItemQty(item: { id: number; quantity: number }) {

  item.quantity++;
}

function decrementItemQty(item: { id: number; quantity: number }) {
  if (item.quantity > 1) {
    item.quantity--;
  }
}

function removeItem(id: number) {
  cartItems.value = cartItems.value.filter((item) => item.id !== id);
}

function clearCart() {
  cartItems.value = [];
}
</script>
