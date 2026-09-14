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
          edit-route="/dashboard/categories/edit/:id"
          delete-route="/dashboard/categories/delete"
          date-filter-label="Created at"
        >
        </DataTable>
      </main>
    </div>
  </DashboardLayout>
</template>

<script setup>
import DashboardLayout from "../../Layouts/Dashboard/dashboard.vue";
import DataTable from "../../Components/datatables.vue";
import Button from "../../Components/button.vue";

// Props
const props = defineProps({
  categories: {
    type: Object,
  },
  filters: {
    type: Object,
  },
});

const columns = [
  { key: "name", label: "Nama", data: "name" },
  { key: "slug", label: "Slug", data: "slug" },
  { key: "description", label: "Deskripsi", data: "description" },
];
</script>
