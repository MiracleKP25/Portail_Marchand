<script setup>
import { useRoute } from 'vue-router'

const route = useRoute()
</script>

<template>
  <nav class="bg-white shadow-md px-6 py-4">
    <ul class="flex gap-6 items-center">
      <li>
        <router-link
          to="/"
          :class="[
            'nav-link',
            route.path === '/' ? 'active' : ''
          ]"
        >
          Accueil
        </router-link>
      </li>
      <li>
        <router-link
          to="/formulaire"
          :class="[
            'nav-link',
            route.path === '/formulaire' ? 'active' : ''
          ]"
        >
          Formulaire
        </router-link>
      </li>
      <li>
        <router-link
          to="/suivi"
          :class="[
            'nav-link',
            route.path === '/suivi' ? 'active' : ''
          ]"
        >
          Suivi de demande
        </router-link>
      </li>
    </ul>
  </nav>
</template>

<style scoped>

</style>
