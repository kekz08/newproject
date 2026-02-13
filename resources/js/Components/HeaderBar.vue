<template>
  <header class="header-bar">
    <img :src="cityscape" class="header-bg" alt="Cityscape background" />
    <Link href="/" class="header-logo-container">
      <img :src="logo" class="header-logo" :alt="appName + ' Logo'" />
    </Link>
  </header>
</template>

<script setup>
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import logo from '@/Assets/logo.png';
import cityscape from '@/Assets/defaultbg.jpg';
import '@/../css/header-bar.css';

const page = usePage();
const appName = computed(() => page.props.appName || 'Pinoypark');
</script>

