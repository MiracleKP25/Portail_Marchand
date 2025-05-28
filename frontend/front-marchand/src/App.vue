<script setup>
import { RouterView } from 'vue-router'
</script>

<template>
  <nav class="bg-white shadow p-4 flex gap-4">
    <router-link to="/" class="text-emerald-600 hover:underline">Accueil</router-link>
    <router-link to="/formulaire" class="text-emerald-600 hover:underline">Formulaire</router-link>
    <router-link to="/suivi" class="text-emerald-600 hover:underline">Suivi de demande</router-link>
  </nav>

  <RouterView />
</template>

<style scoped>

</style>
