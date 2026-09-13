<template>
  <!-- Layout -->
  <DashboardLayout class="min-h-screen bg-[#f8fafc] text-gray-900 flex flex-col font-sans">

    <!-- Content wrapper -->
    <div class="flex flex-1 relative">
      <!-- Main -->
      <main class="flex-1 w-full min-w-0 p-4 md:p-6 lg:p-8 flex flex-col gap-6">
        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-xs md:text-sm text-gray-500">
          <a href="#" class="hover:text-gray-900 transition-colors">Orders</a>
          <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
          </svg>
          <span class="text-gray-700 font-medium">List</span>
        </nav>

        <!-- Header -->
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
          <h1 class="text-2xl md:text-3xl font-bold text-gray-950 tracking-tight">
            Orders
          </h1>
          <button
            type="button"
            class="w-full md:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow-xs transition-colors cursor-pointer"
          >
            <span>New order</span>
          </button>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 gap-4 md:grid-cols-3 md:gap-5 lg:gap-6">
          <!-- Card Orders -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between overflow-hidden relative">
            <div>
              <p class="text-sm font-medium text-gray-500">Orders</p>
              <h2 class="text-2xl md:text-3xl font-bold text-gray-950 tracking-tight mt-2">
                {{ formatNumber(stats.orders) }}
              </h2>
            </div>
            <div class="mt-4 -mb-1 w-full overflow-hidden">
              <svg class="w-full h-8 text-gray-300 stroke-gray-400" viewBox="0 0 300 40" fill="none" preserveAspectRatio="none">
                <path d="M0 35 C60 35, 90 22, 140 25 C190 28, 230 38, 300 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke" />
              </svg>
            </div>
          </div>

          <!-- Card Open orders -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between overflow-hidden relative">
            <div>
              <p class="text-sm font-medium text-gray-500">Open orders</p>
              <h2 class="text-2xl md:text-3xl font-bold text-gray-950 tracking-tight mt-2">
                {{ formatNumber(stats.openOrders) }}
              </h2>
            </div>
            <div class="mt-4 -mb-1 w-full overflow-hidden">
              <svg class="w-full h-8 text-gray-300 stroke-gray-400" viewBox="0 0 300 40" fill="none" preserveAspectRatio="none">
                <path d="M0 35 C50 35, 100 25, 150 28 C200 31, 240 37, 300 26" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke" />
              </svg>
            </div>
          </div>

          <!-- Card Average order value -->
          <div class="bg-white rounded-xl border border-gray-200 p-5 shadow-xs flex flex-col justify-between overflow-hidden relative">
            <div>
              <p class="text-sm font-medium text-gray-500">Average order value</p>
              <h2 class="text-2xl md:text-3xl font-bold text-gray-950 tracking-tight mt-2">
                ${{ formatCurrency(stats.averageOrderValue) }}
              </h2>
            </div>
            <div class="mt-4 -mb-1 w-full overflow-hidden">
              <svg class="w-full h-8 text-gray-300 stroke-gray-400" viewBox="0 0 300 40" fill="none" preserveAspectRatio="none">
                <path d="M0 34 C60 34, 110 20, 160 26 C210 32, 250 38, 300 25" stroke="currentColor" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke" />
              </svg>
            </div>
          </div>
        </div>

        <!-- Tabs -->
        <div class="flex items-center justify-start md:justify-center overflow-x-auto">
          <div class="bg-white border border-gray-200 rounded-xl p-1 shadow-xs flex items-center gap-1 overflow-x-auto max-w-full">
            <button
              v-for="tab in statusTabs"
              :key="tab.key"
              type="button"
              class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs md:text-sm font-medium transition-all whitespace-nowrap cursor-pointer"
              :class="
                activeTab === tab.key
                  ? 'bg-gray-100 text-gray-900 font-semibold shadow-xs'
                  : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
              "
              @click="setTab(tab.key)"
            >
              <span>{{ tab.label }}</span>
              <span
                class="text-xs font-semibold px-1.5 py-0.5 rounded-full"
                :class="tab.badgeClass"
              >
                {{ tab.count }}
              </span>
            </button>
          </div>
        </div>

        <!-- Table -->
        <Datatables
          :columns="tableColumns"
          :data="displayedOrders"
          row-key="id"
          :search-fields="['number', 'customer', 'status']"
          :group-by-options="groupByOptions"
          default-sort-field="orderDate"
          default-sort-direction="desc"
          empty-text="No orders found"
        >
          <!-- Status -->
          <template #cell-status="{ value }">
            <Badge :label="value" :variant="statusVariant[value] || 'default'" />
          </template>

          <!-- Total price -->
          <template #cell-totalPrice="{ value }">
            ${{ formatCurrency(value) }}
          </template>

          <!-- Shipping cost -->
          <template #cell-shippingCost="{ value }">
            ${{ formatCurrency(value) }}
          </template>
        </Datatables>
      </main>
    </div>
  </DashboardLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import DashboardLayout from "../Layouts/Dashboard/dashboard.vue";
