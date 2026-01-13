<template>
  <div class="flex flex-col h-screen bg-gradient-to-b from-red-950 via-red-900/90 to-red-950">
    <div class="border-b border-red-800/40 backdrop-blur-sm bg-black/20 px-6 py-4 flex-shrink-0">
      <nav class="flex gap-2">
        <router-link to="/user/settings"
          class="flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium transition-all text-red-200/70 hover:text-white hover:bg-red-800/40 hover:shadow-lg hover:shadow-red-900/20"
          active-class="!bg-red-700 !text-white shadow-xl shadow-red-900/50 border border-red-600/30">
          Settings
        </router-link>

        <router-link to="/user/inventory"
          class="flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium transition-all text-red-200/70 hover:text-white hover:bg-red-800/40 hover:shadow-lg hover:shadow-red-900/20"
          active-class="!bg-red-700 !text-white shadow-xl shadow-red-900/50 border border-red-600/30">
          Inventory
        </router-link>

        <router-link to="/user/characters"
          class="flex items-center gap-2 px-5 py-2.5 rounded-lg font-medium transition-all text-red-200/70 hover:text-white hover:bg-red-800/40 hover:shadow-lg hover:shadow-red-900/20"
          active-class="!bg-red-700 !text-white shadow-xl shadow-red-900/50 border border-red-600/30">
          Characters
        </router-link>
      </nav>
    </div>

    <div class="flex-1 min-h-0 overflow-hidden">
      <router-view class="h-full"></router-view>
    </div>
  </div>
</template>

<script>
export default {};
</script>