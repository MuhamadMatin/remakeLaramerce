<template>
  <div class="w-full min-w-0 max-w-full rounded-xl border border-gray-200 bg-white shadow-xs overflow-hidden">
    <!-- Toolbar -->
    <div
      class="flex flex-col gap-3 p-3.5 md:flex-row md:items-center md:justify-between md:p-4 lg:p-5"
    >
      <!-- Left controls -->
      <div class="flex flex-wrap items-center gap-2">
        <!-- Bulk actions dropdown -->
        <div
          v-if="selectedRowKeys.length > 0"
          ref="bulkActionsWrapperRef"
          class="relative"
        >
          <button
            type="button"
            class="inline-flex items-center gap-1.5 rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs font-medium text-gray-700 shadow-xs transition hover:bg-gray-50 cursor-pointer md:px-3 md:text-sm"
            @click="activePanel = activePanel === 'bulkActions' ? null : 'bulkActions'"
          >
            <Icon icon="lucide:ellipsis-vertical" class="h-3.5 w-3.5 text-gray-400" />
            <p>Bulk actions</p>
          </button>

          <!-- Bulk actions popup -->
          <div
            v-show="activePanel === 'bulkActions'"
            class="absolute left-0 z-30 mt-2 w-48 origin-top-left rounded-xl border border-gray-200 bg-white p-1.5 shadow-xl"
          >
            <button
              v-if="deletable"
              type="button"
              class="flex w-full items-center gap-2.5 rounded-lg px-2.5 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50 cursor-pointer md:text-sm"
              @click="handleBulkDeleteAndClose"
            >
              <Icon icon="lucide:trash-2" class="h-4 w-4" />
              <p>Delete selected</p>
            </button>
            <slot name="bulk-actions" :selected="selectedRowKeys" />
          </div>
        </div>

        <!-- Group by -->
        <div
          v-if="showGroupBy"
          class="flex items-center rounded-lg border border-gray-200 bg-white px-2.5 py-1.5 text-xs text-gray-600 shadow-xs md:px-3 md:text-sm"
        >
          <span class="font-medium text-gray-500">Group by</span>
          <div class="relative flex items-center">
            <select
              :value="selectedGroupBy"
              @change="onGroupByChange"
              class="cursor-pointer appearance-none border-0 bg-transparent py-0 pl-1.5 pr-5 text-xs font-medium text-gray-700 focus:outline-none focus:ring-0 md:text-sm"
            >
              <option value="">-</option>
              <option
                v-for="columnItem in groupableColumns"
                :key="columnItem.key"
                :value="columnItem.key"
              >
                {{ columnItem.label }}
              </option>
            </select>
            <Icon
              icon="lucide:chevron-down"
              class="pointer-events-none absolute right-0 h-3.5 w-3.5 text-gray-400"
            />
          </div>
        </div>

        <slot name="toolbar-left" />
      </div>

      <!-- Right controls -->
      <div class="flex items-center gap-2 w-full md:w-auto">
        <!-- Search -->
        <div class="relative flex-1 min-w-0 md:w-56 md:flex-initial lg:w-64">
          <Icon
            icon="lucide:search"
            class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-400"
          />
          <input
            :value="form.search"
            type="text"
            placeholder="Search"
            class="w-full rounded-lg border border-gray-200 bg-white py-1.5 pl-9 pr-3 text-xs text-gray-800 placeholder-gray-400 shadow-xs transition focus:border-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-700 md:text-sm"
            @input="onSearch($event.target.value)"
          />
        </div>

        <!-- Filter dropdown -->
        <div ref="filtersWrapperRef" class="relative shrink-0">
          <button
            type="button"
            class="relative inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 cursor-pointer"
            :class="activeFilterCount > 0 ? 'text-gray-900' : ''"
            @click="activePanel = activePanel === 'filters' ? null : 'filters'"
            title="Filter"
          >
            <Icon icon="lucide:filter" class="h-4 w-4" />
            <span
              v-if="activeFilterCount > 0"
              class="absolute -top-1 -right-1 flex h-4 min-w-4 items-center justify-center rounded-full bg-gray-900 px-1 text-[10px] font-bold leading-none text-white"
            >
              {{ activeFilterCount }}
            </span>
          </button>

          <!-- Filter popup -->
          <div
            v-show="activePanel === 'filters'"
            class="absolute right-0 z-30 mt-2 w-72 origin-top-right rounded-xl border border-gray-200 bg-white p-3 shadow-xl md:w-80"
          >
            <p
              class="px-1 pb-2 pt-0.5 text-[11px] font-semibold uppercase tracking-wider text-gray-400"
            >
              Filters
            </p>

            <div class="space-y-3">
              <!-- Custom filters slot -->
              <slot name="filters" :form="form" />

              <!-- Date range filter -->
              <div v-if="showDateFilter" class="space-y-1.5">
                <label
                  class="block text-xs font-semibold uppercase tracking-wide text-gray-500"
                >
                  {{ dateFilterLabel }}
                </label>
                <div class="grid grid-cols-2 gap-2">
                  <div>
                    <label
                      class="mb-1 block text-[10px] font-medium text-gray-400"
                      >From</label
                    >
                    <input
                      v-model="form.date_from"
                      type="date"
                      class="block w-full rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-xs text-gray-700 shadow-xs focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900 md:text-sm"
                    />
                  </div>
                  <div>
                    <label
                      class="mb-1 block text-[10px] font-medium text-gray-400"
                      >To</label
                    >
                    <input
                      v-model="form.date_to"
                      type="date"
                      class="block w-full rounded-lg border border-gray-300 bg-white px-2.5 py-1.5 text-xs text-gray-700 shadow-xs focus:border-gray-900 focus:outline-none focus:ring-1 focus:ring-gray-900 md:text-sm"
                    />
                  </div>
                </div>
              </div>
            </div>

            <div
              class="mt-3 flex items-center justify-between border-t border-gray-100 pt-2.5"
            >
              <button
                type="button"
                class="text-xs font-medium text-red-400 hover:text-red-600 cursor-pointer"
                @click="resetFilters"
              >
                Reset
              </button>
              <button
                type="button"
                class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white shadow-xs transition hover:bg-gray-700 cursor-pointer"
                @click="applyFilters"
              >
                Apply
              </button>
            </div>
          </div>
        </div>

        <!-- Columns toggle button -->
        <div ref="columnsWrapperRef" class="relative shrink-0">
          <button
            type="button"
            class="inline-flex items-center justify-center rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-800 cursor-pointer"
            @click="activePanel = activePanel === 'columns' ? null : 'columns'"
            title="Columns"
          >
            <Icon icon="lucide:columns-3" class="h-4 w-4" />
          </button>

          <!-- Columns dropdown -->
          <div
            v-show="activePanel === 'columns'"
            class="absolute right-0 z-30 mt-2 w-56 origin-top-right rounded-xl border border-gray-200 bg-white p-2 shadow-xl"
          >
            <p
              class="px-2 pb-1.5 pt-1 text-[11px] font-semibold uppercase tracking-wider text-gray-400"
            >
              Tampilkan Kolom
            </p>
            <label
              v-for="columnItem in toggleableColumns"
              :key="columnItem.key"
              class="flex cursor-pointer items-center gap-2.5 rounded-lg px-2 py-1.5 text-xs text-gray-700 transition hover:bg-gray-50 md:text-sm"
            >
              <input
                v-model="visibleKeys"
                type="checkbox"
                :value="columnItem.key"
                class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-gray-900"
              />
              {{ columnItem.label }}
            </label>
            <div
              class="mt-2 flex items-center justify-between border-t border-gray-100 pt-2"
            >
              <button
                type="button"
                class="text-xs font-medium text-red-400 hover:text-red-600 cursor-pointer"
                @click="resetColumns"
              >
                Reset
              </button>
              <button
                type="button"
                :disabled="visibleKeys.length === 0"
                class="rounded-lg bg-gray-900 px-3 py-1.5 text-xs font-semibold text-white transition enabled:hover:bg-gray-700 disabled:opacity-40"
                @click="applyColumns"
              >
                Apply
              </button>
            </div>
          </div>
        </div>

        <slot name="toolbar" />
      </div>
    </div>

    <!-- Selection info bar -->
    <div
      v-if="selectedRowKeys.length > 0"
      class="flex flex-col gap-2 border-t border-gray-200/80 px-3.5 py-2.5 text-xs md:flex-row md:items-center md:justify-between md:px-4 md:py-3 lg:px-6"
    >
      <p class="font-medium text-gray-600 md:text-sm">
        {{ selectedRowKeys.length }} records selected
      </p>

      <div class="flex items-center gap-4">
        <button
          type="button"
          class="font-medium text-gray-900 transition hover:text-gray-700 cursor-pointer md:text-sm"
          @click="selectAllRows"
        >
          Select all {{ totalRows }}
        </button>
        <button
          type="button"
          class="font-medium text-red-600 transition hover:text-red-700 cursor-pointer md:text-sm"
          @click="clearSelection"
        >
          Deselect all
        </button>
      </div>
    </div>

    <!-- Table area -->
    <div class="relative border-t border-gray-200">
      <!-- Loading -->
      <div
        v-if="isLoading"
        class="absolute inset-0 z-20 flex items-center justify-center bg-white/60 backdrop-blur-[1px]"
      >
        <Icon icon="eos-icons:loading" class="h-8 w-8 text-gray-900" />
      </div>

      <div
        class="w-full min-w-0 overflow-x-auto"
        :class="{ 'pointer-events-none opacity-50': isLoading }"
      >
        <table class="min-w-full text-left text-xs md:text-sm">
          <thead class="border-b border-gray-200 bg-white">
            <tr>
              <!-- Checkbox th -->
              <th
                v-if="checkable"
                scope="col"
                class="w-10 px-3 py-3 md:w-12 md:px-4 md:py-3.5 lg:px-6"
              >
                <input
                  type="checkbox"
                  class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-0 focus:outline-none"
                  :checked="allSelected"
                  :indeterminate="someSelected && !allSelected"
                  @change="toggleAll"
                />
              </th>

              <!-- Row number th -->
              <th
                v-if="showRowNumber"
                scope="col"
                class="w-12 px-3 py-3 text-left font-semibold text-gray-800 md:px-4 md:py-3.5 lg:px-6"
              >
                No
              </th>

              <!-- Dynamic columns th -->
              <th
                v-for="columnItem in visibleColumns"
                :key="columnItem.key"
                scope="col"
                class="px-3 py-3 font-semibold text-gray-800 whitespace-nowrap md:px-4 md:py-3.5 lg:px-6"
                :class="columnItem.align === 'right' ? 'text-right' : 'text-left'"
              >
                <button
                  v-if="columnItem.sortable !== false"
                  type="button"
                  class="group inline-flex items-center gap-1 font-semibold text-gray-800 transition hover:text-gray-950 cursor-pointer"
                  @click="sortBy(columnItem.key)"
                >
                  <span>{{ columnItem.label }}</span>
                  <Icon
                    v-if="sortKey === columnItem.key && sortDir === 'asc'"
                    icon="lucide:chevron-up"
                    class="h-3.5 w-3.5 text-gray-900"
                  />
                  <Icon
                    v-else-if="sortKey === columnItem.key"
                    icon="lucide:chevron-down"
                    class="h-3.5 w-3.5 text-gray-900"
                  />
                  <Icon
                    v-else
                    icon="lucide:chevron-down"
                    class="h-3.5 w-3.5 text-gray-400 group-hover:text-gray-600"
                  />
                </button>
                <span v-else>{{ columnItem.label }}</span>
              </th>

              <!-- Actions th -->
              <th
                v-if="showActions"
                scope="col"
                class="sticky right-0 z-10 w-14 bg-white px-3 py-3 text-right font-semibold text-gray-800 shadow-[-6px_0_10px_-4px_rgba(0,0,0,0.06)] md:w-20 md:px-4 md:py-3.5 lg:px-6"
              >
                <span class="sr-only">Actions</span>
              </th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-100 bg-white">
            <!-- Empty state -->
            <tr v-if="rows.length === 0">
              <td
                :colspan="
                  visibleColumns.length +
                  (checkable ? 1 : 0) +
                  (showRowNumber ? 1 : 0) +
                  (showActions ? 1 : 0)
                "
                class="px-4 py-16 text-center text-xs text-gray-400 md:text-sm lg:px-6"
              >
                Tidak ada data yang cocok dengan filter / pencarian.
              </td>
            </tr>

            <!-- Data rows -->
            <tr
              v-for="(rowItem, rowIndex) in rows"
              :key="rowItem[rowKey]"
              class="group transition-colors hover:bg-gray-50/70"
              :class="isRowSelected(rowItem) ? 'bg-gray-50' : ''"
            >
              <!-- Checkbox td -->
              <td
                v-if="checkable"
                class="px-3 py-3 md:px-4 md:py-3.5 lg:px-6 lg:py-4"
              >
                <input
                  v-model="selectedRowKeys"
                  type="checkbox"
                  :value="rowItem[rowKey]"
                  class="h-4 w-4 rounded border-gray-300 text-gray-900 focus:ring-0 focus:outline-none"
                />
              </td>

              <!-- Row number td -->
              <td
                v-if="showRowNumber"
                class="px-3 py-3 text-gray-500 md:px-4 md:py-3.5 lg:px-6 lg:py-4"
              >
                {{ rowNumber(rowIndex) }}
              </td>

              <!-- Columns td: auto-loop, nilai diambil dari columnItem.data (fallback: columnItem.label) -->
              <td
                v-for="(columnItem, columnIndex) in visibleColumns"
                :key="columnItem.key"
                class="px-3 py-3 md:px-4 md:py-3.5 lg:px-6 lg:py-4"
                :class="[
                  columnItem.align === 'right' ? 'text-right' : 'text-left',
                  columnIndex === 0 ? 'font-medium text-gray-900 whitespace-nowrap' : 'text-gray-600',
                  columnItem.key === 'description' || columnItem.key === 'deskripsi' || columnItem.key === 'desc'
                    ? 'min-w-[160px] max-w-xs md:max-w-md lg:max-w-lg truncate'
                    : 'whitespace-nowrap'
                ]"
                :title="
                  columnItem.key === 'description' || columnItem.key === 'deskripsi' || columnItem.key === 'desc'
                    ? formatCell(getCellValue(rowItem, columnItem))
                    : undefined
                "
              >
                <slot
                  :name="`cell-${columnItem.key}`"
                  :row="rowItem"
                  :value="getCellValue(rowItem, columnItem)"
                  :column="columnItem"
                  :index="rowIndex"
                >
                  {{ formatCell(getCellValue(rowItem, columnItem)) }}
                </slot>
              </td>

              <!-- Actions td -->
              <td
                v-if="showActions"
                class="sticky right-0 z-10 whitespace-nowrap px-3 py-3 text-right transition-colors shadow-[-6px_0_10px_-4px_rgba(0,0,0,0.06)] md:px-4 md:py-3.5 lg:px-6 lg:py-4"
                :class="isRowSelected(rowItem) ? 'bg-gray-50' : 'bg-white group-hover:bg-gray-50/70'"
              >
                <!-- Mobile: Kebab dropdown -->
                <div class="relative inline-block text-left md:hidden">
                  <button
                    type="button"
                    class="rounded-lg p-1.5 text-gray-400 transition hover:bg-gray-100 hover:text-gray-600"
                    @click.stop="toggleActionMenu(rowItem)"
                  >
                    <Icon icon="lucide:ellipsis-vertical" class="h-4 w-4" />
                  </button>

                  <!-- Dark dropdown -->
                  <transition
                    enter-active-class="transition duration-150 ease-out"
                    enter-from-class="scale-95 opacity-0"
                    enter-to-class="scale-100 opacity-100"
                    leave-active-class="transition duration-100 ease-in"
                    leave-from-class="scale-100 opacity-100"
                    leave-to-class="scale-95 opacity-0"
                  >
                    <div
                      v-show="openActionRowId === rowItem[rowKey]"
                      class="absolute right-0 z-30 mt-1 w-44 origin-top-right rounded-xl bg-gray-900 p-1.5 shadow-2xl ring-1 ring-white/10"
                    >
                      <!-- Mobile actions (default: Edit + Delete, overridable) -->
                      <slot name="row-actions-mobile" :row="rowItem">
                        <Link
                          v-if="resolveEditHref(rowItem)"
                          :href="resolveEditHref(rowItem)"
                          class="flex w-full items-center gap-2.5 px-3.5 py-2 text-sm text-green-400 whitespace-nowrap transition-colors hover:bg-green-400/10 cursor-pointer"
                        >
                          <Icon icon="lucide:pencil" class="h-4 w-4" />
                          Edit
                        </Link>
                        <button
                          v-if="resolveDeleteRoute(rowItem)"
                          type="button"
                          class="flex w-full items-center gap-2.5 px-3.5 py-2 text-sm text-red-400 whitespace-nowrap transition-colors hover:bg-red-400/10 cursor-pointer"
                          @click="destroyRow(rowItem)"
                        >
                          <Icon icon="lucide:trash-2" class="h-4 w-4" />
                          Delete
                        </button>
                      </slot>
                    </div>
                  </transition>
                </div>

                <!-- Tablet (md) & Desktop (lg): Inline actions -->
                <div class="hidden items-center justify-end gap-1 md:flex">
                  <!-- Desktop actions (default: Edit + Delete, overridable) -->
                  <slot name="row-actions" :row="rowItem">
                    <Link
                      v-if="resolveEditHref(rowItem)"
                      :href="resolveEditHref(rowItem)"
                      class="rounded-lg p-2 text-gray-500 transition hover:bg-gray-100 hover:text-gray-700"
                      title="Edit"
                    >
                      <Icon icon="lucide:pencil" class="h-4 w-4" />
                    </Link>
                    <button
                      v-if="resolveDeleteRoute(rowItem)"
                      type="button"
                      class="rounded-lg p-2 text-red-400 transition hover:bg-red-50 hover:text-red-600 cursor-pointer"
                      title="Delete"
                      @click="destroyRow(rowItem)"
                    >
                      <Icon icon="lucide:trash-2" class="h-4 w-4" />
                    </button>
                  </slot>
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Footer -->
    <div
      class="flex flex-col gap-3 border-t border-gray-200 px-3.5 py-3 md:flex-row md:items-center md:justify-between md:px-4 md:py-3.5 lg:px-6 lg:py-4"
    >
      <!-- Result counts -->
      <span class="text-xs text-gray-500 md:text-sm">
        Showing
        <p class="font-medium text-gray-700">{{ from }}</p> to
        <p class="font-medium text-gray-700">{{ to }}</p> of
        <p class="font-medium text-gray-700">{{ totalRows }}</p> results
      </span>

      <!-- Controls -->
      <div
        class="flex items-center justify-between gap-3 w-full md:w-auto md:justify-end md:gap-4"
      >
        <!-- Per page -->
        <div
          class="flex items-center rounded-lg border border-gray-200 bg-white px-2.5 py-1 text-xs text-gray-600 shadow-xs md:text-sm"
        >
          <span class="font-medium text-gray-500">Per page</span>
          <div class="relative flex items-center">
            <select
              :value="perPage"
              @change="changePerPage"
              class="cursor-pointer appearance-none border-0 bg-transparent py-0 pl-1.5 pr-5 text-xs font-medium text-gray-700 focus:outline-none focus:ring-0 md:text-sm"
            >
              <option v-for="perPageOption in perPageOptions" :key="perPageOption" :value="perPageOption">
                {{ perPageOption }}
              </option>
            </select>
            <Icon
              icon="lucide:chevron-down"
              class="pointer-events-none absolute right-0 h-3.5 w-3.5 text-gray-400"
            />
          </div>
        </div>

        <!-- Segmented pagination buttons -->
        <nav
          class="inline-flex items-center divide-x divide-gray-200 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-xs shrink-0"
          aria-label="Pagination"
        >
          <!-- Prev -->
          <button
            type="button"
            :disabled="currentPage <= 1"
            @click="goToPage(currentPage - 1)"
            class="flex h-8 w-8 items-center justify-center text-gray-500 transition hover:bg-gray-50 enabled:cursor-pointer disabled:cursor-not-allowed disabled:opacity-40 md:h-9 md:w-9"
            title="Previous"
          >
            <Icon icon="lucide:chevron-left" class="h-4 w-4" />
          </button>

          <!-- Numbers -->
          <template
            v-for="(pageItem, pageIndex) in pageItems"
            :key="pageIndex"
          >
            <span
              v-if="pageItem === '…'"
              class="flex h-8 min-w-8 items-center justify-center px-2 text-xs text-gray-400 select-none md:h-9 md:min-w-9 md:text-sm"
            >
              …
            </span>
            <button
              v-else
              type="button"
              @click="goToPage(pageItem)"
              class="flex h-8 min-w-8 items-center justify-center px-2.5 text-xs font-medium transition cursor-pointer md:h-9 md:min-w-9 md:px-3 md:text-sm"
              :class="
                pageItem === currentPage
                  ? 'bg-gray-900 font-semibold text-white shadow-xs'
                  : 'text-gray-700 hover:bg-gray-50'
              "
            >
              {{ pageItem }}
            </button>
          </template>

          <!-- Next -->
          <button
            type="button"
            :disabled="currentPage >= lastPage"
            @click="goToPage(currentPage + 1)"
            class="flex h-8 w-8 items-center justify-center text-gray-500 transition hover:bg-gray-50 enabled:cursor-pointer disabled:cursor-not-allowed disabled:opacity-40 md:h-9 md:w-9"
            title="Next"
          >
            <Icon icon="lucide:chevron-right" class="h-4 w-4" />
          </button>
        </nav>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted, onUnmounted } from "vue";