import Datatables from "../Components/datatables.vue";
import Badge from "../Components/badge.vue";

// Props
const props = defineProps({
  stats: {
    type: Object,
    default: () => ({
      orders: 1019,
      openOrders: 317,
      averageOrderValue: 1003.17
    })
  },
  initialOrders: {
    type: Array,
    default: () => [
      {
        id: 1,
        number: 'OR896954',
        customer: 'Hallie Kiehn',
        status: 'New',
        totalPrice: 472.49,
        shippingCost: 359.27,
        orderDate: 'Sep 6, 2026'
      },
      {
        id: 2,
        number: 'OR898937',
        customer: 'Lilyan Jast',
        status: 'Shipped',
        totalPrice: 772.44,
        shippingCost: 313.47,
        orderDate: 'Sep 6, 2026'
      },
      {
        id: 3,
        number: 'OR726669',
        customer: 'Chauncey Wisozk I',
        status: 'Delivered',
        totalPrice: 324.34,
        shippingCost: 132.25,
        orderDate: 'Sep 5, 2026'
      },
      {
        id: 4,
        number: 'OR307943',
        customer: 'Theodore Streich',
        status: 'Delivered',
        totalPrice: 1145.99,
        shippingCost: 478.01,
        orderDate: 'Sep 5, 2026'
      },
      {
        id: 5,
        number: 'OR986322',
        customer: 'Ms. Samantha Rosenbaum III',
        status: 'Canceled',
        totalPrice: 710.62,
        shippingCost: 184.33,
        orderDate: 'Sep 5, 2026'
      },
      {
        id: 6,
        number: 'OR24971',
        customer: 'Emely Kutch',
        status: 'Processing',
        totalPrice: 1110.19,
        shippingCost: 183.25,
        orderDate: 'Sep 5, 2026'
      },
      {
        id: 7,
        number: 'OR25147',
        customer: 'Kay Brown',
        status: 'Canceled',
        totalPrice: 488.47,
        shippingCost: 339.11,
        orderDate: 'Sep 4, 2026'
      },
      {
        id: 8,
        number: 'OR916317',
        customer: 'Dr. Derrick Nikolaus I',
        status: 'Shipped',
        totalPrice: 267.01,
        shippingCost: 91.47,
        orderDate: 'Sep 4, 2026'
      }
    ]
  }
})

// State
const activeTab = ref('all')

// Table config
const tableColumns = [
  { key: 'number', label: 'Number', cellClass: 'font-medium text-gray-900' },
  { key: 'customer', label: 'Customer', cellClass: 'text-gray-700' },
  { key: 'status', label: 'Status', sortable: false, cellClass: 'whitespace-nowrap' },
  { key: 'totalPrice', label: 'Total price', cellClass: 'font-medium text-gray-900' },
  { key: 'shippingCost', label: 'Shipping cost', cellClass: 'text-gray-600' },
  { key: 'orderDate', label: 'Order date', cellClass: 'text-gray-600 whitespace-nowrap' },
]

const groupByOptions = [
  { value: 'status', label: 'Status' },
  { value: 'customer', label: 'Customer' },
  { value: 'orderDate', label: 'Order date' },
]

// Status tabs
const statusTabs = ref([
  { key: 'all', label: 'All', count: 1019, badgeClass: 'bg-gray-200 text-gray-700' },
  { key: 'New', label: 'New', count: 155, badgeClass: 'bg-blue-100 text-blue-600' },
  { key: 'Processing', label: 'Processing', count: 162, badgeClass: 'bg-amber-100 text-amber-700' },
  { key: 'Shipped', label: 'Shipped', count: 205, badgeClass: 'bg-emerald-100 text-emerald-700' },
  { key: 'Delivered', label: 'Delivered', count: 409, badgeClass: 'bg-emerald-100 text-emerald-700' },
  { key: 'Canceled', label: 'Cancelled', count: 88, badgeClass: 'bg-rose-100 text-rose-700' }
])

// Methods
const setTab = (tabKey) => {
  activeTab.value = tabKey
}

const formatNumber = (num) => {
  return Number(num || 0).toLocaleString()
}

const formatCurrency = (amount) => {
  return Number(amount || 0).toLocaleString('en-US', {
    minimumFractionDigits: 2,
    maximumFractionDigits: 2
  })
}

// Status variant map
const statusVariant = {
  New: 'blue',
  Shipped: 'emerald',
  Delivered: 'emerald',
  Canceled: 'rose',
  Processing: 'amber',
}

// Computed
const displayedOrders = computed(() => {
  let list = [...props.initialOrders]

  // Tab filter
  if (activeTab.value !== 'all') {
    list = list.filter((order) => order.status === activeTab.value)
  }

  return list
})
</script>

