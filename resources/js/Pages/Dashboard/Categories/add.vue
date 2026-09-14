<template>
  <!-- Layout -->
  <DashboardLayout
    class="min-h-screen bg-[#f8fafc] text-gray-900 flex flex-col font-sans"
  >
    <!-- Content wrapper -->
    <div class="flex flex-1 relative">
      <!-- Main -->
      <main class="flex-1 w-full min-w-0 p-4 md:p-6 lg:p-8 flex flex-col gap-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
          <Link
            href="/dashboard/categories"
            class="hover:text-gray-900 transition-colors"
          >
            Categories
          </Link>
          <Icon icon="lucide:chevron-right" class="w-3.5 h-3.5 text-gray-400" />
          <p class="text-gray-700 font-medium">Create</p>
        </nav>

        <!-- Header -->
        <div class="flex flex-col gap-1">
          <h1
            class="text-2xl font-bold tracking-tight text-gray-950 md:text-3xl"
          >
            Create Category
          </h1>
        </div>

        <!-- Form -->
        <form @submit.prevent="submit">
          <div
            class="bg-white rounded-md border border-gray-200 shadow-xs p-4 md:p-6 lg:p-8 flex flex-col gap-6"
          >
            <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6">
              <!-- Name -->
              <div class="flex flex-col gap-1.5">
                <label for="name" class="text-sm font-medium text-gray-800">
                  Name
                </label>
                <div class="relative">
                  <input
                    name="name"
                    v-model="form.name"
                    type="text"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all"
                    :class="{ 'border-red-500': form.errors.name }"
                  />
                </div>
                <p class="mt-1 text-xs text-red-500" v-if="form.errors.name">
                  {{ form.errors.name }}
                </p>
              </div>

              <!-- Slug -->
              <div class="flex flex-col gap-1.5">
                <label for="slug" class="text-sm font-medium text-gray-800">
                  Slug
                </label>
                <div class="relative">
                  <input
                    name="slug"
                    v-model="form.slug"
                    type="text"
                    required
                    class="w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-900 transition-all"
                    :class="{ 'border-red-500': form.errors.slug }"
                  />
                </div>
                <p class="mt-1 text-xs text-red-500" v-if="form.errors.slug">
                  {{ form.errors.slug }}
                </p>
              </div>

              <!-- Phone -->
              <div class="flex flex-col gap-1.5 md:col-span-2">
                <label
                  for="description"
                  class="text-sm font-medium text-gray-800"
                >
                  Description
                </label>
                <div class="relative">
                  <textarea
                    name="description"
                    v-model="form.description"
                    type="text"
                    class="resize-none w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-gray-900 transition-all min-h-36"
                    :class="{ 'border-red-500': form.errors.description }"
                  />
                </div>
                <p
                  class="mt-1 text-xs text-red-500"
                  v-if="form.errors.description"
                >
                  {{ form.errors.description }}
                </p>
              </div>
            </div>
          </div>

          <!-- Actions -->
          <div class="flex flex-col gap-3 mt-4 md:flex-row md:justify-end md:items-center">
            <!-- Create -->
            <Button
              type="submit"
              variant="second"
              size="md"
              :loading="form.processing"
              class="w-full md:w-auto"
            >
              Create
            </Button>

            <!-- Create & create another -->
            <Button
              type="submit"
              name="create_another"
              value="1"
              variant="third"
              size="md"
              :disabled="form.processing"
              class="w-full md:w-auto"
            >
              Create & create another
            </Button>

            <!-- Cancel -->
            <Button
              href="/dashboard/categories"
              variant="third"
              size="md"
              class="w-full md:w-auto"
            >
              Cancel
            </Button>
          </div>
        </form>
      </main>
    </div>
  </DashboardLayout>
</template>

<script setup lang="ts">
import { ref } from "vue";
import { Link, useForm, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import DashboardLayout from "../../Layouts/Dashboard/dashboard.vue";
import Button from "../../Components/button.vue";
import Swal from "sweetalert2";

const form = useForm({
  name: null,
  slug: null,
  description: null,
});

function submit() {
  form.post("/dashboard/categories/add");
}
</script>