import { Link, router } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import Swal from "sweetalert2";
import debounce from "../../debounce.js";

// Props
const props = defineProps({
  columns: { type: Array, required: true },
  rows: { type: Array, default: () => [] },
  meta: { type: Object, default: () => ({}) },
  filters: { type: Object, default: () => ({}) },
  routeName: { type: String, required: true },
  rowKey: { type: String, default: "id" },
  checkable: { type: Boolean, default: true },
  deletable: { type: Boolean, default: true },
  bulkDeleteRoute: { type: String, default: "" },
  showDateFilter: { type: Boolean, default: true },
  dateFilterLabel: { type: String, default: "Date" },
  perPageOptions: { type: Array, default: () => [10, 25, 50, 100] },
  rememberColumns: { type: Boolean, default: true },
  showActions: { type: Boolean, default: true },
  showGroupBy: { type: Boolean, default: true },
  groupByOptions: { type: Array, default: () => [] },
  showRowNumber: { type: Boolean, default: false },
  editRoute: { type: [String, Function], default: null },
  deleteRoute: { type: [String, Function], default: null },
});

const emit = defineEmits(["selection-change", "bulk-delete", "group-by-change"]);

// State
const reservedFilterKeys = ["page", "per_page", "sort", "direction"];

const normalizedInitialFilters =
  props.filters && !Array.isArray(props.filters) && typeof props.filters === "object"
    ? props.filters
    : {};

