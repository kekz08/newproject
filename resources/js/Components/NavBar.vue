<script setup>
import { Link } from '@inertiajs/vue3';
import { ref } from 'vue';

const props = defineProps({
    activeTab: {
        type: String,
        default: 'home'
    },
    unreadChats: {
        type: Number,
        default: 0
    },
    unreadCount: {
        type: Number,
        default: 0
    },
    activeEventsCount: {
        type: Number,
        default: 0
    }
});

defineEmits(['menu-press', 'toggle-notifications']);

// These functions would typically use router.visit or Link,
// but since this is a component, we can use Link in template
// or define methods if logic is needed.
</script>

<template>
  <div class="fixed top-14 left-1/2 -translate-x-1/2 w-full max-w-[600px] h-14 z-[300] bg-indigo-600 shadow-lg flex items-center justify-around backdrop-blur-md">
    <!-- Home -->
    <Link
      :href="route('dashboard')"
      class="flex-1 h-full min-w-[44px] flex flex-col items-center justify-center cursor-pointer transition-all duration-200 ease-in-out rounded-sm"
      :class="activeTab === 'home' ? 'bg-white/20' : 'text-white hover:bg-white/10'"
    >
      <i class="fas fa-home text-2xl" :class="activeTab === 'home' ? 'text-white' : 'text-white'"></i>
    </Link>

    <!-- Messenger -->
    <Link
      href="#"
      class="flex-1 h-full min-w-[44px] flex flex-col items-center justify-center cursor-pointer transition-all duration-200 ease-in-out relative rounded-sm"
      :class="activeTab === 'messenger' ? 'bg-white/20' : 'text-white hover:bg-white/10'"
    >
      <i class="fab fa-facebook-messenger text-2xl"></i>
      <span v-if="unreadChats > 0" class="absolute top-1 right-1/4 bg-[#f44336] text-white rounded-full text-[12px] min-w-[20px] min-h-[20px] flex items-center justify-center z-[2] border border-white">
        {{ unreadChats }}
      </span>
    </Link>

    <!-- Notifications -->
    <button
      @click.stop="$emit('toggle-notifications')"
      class="flex-1 h-full min-w-[44px] flex flex-col items-center justify-center cursor-pointer transition-all duration-200 ease-in-out relative z-[301] rounded-sm"
      :class="activeTab === 'notifications' ? 'bg-white/20' : 'text-white hover:bg-white/10'"
    >
      <i class="fas fa-bell text-2xl"></i>
      <span v-if="unreadCount > 0" class="absolute top-1 right-1/4 bg-[#f44336] text-white rounded-full text-[12px] min-w-[20px] min-h-[20px] flex items-center justify-center z-[2] border border-white">
        {{ unreadCount }}
      </span>
    </button>

    <!-- Events -->
    <Link
      href="#"
      class="flex-1 h-full min-w-[44px] flex flex-col items-center justify-center cursor-pointer transition-all duration-200 ease-in-out relative rounded-sm"
      :class="activeTab === 'events' ? 'bg-white/20' : 'text-white hover:bg-white/10'"
    >
      <i class="fas fa-calendar-alt text-2xl"></i>
      <span v-if="activeEventsCount > 0" class="absolute top-1 right-1/4 bg-[#f44336] text-white rounded-full text-[12px] min-w-[20px] min-h-[20px] flex items-center justify-center z-[2] border border-white">
        {{ activeEventsCount }}
      </span>
    </Link>

    <!-- Menu -->
    <button
      @click="$emit('menu-press')"
      class="flex-1 h-full min-w-[44px] flex flex-col items-center justify-center cursor-pointer transition-all duration-200 ease-in-out rounded-sm"
      :class="activeTab === 'menu' ? 'bg-white/20' : 'text-white hover:bg-white/10'"
    >
      <i class="fas fa-bars text-2xl"></i>
    </button>
  </div>
</template>
