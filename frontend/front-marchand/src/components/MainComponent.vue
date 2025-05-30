<script setup>
import { useRouter } from 'vue-router'
const router = useRouter()
const logout = () => {
  localStorage.removeItem('adminConnected') // ✅ Supprime la session
  router.push('/admin/login') // Redirige vers login
}
</script>

<template>
  <div class="flex justify-between items-center">
        <h1 class="text-3xl font-serif">Tableau de bord</h1>
        <button @click="logout()" class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600">
          Déconnexion
        </button>
    </div>
  <router-view/>
</template>

<style scoped>

</style>