const form = reactive({
  search:
    typeof normalizedInitialFilters.search === "string"
      ? normalizedInitialFilters.search
      : "",
  date_from:
    typeof normalizedInitialFilters.date_from === "string"
      ? normalizedInitialFilters.date_from
      : "",
  date_to:
    typeof normalizedInitialFilters.date_to === "string"
      ? normalizedInitialFilters.date_to
      : "",
  ...Object.fromEntries(
    Object.entries(normalizedInitialFilters)
      .filter(
        ([filterKey, filterValue]) =>
          !reservedFilterKeys.includes(filterKey) &&
          typeof filterValue !== "function",
      )
      .map(([filterKey, filterValue]) => [filterKey, filterValue ?? ""]),
  ),
});

const activePanel = ref(null);
const selectedRowKeys = ref([]);
const isLoading = ref(false);
const columnsWrapperRef = ref(null);
const filtersWrapperRef = ref(null);
const bulkActionsWrapperRef = ref(null);
const openActionRowId = ref(null);

// Safe filters
const safeFilters = computed(() => {
  if (
    !props.filters ||
    Array.isArray(props.filters) ||
    typeof props.filters !== "object"
  ) {
    return {};
  }
  return props.filters;
});

// Group by
const selectedGroupBy = ref(
  typeof normalizedInitialFilters.group_by === "string"
    ? normalizedInitialFilters.group_by
    : "",
);

