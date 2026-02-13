<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const user = computed(() => page.props.auth.user);

const scrollToTop = () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
};
</script>

<template>
  <nav class="flex justify-around items-center bg-indigo-600 h-[56px] shadow-lg fixed left-1/2 bottom-0 -translate-x-1/2 w-full max-w-[600px] z-[100] backdrop-blur-md high-contrast:border-t-2 high-contrast:border-white" role="navigation" aria-label="Footer navigation">
    <!-- Guest Footer: Legal Links -->
    <template v-if="!user">
      <Link :href="route('terms')" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0" :class="{ 'bg-white/20 shadow-[0_2px_8px_rgba(24,119,242,0.10)]': route().current('terms') }">
        <i class="fas fa-file-contract text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">ToS</span>
      </Link>
      <Link :href="route('privacy')" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0" :class="{ 'bg-white/20 shadow-[0_2px_8px_rgba(24,119,242,0.10)]': route().current('privacy') }">
        <i class="fas fa-user-shield text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Privacy</span>
      </Link>
      <Link :href="route('cookies')" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0" :class="{ 'bg-white/20 shadow-[0_2px_8px_rgba(24,119,242,0.10)]': route().current('cookies') }">
        <i class="fas fa-cookie-bite text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Cookies</span>
      </Link>
    </template>

    <!-- Auth Footer: Home, Chatroom, Forum, Top -->
    <template v-else>
      <Link :href="route('dashboard')" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0" :class="{ 'bg-white/20 shadow-[0_2px_8px_rgba(24,119,242,0.10)]': route().current('dashboard') }">
        <i class="fas fa-home text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Home</span>
      </Link>
      <Link href="#" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0">
        <i class="fas fa-comments text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Chatroom</span>
      </Link>
      <Link href="#" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0">
        <i class="fas fa-newspaper text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Forum</span>
      </Link>
      <button @click="scrollToTop" class="text-white font-bold no-underline text-base flex-1 text-center py-2 pb-1 flex flex-col items-center justify-center transition-all duration-200 ease-in-out rounded-sm min-h-[44px] min-w-[44px] hover:bg-white/10 hover:-translate-y-[1px] focus:outline-2 focus:outline-white focus:outline-offset-2 motion-reduce:transition-none motion-reduce:hover:translate-y-0">
        <i class="fas fa-arrow-up text-2xl mb-0.5 font-bold"></i>
        <span class="text-[13px] font-bold mt-1 leading-none">Top</span>
      </button>
    </template>
  </nav>
</template>

