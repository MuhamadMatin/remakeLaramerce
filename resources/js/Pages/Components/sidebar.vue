<template>
  <!-- Mobile navbar -->
  <header
    class="sticky top-0 z-30 bg-white border-b border-gray-200 h-14 px-4 flex items-center justify-between w-full lg:hidden"
  >
    <!-- Logo -->
    <Link href="#" class="flex-shrink-0 flex items-center gap-2 order-1">
      <Icon icon="lucide:store" class="w-8 h-8 text-blue-600" />
      <p class="text-blue-600 font-bold text-lg sm:text-xl tracking-tight">
        Store
      </p>
    </Link>
    <div class="flex items-center gap-3">
      <button
        type="button"
        class="p-2 -ml-2 text-gray-600 hover:text-gray-900 rounded-lg hover:bg-gray-100 transition-colors cursor-pointer"
        @click="isSidebarOpen = !isSidebarOpen"
        aria-label="Toggle Menu"
      >
        <Icon icon="lucide:menu" class="w-5 h-5" />
      </button>
    </div>
  </header>

  <!-- Backdrop -->
  <div
    v-if="isSidebarOpen"
    class="fixed inset-0 bg-gray-900/50 z-40 transition-opacity lg:hidden"
    @click="isSidebarOpen = false"
  ></div>

  <!-- Sidebar -->
  <aside
    class="w-64 bg-white border-r border-gray-200 flex flex-col transition-transform duration-200 fixed inset-y-0 left-0 z-50 lg:sticky lg:top-0 lg:inset-auto lg:h-screen lg:shrink-0 lg:z-30 lg:translate-x-0"
    :class="isSidebarOpen ? 'translate-x-0' : '-translate-x-full'"
  >
    <!-- Brand -->
    <div
      class="h-16 px-6 border-b border-gray-200 flex items-center justify-between shrink-0"
    >
      <!-- Logo -->
      <Link href="#" class="flex-shrink-0 flex items-center gap-2 order-1">
        <Icon icon="lucide:store" class="w-8 h-8 text-blue-600" />
        <p class="text-blue-600 font-bold text-lg sm:text-xl tracking-tight">
          Store
        </p>
      </Link>
      <!-- Mobile close -->
      <button
        type="button"
        class="p-1.5 text-gray-500 hover:text-gray-900 rounded-lg hover:bg-gray-100 lg:hidden cursor-pointer"
        @click="isSidebarOpen = false"
        aria-label="Close Menu"
      >
        <Icon icon="lucide:x" class="w-5 h-5" />
      </button>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-3 flex flex-col gap-6">
      <div
        v-for="(group, groupIndex) in navigationGroups"
        :key="groupIndex"
        class="flex flex-col gap-1"
      >
        <!-- Group header -->
        <button
          v-if="group.collapsible"
          type="button"
          class="w-full flex items-center justify-between px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider hover:text-gray-600 transition-colors cursor-pointer"
          @click="group.isOpen = !group.isOpen"
        >
          <span>{{ group.title }}</span>
          <Icon
            icon="lucide:chevron-down"
            class="w-4 h-4 transition-transform duration-200"
            :class="group.isOpen ? 'rotate-0' : '-rotate-90'"
          />
        </button>

        <!-- Group items -->
        <div
          v-show="!group.collapsible || group.isOpen"
          class="flex flex-col gap-1"
          :class="{ 'mt-1': group.collapsible }"
        >
          <Link
            v-for="(item, index) in group.items"
            :key="index"
            :href="item.href"
            class="flex items-center justify-between px-3 py-2 rounded-lg text-sm font-medium transition-colors"
            :class="
              $page.url === item.href
                ? 'bg-gray-100 text-blue-600'
                : 'text-gray-600 hover:text-gray-900 hover:bg-gray-50'
            "
          >
            <div class="flex items-center gap-3">
              <Icon
                :icon="item.icon"
                class="w-5 h-5"
                :class="item.isActive ? 'text-blue-600' : 'text-gray-400'"
              />
              <span>{{ item.label }}</span>
            </div>
            <span
              v-if="item.badge"
              class="text-xs font-semibold px-2 py-0.5 rounded-full"
              :class="
                item.isActive
                  ? 'bg-blue-100 text-blue-700'
                  : 'bg-blue-50 text-blue-600'
              "
            >
              {{ item.badge }}
            </span>
          </Link>
        </div>
      </div>
    </nav>

    <!-- Profile -->
    <div class="p-3 border-t border-gray-200 shrink-0">
      <Link
        href="/dashboard/profile"
        class="flex items-center gap-3 p-2 rounded-lg transition-colors group"
        :class="
          $page.url === '/dashboard/profile'
            ? 'bg-gray-100 text-blue-600'
            : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'
        "
      >
        <!-- Avatar -->
        <div class="relative w-9 h-9 shrink-0 flex items-center justify-center">
          <img
            v-if="userAvatar"
            :src="userAvatar"
            :alt="authUser.name"
            class="w-9 h-9 rounded-full object-cover border border-gray-200"
          />
          <div
            v-else
            class="w-9 h-9 rounded-full bg-black text-white flex items-center justify-center text-xs font-bold tracking-wider"
          >
            {{ userInitials }}
          </div>
        </div>

        <div class="flex-1 min-w-0">
          <p
            class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600 transition-colors"
          >
            {{ authUser.name }}
          </p>
          <p v-if="authUser?.email" class="text-xs text-gray-500 truncate">
            {{ authUser.email }}
          </p>
        </div>

        <Icon
          icon="lucide:chevron-right"
          class="w-4 h-4 text-gray-400 group-hover:text-gray-600 transition-colors shrink-0"
        />
      </Link>
    </div>
    <div class="p-3 shrink-0">
      <Link
        href="/logout"
        method="post"
        as="button"
        class="w-full flex items-center gap-3 p-2 border-2 border-red-400 text-red-400 rounded-lg hover:bg-red-400 transition-colors hover:cursor-pointer group"
      >
        <Icon
          icon="reicon:logout-2"
          class="w-4 h-4 group-hover:text-gray-900 transition-colors shrink-0"
        />
        <p class="group-hover:text-gray-900">Sign-out</p>
      </Link>
    </div>
  </aside>