const groupableColumns = computed(() => {
  if (props.groupByOptions && props.groupByOptions.length > 0) {
    return props.groupByOptions;
  }
  return props.columns;
});

function onGroupByChange(changeEvent) {
  selectedGroupBy.value = changeEvent.target.value;
  emit("group-by-change", changeEvent.target.value);
  updateQuery({ page: 1, group_by: changeEvent.target.value || undefined });
}

// Action dropdown
function toggleActionMenu(rowItem) {
  const rowIdentifier = rowItem[props.rowKey];
  openActionRowId.value = openActionRowId.value === rowIdentifier ? null : rowIdentifier;
}

// Default row actions (edit/delete)
function resolveEditHref(rowItem) {
  if (typeof props.editRoute === "function") return props.editRoute(rowItem);
  if (typeof props.editRoute === "string" && props.editRoute) {
    return props.editRoute.replace(":id", rowItem[props.rowKey]);
  }
  return null;
}

function resolveDeleteRoute(rowItem) {
  if (typeof props.deleteRoute === "function") return props.deleteRoute(rowItem);
  return props.deleteRoute || null;
}

function destroyRow(rowItem) {
  const targetRoute = resolveDeleteRoute(rowItem);
  if (!targetRoute) return;

  Swal.fire({
    title: "Konfirmasi Hapus",
    text: "Hapus data ini? Aksi ini tidak bisa dibatalkan.",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc2626",
    cancelButtonColor: "#6b7280",
    confirmButtonText: "Ya, hapus",
    cancelButtonText: "Batal",
  }).then((confirmResult) => {
    if (!confirmResult.isConfirmed) return;
    router.delete(targetRoute, {
      data: { id: rowItem[props.rowKey] },
      preserveScroll: true,
      onSuccess: () => {
        selectedRowKeys.value = selectedRowKeys.value.filter(
          (rowIdentifier) => rowIdentifier !== rowItem[props.rowKey],
        );
        Swal.fire({
          title: "Berhasil!",
          text: "Data berhasil dihapus.",
          icon: "success",
          timer: 1500,
          showConfirmButton: false,
        });
      },
    });
  });
}

