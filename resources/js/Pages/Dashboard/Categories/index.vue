<template>
  <!-- Layout -->
  <DashboardLayout
    class="min-h-screen bg-[#f8fafc] text-gray-900 flex flex-col font-sans"
  >
    <!-- Content wrapper -->
    <div class="flex flex-1 relative">
      <!-- Main -->
      <main class="flex-1 w-full min-w-0 p-4 md:p-6 lg:p-8 flex flex-col gap-6">
        <!-- Header -->
        <div
          class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
        >
          <h1
            class="text-2xl md:text-3xl font-bold text-gray-950 tracking-tight"
          >
            Category
          </h1>
          <Button
            href="/dashboard/categories/add"
            variant="second"
            size="md"
            icon="lucide:plus"
            class="w-full md:w-auto"
          >
            New Category
          </Button>
        </div>

        <!-- Table -->
        <DataTable
          :columns="columns"
          :rows="categories.data"
          :meta="categories"
          :filters="filters"
          row-key="id_category"
          route-name="/dashboard/categories"
          bulk-delete-route="/dashboard/categories/bulk-destroy"
          date-filter-label="Created at"
        >
          <!-- Custom cell -->
          <template #cell-name="{ row }">
            <span class="font-medium text-gray-900">{{ row.name }}</span>
          </template>

          <template #cell-description="{ value }">
            <span class="text-gray-600">{{ value ?? "—" }}</span>
          </template>

          <!-- Desktop actions -->
          <template #row-actions="{ row }">
            <Link
              :href="`/dashboard/categories/edit/${row.id_category}`"
              class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
              title="Edit"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
              </svg>
            </Link>
            <button
              type="button"
              class="rounded-lg p-2 text-gray-500 transition hover:bg-red-50 hover:text-red-600"
              title="Delete"
              @click="destroy(row.id_category)"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
            </button>
          </template>

          <!-- Mobile dropdown actions -->
          <template #row-actions-mobile="{ row }">
            <Link
              :href="`/dashboard/categories/edit/${row.id_category}`"
              class="text-gray-700"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Z" />
              </svg>
              Edit
            </Link>
            <button
              type="button"
              class="text-red-600"
              @click="destroy(row.id_category)"
            >
              <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
              </svg>
              Delete
            </button>
          </template>
        </DataTable>
      </main>
    </div>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../Layouts/Dashboard/dashboard.vue";
import DataTable from "../../Components/datatables.vue";
import Button from "../../Components/button.vue";
import { Link, router } from "@inertiajs/vue3";

// Props
const props = defineProps({
  categories: {
    type: Object,
  },
  filters: {
    type: Object,
  },
});

// Table config
const columns = [
  { key: "name", label: "Name" },
  { key: "slug", label: "Slug", cellClass: "text-gray-700" },
  { key: "description", label: "Description", cellClass: "text-gray-600" },
];

// Delete single category
function destroy(id) {
  if (!window.confirm("Hapus kategori ini? Aksi ini tidak bisa dibatalkan.")) return;
  router.delete("/dashboard/categories/delete", {
    data: { id },
    preserveScroll: true,
  });
}
</script>
