<template>
  <div class="min-h-screen flex items-center justify-center bg-emerald-100">
    <div class="bg-white p-6 rounded-2xl shadow-lg w-full max-w-md">
      <h2 class="text-2xl font-bold text-emerald-600 mb-4">Connexion Admin</h2>
      <form @submit.prevent="handleLogin">
        <input
          v-model="email"
          type="email"
          placeholder="Email"
          class="w-full p-2 border rounded mb-3"
          required
        />
        <input
          v-model="password"
          type="password"
          placeholder="Mot de passe"
          class="w-full p-2 border rounded mb-3"
          required
        />
        <button
          type="submit"
          class="w-full bg-emerald-600 text-white p-2 rounded hover:bg-emerald-700"
        >
          Se connecter
        </button>
        <p v-if="errorMessage" class="text-red-500 mt-3">{{ errorMessage }}</p>
      </form>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const email = ref('')
const password = ref('')
const errorMessage = ref('')
const router = useRouter()

const handleLogin = async () => {
  errorMessage.value = ''
  try {
    const response = await fetch('http://localhost:8000/router.php?url=admin/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email.value, password: password.value })
    })

    const result = await response.json()
    if (result.success) {
      localStorage.setItem('adminConnected', 'true') // ✅ Enregistrement de la session
      router.push('/admin/dashboard')
    } else {
      errorMessage.value = result.message
    }
    } catch (err) {
      errorMessage.value = "Erreur lors de la connexion au serveur.", err.message;
    }
}
</script>
