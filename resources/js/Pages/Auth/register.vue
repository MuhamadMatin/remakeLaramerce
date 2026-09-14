<template>
  <div
    class="min-h-screen bg-gray-50 flex flex-col justify-center items-center py-10 sm:py-16 px-4 sm:px-6 lg:px-8 font-sans"
  >
    <!-- Header Section -->
    <div class="text-center mb-6 sm:mb-8 w-full max-w-md">
      <!-- Logo / Brand -->
      <a
        href="/"
        class="inline-flex items-center justify-center gap-2 mb-4 group"
      >
        <Icon
          icon="lucide:store"
          class="w-8 h-8 text-blue-600 transition-transform"
        />
        <p class="text-blue-600 font-bold text-2xl tracking-tight">Store</p>
      </a>

      <!-- Title & Subtitle -->
      <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">
        Create an account
      </h1>
      <p class="text-sm text-gray-500 mt-2">
        Already have an account?
        <Link
          href="/login"
          id="link-login"
          class="font-medium text-blue-600 hover:text-blue-700 hover:underline transition-colors ml-0.5"
        >
          Log in
        </Link>
      </p>
    </div>

    <!-- Register Card -->
    <div
      class="w-full max-w-md bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8"
    >
      <!-- Google -->
      <a
        href="oauth/google"
        class="flex items-center justify-center gap-2 py-2.5 px-4 bg-white hover:bg-gray-50 active:bg-gray-100 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 transition-colors shadow-2xs cursor-pointer"
      >
        <Icon icon="logos:google-icon" class="w-4 h-4" />
        <span>Google</span>
      </a>

      <!-- Divider -->
      <div class="relative my-6 text-center">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
          <div class="w-full border-t border-gray-200"></div>
        </div>
        <span
          class="relative bg-white px-3 text-xs text-gray-400 font-medium tracking-wide"
        >
          Or continue with
        </span>
      </div>

      <form @submit.prevent="submit" class="space-y-4 sm:space-y-5">
        <!-- Name Field -->
        <div>
          <label
            for="name"
            class="block text-sm font-semibold text-gray-700 mb-1.5"
          >
            Full Name
          </label>
          <div class="relative">
            <input
              id="name"
              v-model="form.name"
              type="text"
              name="name"
              required
              autocomplete="name"
              placeholder="John Doe"
              class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              :class="{ 'border-red-500': form.errors.name }"
            />
          </div>
          <p class="mt-1 text-xs text-red-500" v-if="form.errors.name">
            {{ form.errors.name }}
          </p>
        </div>

        <!-- Username Field -->
        <div>
          <label
            for="username"
            class="block text-sm font-semibold text-gray-700 mb-1.5"
          >
            Username
          </label>
          <div class="relative">
            <input
              id="username"
              v-model="form.username"
              type="text"
              name="username"
              required
              autocomplete="username"
              placeholder="John Doe"
              class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              :class="{ 'border-red-500': form.errors.username }"
            />
          </div>
          <p class="mt-1 text-xs text-red-500" v-if="form.errors.username">
            {{ form.errors.username }}
          </p>
        </div>

        <!-- Email Field -->
        <div>
          <label
            for="email"
            class="block text-sm font-semibold text-gray-700 mb-1.5"
          >
            Email Address
          </label>
          <div class="relative">
            <input
              id="email"
              v-model="form.email"
              type="email"
              name="email"
              required
              autocomplete="email"
              placeholder="name@example.com"
              class="w-full px-3.5 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              :class="{ 'border-red-500': form.errors.email }"
            />
          </div>
          <p class="mt-1 text-xs text-red-500" v-if="form.errors.email">
            {{ form.errors.email }}
          </p>
        </div>

        <!-- Password Field -->
        <div>
          <label
            for="password"
            class="block text-sm font-semibold text-gray-700 mb-1.5"
          >
            Password
          </label>
          <div class="relative">
            <input
              id="password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              name="password"
              required
              autocomplete="new-password"
              placeholder="••••••••"
              class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              :class="{ 'border-red-500': form.errors.password }"
            />
            <button
              type="button"
              id="btn-toggle-password"
              @click="showPassword = !showPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"
              tabindex="-1"
              aria-label="Toggle password visibility"
            >
              <Icon
                :icon="showPassword ? 'lucide:eye-off' : 'lucide:eye'"
                class="w-4 h-4"
              />
            </button>
          </div>
          <p class="mt-1 text-xs text-red-500" v-if="form.errors.password">
            {{ form.errors.password }}
          </p>
        </div>

        <!-- Confirm Password Field -->
        <div>
          <label
            for="password_confirmation"
            class="block text-sm font-semibold text-gray-700 mb-1.5"
          >
            Confirm Password
          </label>
          <div class="relative">
            <input
              id="password_confirmation"
              v-model="form.password_confirmation"
              :type="showConfirmPassword ? 'text' : 'password'"
              name="password_confirmation"
              required
              autocomplete="new-password"
              placeholder="••••••••"
              class="w-full pl-3.5 pr-10 py-2.5 bg-white border border-gray-300 rounded-lg text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
              :class="{ 'border-red-500': form.errors.password_confirmation }"
            />
            <button
              type="button"
              id="btn-toggle-confirm-password"
              @click="showConfirmPassword = !showConfirmPassword"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors cursor-pointer"
              tabindex="-1"
              aria-label="Toggle confirm password visibility"
            >
              <Icon
                :icon="showConfirmPassword ? 'lucide:eye-off' : 'lucide:eye'"
                class="w-4 h-4"
              />
            </button>
          </div>
          <p
            class="mt-1 text-xs text-red-500"
            v-if="form.errors.password_confirmation"
          >
            {{ form.errors.password_confirmation }}
          </p>
        </div>

        <!-- Terms and Privacy Agreement -->
        <div class="flex items-start gap-2.5 pt-1">
          <input
            id="terms"
            v-model="form.terms"
            type="checkbox"
            required
            class="w-4 h-4 mt-0.5 rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer flex-shrink-0"
          />
          <label
            for="terms"
            class="text-xs sm:text-sm text-gray-600 leading-relaxed cursor-pointer select-none"
          >
            I agree to the
            <Link
              href="/terms"
              class="text-blue-600 hover:text-blue-700 hover:underline"
              >Terms of Service</Link
            >
            and
            <Link
              href="/privacy"
              class="text-blue-600 hover:text-blue-700 hover:underline"
              >Privacy Policy</Link
            >.
          </label>
        </div>

        <!-- Sign Up Submit Button -->
        <div class="pt-2">
          <button
            type="submit"
            id="btn-submit-register"
            :disabled="form.processing"
            class="w-full bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold py-2.5 sm:py-3 px-4 rounded-lg text-sm sm:text-base transition-colors duration-150 shadow-sm cursor-pointer disabled:opacity-60 disabled:cursor-not-allowed flex items-center justify-center gap-2"
          >
            <Icon
              v-if="form.processing"
              icon="eos-icons:loading"
              class="w-4 h-4"
            />
            <p>
              {{ form.processing ? "Creating account..." : "Create Account" }}
            </p>
          </button>
        </div>
      </form>
    </div>

    <!-- Back to Home -->
    <div class="mt-6 text-center">
      <Link
        href="/"
        id="link-back-home"
        class="inline-flex items-center gap-1.5 text-sm font-medium text-blue-600 hover:text-blue-700 hover:underline transition-colors"
      >
        <p>&larr;</p>
        <p>Back to Home</p>
      </Link>
    </div>
  </div>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Icon } from "@iconify/vue";
import { Link, useForm } from "@inertiajs/vue3";

const form = useForm({
  name: "",
  username: "",
  email: "",
  password: "",
  password_confirmation: "",
  terms: false,
});

const showPassword = ref(false);
const showConfirmPassword = ref(false);

// Submit
function submit() {
  form.post("/register/store");
}
</script>