// Pagination meta
const paginationMeta = computed(
  () => (props.meta?.meta ? props.meta.meta : props.meta) || {},
);
const currentPage = computed(() => paginationMeta.value.current_page ?? 1);
const perPage = computed(() => paginationMeta.value.per_page ?? 10);
const totalRows = computed(() => paginationMeta.value.total ?? props.rows.length);
const lastPage = computed(
  () =>
    paginationMeta.value.last_page ??
    Math.max(1, Math.ceil(totalRows.value / perPage.value)),
);
const from = computed(
  () =>
    paginationMeta.value.from ??
    (totalRows.value > 0 ? (currentPage.value - 1) * perPage.value + 1 : 0),
);
const to = computed(
  () =>
    paginationMeta.value.to ?? Math.min(currentPage.value * perPage.value, totalRows.value),
);

// Nomor urut baris, mengikuti posisi halaman saat ini
function rowNumber(rowIndex) {
  return (currentPage.value - 1) * perPage.value + rowIndex + 1;
}

// Pagination items
const pageItems = computed(() => {
  const totalPages = lastPage.value;
  const activePage = currentPage.value;
  if (totalPages <= 7) {
    return Array.from({ length: totalPages }, (_, pageIndex) => pageIndex + 1);
  }
  const paginationArray = [1];
  let startPage = Math.max(2, activePage - 1);
  let endPage = Math.min(totalPages - 1, activePage + 1);
  if (activePage <= 3) {
    startPage = 2;
    endPage = 5;
  }
  if (activePage >= totalPages - 2) {
    startPage = totalPages - 4;
    endPage = totalPages - 1;
  }
  if (startPage > 2) paginationArray.push("…");
  for (let pageNumber = startPage; pageNumber <= endPage; pageNumber++) {
    paginationArray.push(pageNumber);
  }
  if (endPage < totalPages - 1) paginationArray.push("…");
  paginationArray.push(totalPages);
  return paginationArray;
});

