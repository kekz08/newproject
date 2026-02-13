<script setup>
import { Link } from '@inertiajs/vue3';
import '@/../css/footer-nav.css';
</script>

<template>
  <nav class="footer-nav" role="navigation" aria-label="Footer navigation">
    <Link :href="route('terms')" class="footer-link" :class="{ 'footer-link-active': route().current('terms') }">
      <i class="fas fa-file-contract"></i>
      <span class="footer-text">ToS</span>
    </Link>
    <Link :href="route('privacy')" class="footer-link" :class="{ 'footer-link-active': route().current('privacy') }">
      <i class="fas fa-user-shield"></i>
      <span class="footer-text">Privacy</span>
    </Link>
    <Link :href="route('cookies')" class="footer-link" :class="{ 'footer-link-active': route().current('cookies') }">
      <i class="fas fa-cookie-bite"></i>
      <span class="footer-text">Cookies</span>
    </Link>
  </nav>
</template>
