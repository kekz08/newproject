<template>
  <header class="fixed top-0 left-1/2 -translate-x-1/2 w-full max-w-[600px] h-14 md:h-[56px] flex items-center justify-center overflow-hidden border-b-2 border-indigo-600 bg-white shadow-[0_2px_8px_rgba(0,0,0,0.07)] z-[200]">
    <img :src="cityscape" class="absolute left-0 top-0 w-full h-full object-cover z-[1] opacity-65 transition-opacity duration-300 ease-in-out" alt="Cityscape background" />
    <Link href="/" class="relative z-[2] block">
      <img :src="logo" class="h-9 md:h-10 w-auto max-w-[80vw] block mx-auto p-0 drop-shadow-[0_2px_4px_rgba(0,0,0,0.3)] transition-transform duration-200 ease-in-out hover:scale-105 motion-reduce:transition-none motion-reduce:hover:scale-100" :alt="appName + ' Logo'" />
    </Link>
  </header>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import logo from '@/Assets/logo.png';
import cityscape from '@/Assets/defaultbg.jpg';

const page = usePage();
const appName = computed(() => page.props.appName || 'Pinoypark');
</script>