// Sorting
const sortKey = computed(() => {
  const currentSort = safeFilters.value?.sort;
  if (typeof currentSort === "string" && currentSort.trim() !== "") {
    return currentSort.trim();
  }
  return null;
});

const sortDir = computed(() => {
  const currentDirection = safeFilters.value?.direction;
  if (typeof currentDirection === "string") {
    const normalizedDirection = currentDirection.toLowerCase().trim();
    if (normalizedDirection === "desc" || normalizedDirection === "asc") {
      return normalizedDirection;
    }
  }
  return "asc";
});

function sortBy(columnKey) {
  const targetColumn = props.columns.find((columnItem) => columnItem.key === columnKey);
  if (!targetColumn || targetColumn.sortable === false) return;
  const sortDirection = sortKey.value === columnKey && sortDir.value === "asc" ? "desc" : "asc";
  updateQuery({ page: 1, sort: columnKey, direction: sortDirection });
}

// Query
function updateQuery(overrides = {}, { replace = false } = {}) {
  const queryPayload = {
    ...form,
    page: 1,
    per_page: perPage.value,
    ...(sortKey.value ? { sort: sortKey.value, direction: sortDir.value } : {}),
    ...(selectedGroupBy.value ? { group_by: selectedGroupBy.value } : {}),
    ...overrides,
  };
  const filteredParams = Object.fromEntries(
    Object.entries(queryPayload).filter(
      ([, paramValue]) =>
        paramValue !== "" &&
        paramValue !== null &&
        paramValue !== undefined &&
        typeof paramValue !== "function",
    ),
  );

  router.get(props.routeName, filteredParams, {
    preserveState: true,
    preserveScroll: true,
    replace,
  });
}

