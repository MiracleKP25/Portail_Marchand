<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const routes = ref([])

onMounted(async () => {
  try {
    const res = await axios.get('http://localhost:8000/router.php', {
      headers: { Accept: 'application/json' }
    })
    routes.value = res.data.routes
  } catch (error) {
    console.error('Erreur lors de la récupération des routes', error)
  }
})
</script>

<template>
  <div class="p-8 bg-emerald-50 min-h-screen">
    <h1 class="text-3xl font-bold text-emerald-800 mb-6">📘 Documentation API</h1>

    <div v-for="route in routes" :key="route.path" class="mb-4 p-4 bg-white border-l-4 border-emerald-500 shadow rounded-lg">
      <p class="font-bold text-emerald-700">
        {{ route.method }}
        <span class="ml-2 text-gray-600 font-mono">{{ route.path }}</span>
      </p>
      <p class="text-gray-700 mt-1">{{ route.description }}</p>
    </div>
  </div>
</template>