</template>

<script setup lang="ts">
import { Link, usePage } from "@inertiajs/vue3";
import { Icon } from "@iconify/vue";
import { ref, computed } from "vue";

// State
const isSidebarOpen = ref(false);
const prefix = "/dashboard";

// User
const page = usePage();
const authUser = computed(() => page.props.auth?.user);
const userAvatar = computed(
  () =>
    authUser.value?.photo ||
    authUser.value?.avatar ||
    authUser.value?.profile_photo_url ||
    "",
);
const userInitials = computed(() => {
  const name = authUser.value?.name || "Demo User";
  return name
    .split(" ")
    .map((word: string) => word[0])
    .filter(Boolean)
    .join("")
    .substring(0, 2)
    .toUpperCase();
});

// Navigation data
const navigationGroups = ref([
  {
    collapsible: false,
    items: [
      {
        label: "Home",
        href: "/dashboard",
        icon: "lucide:home",
      },
    ],
  },
  {
    title: "Products",
    collapsible: true,
    isOpen: true,
    items: [
      {
        label: "Products",
        href: prefix + "/products",
        icon: "lucide:zap",
        badge: 3,
      },
      {
        label: "Customers",
        href: prefix + "/customers",
        icon: "lucide:users",
      },
      {
        label: "Brands",
        href: prefix + "/brands",
        icon: "lucide:tag",
      },
      {
        label: "Categories",
        href: prefix + "/categories",
        icon: "lucide:folder",
      },
      {
        label: "Orders",
        href: prefix + "/orders",
        icon: "lucide:shopping-bag",
        badge: 155,
      },
    ],
  },
  {
    title: "Users",
    collapsible: true,
    isOpen: true,
    items: [
      {
        label: "User",
        href: prefix + "/users",
        icon: "lucide:users",
      },
      {
        label: "Store",
        href: prefix + "/store",
        icon: "lucide:calendar",
        badge: 71,
      },
      {
        label: "Store Owner",
        href: prefix + "/owner",
        icon: "lucide:users",
      },
    ],
  },
  {
    title: "Settings",
    collapsible: true,
    isOpen: true,
    items: [
      {
        label: "Setting",
        href: prefix + "/setting",
        icon: "lucide:folder",
        badge: 9,
      },
      {
        label: "Timesheets",
        href: "#",
        icon: "lucide:clock",
      },
    ],
  },
]);
</script>
