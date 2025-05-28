<template>
  <div class="min-h-screen flex items-center justify-center bg-emerald-50">
    <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-md">
      <h2 class="text-2xl font-bold text-emerald-700 mb-6 text-center">Connexion Admin</h2>
      <form @submit.prevent="handleLogin">
        <div class="mb-4">
          <label for="email" class="block text-gray-700">Email</label>
          <input v-model="email" type="email" id="email" required class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <div class="mb-6">
          <label for="password" class="block text-gray-700">Mot de passe</label>
          <input v-model="password" type="password" id="password" required class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-500">
        </div>
        <button type="submit" class="w-full bg-emerald-600 text-white py-2 rounded-lg hover:bg-emerald-700 transition">Se connecter</button>
        <p v-if="error" class="text-red-600 mt-4 text-center">{{ error }}</p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const error = ref('')
const router = useRouter()

const handleLogin = async () => {
  try {
    const form = new FormData()
    form.append('email', email.value)
    form.append('mot_de_passe', password.value)

    const response = await axios.post('http://localhost:8000/admin/login', form)

    if (response.data.success) {
      router.push('/admin/dashboard') // À définir
    } else {
      error.value = "Email ou mot de passe incorrect"
    }
  } catch (err) {
    error.value = "Erreur de connexion au serveur", err.message
  }
}
</script>
