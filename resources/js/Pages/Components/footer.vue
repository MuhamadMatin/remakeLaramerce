<template>
  <footer class="bg-white border-t border-gray-100">
    <!-- Main Footer -->
    <div
      class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 sm:pt-16 pb-8 sm:pb-12"
    >
      <div class="flex flex-col lg:flex-row lg:gap-16 xl:gap-24">
        <!-- Branding, Newsletter & Social -->
        <div class="flex-shrink-0 w-full lg:w-72 xl:w-80 mb-12 lg:mb-0">
          <!-- Logo icon -->
          <div class="mb-4">
            <Icon icon="lucide:store" class="w-10 h-10 text-gray-900" />
          </div>

          <!-- Tagline -->
          <p
            class="text-gray-900 font-semibold text-base sm:text-lg leading-snug mb-6 max-w-xs"
          >
            E-Commerce Store is the most productive way to shop for amazing
            products at unbeatable prices.
          </p>

          <!-- Newsletter Form -->
          <form
            id="newsletter-form"
            @submit.prevent="subscribeNewsletter"
            class="mb-6"
          >
            <!-- Name row -->
            <div class="flex gap-2 mb-2">
              <input
                id="footer-first-name"
                type="text"
                placeholder="First name"
                class="flex-1 min-w-0 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
              />
              <input
                id="footer-last-name"
                type="text"
                placeholder="Last name"
                class="flex-1 min-w-0 border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent"
              />
            </div>
            <!-- Email -->
            <input
              id="footer-email"
              type="email"
              v-model="newsletterEmail"
              placeholder="Email address"
              class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent mb-2"
            />
            <!-- Submit -->
            <button
              id="footer-subscribe-btn"
              type="submit"
              class="w-full bg-gray-900 hover:bg-gray-700 text-white font-medium py-2.5 rounded text-sm transition-colors duration-150 hover:cursor-pointer"
            >
              Stay updated
            </button>
            <p class="text-xs text-gray-400 mt-2 leading-relaxed">
              By submitting this form, you agree to our
              <a href="/terms" class="underline hover:text-gray-600">terms</a>.
              You can opt-out anytime.
            </p>
          </form>

          <!-- Social Icons -->
          <div class="flex items-center gap-5">
            <!-- GitHub -->
            <a
              id="social-github"
              href="https://github.com"
              target="_blank"
              rel="noopener"
              class="text-gray-500 hover:text-gray-900 transition-colors"
              aria-label="GitHub"
            >
              <Icon icon="mdi:github" class="w-6 h-6" />
            </a>
            <!-- X / Twitter -->
            <a
              id="social-x"
              href="https://x.com"
              target="_blank"
              rel="noopener"
              class="text-gray-500 hover:text-gray-900 transition-colors"
              aria-label="X (Twitter)"
            >
              <Icon icon="ri:twitter-x-fill" class="w-5 h-5" />
            </a>
            <!-- YouTube -->
            <a
              id="social-youtube"
              href="https://youtube.com"
              target="_blank"
              rel="noopener"
              class="text-gray-500 hover:text-gray-900 transition-colors"
              aria-label="YouTube"
            >
              <Icon icon="mdi:youtube" class="w-6 h-6" />
            </a>
            <!-- Discord -->
            <a
              id="social-discord"
              href="https://discord.com"
              target="_blank"
              rel="noopener"
              class="text-gray-500 hover:text-gray-900 transition-colors"
              aria-label="Discord"
            >
              <Icon icon="ic:baseline-discord" class="w-6 h-6" />
            </a>
          </div>
        </div>

        <!-- Link Columns -->
        <div
          class="flex-1 grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-x-6 gap-y-10 lg:gap-x-8"
        >
          <!-- Column 1: Categories -->
          <div>
            <h3
              class="text-xs font-semibold text-gray-900 uppercase tracking-widest mb-4"
            >
              Categories
            </h3>
            <ul class="space-y-3">
              <li v-for="link in footerLinks.categories" :key="link.label">
                <a
                  :href="link.href"
                  class="text-sm text-gray-500 hover:text-gray-900 transition-colors"
                >
                  {{ link.label }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Column 2: Customer Service -->
          <div>
            <h3
              class="text-xs font-semibold text-gray-900 uppercase tracking-widest mb-4"
            >
              Customer Service
            </h3>
            <ul class="space-y-3">
              <li v-for="link in footerLinks.customerService" :key="link.label">
                <a
                  :href="link.href"
                  class="text-sm text-gray-500 hover:text-gray-900 transition-colors"
                >
                  {{ link.label }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Column 3: Resources -->
          <div>
            <h3
              class="text-xs font-semibold text-gray-900 uppercase tracking-widest mb-4"
            >
              Resources
            </h3>
            <ul class="space-y-3">
              <li v-for="link in footerLinks.resources" :key="link.label">
                <a
                  :href="link.href"
                  class="text-sm text-gray-500 hover:text-gray-900 transition-colors"
                >
                  {{ link.label }}
                </a>
              </li>
            </ul>
          </div>

          <!-- Column 4: Company -->
          <div>
            <h3
              class="text-xs font-semibold text-gray-900 uppercase tracking-widest mb-4"
            >
              Company
            </h3>
            <ul class="space-y-3">
              <li v-for="link in footerLinks.company" :key="link.label">
                <a
                  :href="link.href"
                  class="text-sm text-gray-500 hover:text-gray-900 transition-colors"
                >
                  {{ link.label }}
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- Giant Brand Text -->
    <div
      class="overflow-hidden select-none -pb-4 sm:-pb-6 lg:-pb-8"
      aria-hidden="true"
    >
      <p
        class="text-gray-900 text-center font-black leading-none text-8xl sm:text-9xl leading-none tracking-tighter whitespace-nowrap"
      >
        Store
      </p>
    </div>
  </footer>
</template>


<script setup lang="ts">
import { Icon } from "@iconify/vue";
import { ref } from "vue";

const newsletterEmail = ref("");

const footerLinks = {
  categories: [
    { label: "Electronics", href: "/category/electronics" },
    { label: "Fashion & Apparel", href: "/category/fashion" },
    { label: "Home & Garden", href: "/category/home-garden" },
    { label: "Sports & Outdoors", href: "/category/sports" },
    { label: "Books & Media", href: "/category/books" },
    { label: "Beauty & Personal Care", href: "/category/beauty" },
  ],
  customerService: [
    { label: "Help Center", href: "/help" },
    { label: "Track Order", href: "/track-order" },
    { label: "Returns & Exchanges", href: "/returns" },
    { label: "Shipping Info", href: "/shipping" },
    { label: "Contact Us", href: "/contact" },
    { label: "Size Guide", href: "/size-guide" },
    { label: "Gift Cards", href: "/gift-cards" },
  ],
  resources: [
    { label: "Blog", href: "/blog" },
    { label: "Buying Guide", href: "/guides" },
    { label: "Community", href: "/community" },
    { label: "Flash Deals", href: "/deals" },
    { label: "New Arrivals", href: "/new-arrivals" },
    { label: "Best Sellers", href: "/best-sellers" },
    { label: "Wishlist", href: "/wishlist" },
    { label: "Compare Products", href: "/compare" },
  ],
  company: [
    { label: "About Us", href: "/about" },
    { label: "Careers", href: "/careers" },
    { label: "Press", href: "/press" },
    { label: "Investors", href: "/investors" },
    { label: "Partnerships", href: "/partnerships" },
    { label: "Sustainability", href: "/sustainability" },
    { label: "Affiliates", href: "/affiliates" },
    { label: "See All", href: "/about" },
  ],
};

function subscribeNewsletter() {
  if (!newsletterEmail.value) return;
  console.log("Newsletter subscription:", newsletterEmail.value);
  newsletterEmail.value = "";
}
</script>
