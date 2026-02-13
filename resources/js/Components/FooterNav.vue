<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <nav class="flex justify-around items-center bg-indigo-600 h-[56px] shadow-lg fixed left-0 bottom-0 w-full z-[100] backdrop-blur-md high-contrast:border-t-2 high-contrast:border-white" role="navigation" aria-label="Footer navigation">
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
  </nav>
</template>
