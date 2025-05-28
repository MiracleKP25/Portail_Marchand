<script setup>
import { ref } from 'vue'

const email = ref('')
const statut = ref(null)
const erreur = ref('')
const loading = ref(false)

const verifierStatut = async () => {
  erreur.value = ''
  statut.value = null
  loading.value = true

  try {
    const res = await fetch('http://localhost:8000/router.php?url=vendeur/status', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ email: email.value }),
    })

    const data = await res.json()

    if (!res.ok) {
      throw new Error(data.error || 'Erreur inconnue')
    }

    statut.value = data.statut
  } catch (err) {
    erreur.value = err.message
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="max-w-md mx-auto mt-10 p-6 bg-white shadow-lg rounded-2xl">
    <h2 class="text-xl font-semibold text-emerald-700 mb-4">🔍 Suivre votre demande</h2>

    <form @submit.prevent="verifierStatut" class="space-y-4">
      <label class="block text-sm font-medium text-gray-700">Adresse email</label>
      <input v-model="email" type="email" required class="input" placeholder="exemple@email.com" />

      <button type="submit" class="btn-green w-full" :disabled="loading">
        {{ loading ? 'Recherche...' : 'Voir le statut' }}
      </button>
    </form>

    <div v-if="statut" class="mt-4 p-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800">
      ✅ Statut de votre demande : <strong>{{ statut }}</strong>
    </div>

    <div v-if="erreur" class="mt-4 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800">
      ⚠️ {{ erreur }}
    </div>
  </div>
</template>

<style scoped>
/* .input {
  @apply w-full p-2 rounded-md border border-slate-300 focus:outline-none focus:ring-2 focus:ring-emerald-500;
}
.btn-green {
  @apply bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2 rounded-md transition duration-200;
} */
</style>