// Sync safeFilters
watch(
  safeFilters,
  (newFilters) => {
    if (typeof newFilters.search === "string" && newFilters.search !== form.search) {
      form.search = newFilters.search;
    }
    if (typeof newFilters.date_from === "string" && newFilters.date_from !== form.date_from) {
      form.date_from = newFilters.date_from;
    }
    if (typeof newFilters.date_to === "string" && newFilters.date_to !== form.date_to) {
      form.date_to = newFilters.date_to;
    }
    if (typeof newFilters.group_by === "string") {
      selectedGroupBy.value = newFilters.group_by;
    }
  },
  { deep: true },
);

// Search
const debouncedSearch = debounce(() => {
  updateQuery({ page: 1 }, { replace: true });
}, 400);

function onSearch(searchValue) {
  form.search = searchValue;
  debouncedSearch();
}

// Filters
const activeFilterCount = computed(
  () =>
    Object.entries(form).filter(
      ([filterKey, filterValue]) => filterKey !== "search" && filterValue !== "" && filterValue !== null && filterValue !== undefined,
    ).length,
);

function applyFilters() {
  updateQuery({ page: 1 });
  activePanel.value = null;
}

function resetFilters() {
  for (const filterKey of Object.keys(form)) {
    form[filterKey] = "";
  }
  selectedGroupBy.value = "";
  updateQuery({ page: 1, sort: null, direction: null, group_by: undefined });
  activePanel.value = null;
}

// Checkbox selection
const rowIds = computed(() => props.rows.map((rowItem) => rowItem[props.rowKey]));
const allSelected = computed(
  () =>
    rowIds.value.length > 0 &&
    rowIds.value.every((rowIdentifier) => selectedRowKeys.value.includes(rowIdentifier)),
);
const someSelected = computed(() =>
  rowIds.value.some((rowIdentifier) => selectedRowKeys.value.includes(rowIdentifier)),
);

function toggleAll(changeEvent) {
  if (changeEvent.target.checked) {
    selectedRowKeys.value = [...new Set([...selectedRowKeys.value, ...rowIds.value])];
  } else {
    selectedRowKeys.value = selectedRowKeys.value.filter((rowIdentifier) => !rowIds.value.includes(rowIdentifier));
  }
}

function isRowSelected(rowItem) {
  return selectedRowKeys.value.includes(rowItem[props.rowKey]);
}

// Selection actions
function selectAllRows() {
  selectedRowKeys.value = [...new Set([...selectedRowKeys.value, ...rowIds.value])];
}

function clearSelection() {
  selectedRowKeys.value = [];
}

function handleBulkDeleteAndClose() {
  activePanel.value = null;
  bulkDelete();
}

watch(selectedRowKeys, (selectedArray) => emit("selection-change", selectedArray), { deep: true });

// Bulk delete
function bulkDelete() {
  if (!selectedRowKeys.value.length) return;

  Swal.fire({
    title: "Konfirmasi Hapus",
    text: `Hapus ${selectedRowKeys.value.length} data terpilih? Aksi ini tidak bisa dibatalkan.`,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#dc2626",
    cancelButtonColor: "#6b7280",
    confirmButtonText: "Ya, hapus",
    cancelButtonText: "Batal",
  }).then((confirmResult) => {
    if (confirmResult.isConfirmed) {
      if (props.bulkDeleteRoute) {
        router.delete(props.bulkDeleteRoute, {
          data: { ids: selectedRowKeys.value },
          preserveScroll: true,
          onSuccess: () => {
            selectedRowKeys.value = [];
            Swal.fire({
              title: "Berhasil!",
              text: "Data terpilih berhasil dihapus.",
              icon: "success",
              timer: 1500,
              showConfirmButton: false,
            });
          },
        });
      } else {
        emit("bulk-delete", [...selectedRowKeys.value]);
      }
    }
  });
}

// Column visibility
const storageKey = computed(() => `datatable:columns:${props.routeName}`);
const toggleableColumns = computed(() =>
  props.columns.filter((columnItem) => columnItem.locked !== true),
);

function defaultVisibleKeys() {
  return props.columns
    .filter((columnItem) => columnItem.visible !== false)
    .map((columnItem) => columnItem.key);
}

const visibleKeys = ref(
  (() => {
    if (props.rememberColumns) {
      try {
        const storedKeys = JSON.parse(
          localStorage.getItem(storageKey.value) || "null",
        );
        if (Array.isArray(storedKeys) && storedKeys.length) return storedKeys;
      } catch (storageError) {
        // Abaikan error storage
      }
    }
    return defaultVisibleKeys();
  })(),
);

const visibleColumns = computed(() =>
  props.columns.filter((columnItem) => visibleKeys.value.includes(columnItem.key)),
);

function applyColumns() {
  if (!visibleKeys.value.length) return;
  if (props.rememberColumns) {
    localStorage.setItem(storageKey.value, JSON.stringify(visibleKeys.value));
  }
  activePanel.value = null;
}

function resetColumns() {
  visibleKeys.value = defaultVisibleKeys();
  if (props.rememberColumns) localStorage.removeItem(storageKey.value);
  activePanel.value = null;
}

// Pagination actions
function goToPage(targetPageNumber) {
  if (
    typeof targetPageNumber !== "number" ||
    targetPageNumber < 1 ||
    targetPageNumber > lastPage.value ||
    targetPageNumber === currentPage.value
  )
    return;
  updateQuery({ page: targetPageNumber });
}

function changePerPage(changeEvent) {
  updateQuery({ page: 1, per_page: Number(changeEvent.target.value) });
}

function resolveDataPath(columnItem) {
  if (typeof columnItem.data === "string" && columnItem.data.trim() !== "") {
    return columnItem.data;
  }
  return columnItem.label;
}

function getCellValue(rowItem, columnItem) {
  const dataPath = resolveDataPath(columnItem);
  if (!dataPath || typeof dataPath !== "string") return undefined;
  if (!dataPath.includes(".")) return rowItem?.[dataPath];
  return dataPath
    .split(".")
    .reduce((accumulator, keySegment) => (accumulator == null ? accumulator : accumulator[keySegment]), rowItem);
}

// Helper: format nilai cell untuk ditampilkan
function formatCell(cellValue) {
  if (cellValue === null || cellValue === undefined || cellValue === "") return "—";
  if (typeof cellValue === "boolean") return cellValue ? "Yes" : "No";
  if (Array.isArray(cellValue)) return cellValue.length ? cellValue.join(", ") : "—";
  return cellValue;
}

// Outside click / Escape
function onDocumentClick(clickEvent) {
  if (
    activePanel.value === "columns" &&
    columnsWrapperRef.value &&
    !columnsWrapperRef.value.contains(clickEvent.target)
  ) {
    activePanel.value = null;
  }
  if (
    activePanel.value === "filters" &&
    filtersWrapperRef.value &&
    !filtersWrapperRef.value.contains(clickEvent.target)
  ) {
    activePanel.value = null;
  }
  if (
    activePanel.value === "bulkActions" &&
    bulkActionsWrapperRef.value &&
    !bulkActionsWrapperRef.value.contains(clickEvent.target)
  ) {
    activePanel.value = null;
  }
  if (openActionRowId.value !== null) {
    openActionRowId.value = null;
  }
}

function onKeydown(keyboardEvent) {
  if (keyboardEvent.key === "Escape") {
    if (activePanel.value) activePanel.value = null;
    if (openActionRowId.value !== null) openActionRowId.value = null;
  }
}

onMounted(() => {
  document.addEventListener("click", onDocumentClick);
  document.addEventListener("keydown", onKeydown);
});

// Loading state
const offStart = router.on("start", () => (isLoading.value = true));
const offFinish = router.on("finish", () => (isLoading.value = false));

onUnmounted(() => {
  document.removeEventListener("click", onDocumentClick);
  document.removeEventListener("keydown", onKeydown);
  offStart();
  offFinish();
});
</script>
