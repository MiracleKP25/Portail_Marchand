<script setup>
import { ref } from 'vue'
import NavComponent from './NavComponent.vue'

const email = ref('')
const statut = ref(null)
const erreur = ref('')
const loading = ref(false)

// Fonction pour vérifier le statut d'une demande en fonction de l'email
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

    const raw = await res.text()

    if (!raw) throw new Error('Réponse vide du serveur')

    const data = JSON.parse(raw)

    if (!res.ok || !data.success) {
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
  <NavComponent/>
  <div class="max-w-md mx-auto mt-16 px-6 py-8 bg-white shadow-2xl rounded-2xl transition-all duration-300">
    <h2 class="text-2xl font-bold text-emerald-700 mb-6 text-center">🔍 Suivi de votre demande</h2>

    <form @submit.prevent="verifierStatut" class="space-y-5">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Adresse email</label>
        <input
          v-model="email"
          type="email"
          required
          class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 transition duration-200"
          placeholder="exemple@email.com"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2.5 rounded-lg transition duration-200"
        :disabled="loading"
      >
        <span v-if="!loading">Voir le statut</span>
        <span v-else>⏳ Recherche...</span>
      </button>
    </form>

    <transition name="fade">
      <div
        v-if="statut"
        class="mt-6 p-4 rounded-lg bg-emerald-100 border border-emerald-300 text-emerald-800 font-medium"
      >
        ✅ Statut de votre demande : <strong>{{ statut }}</strong>
      </div>
    </transition>

    <transition name="fade">
      <div
        v-if="erreur"
        class="mt-6 p-4 rounded-lg bg-red-100 border border-red-300 text-red-800 font-medium"
      >
        ⚠️ {{ erreur }}
      </div>
    </transition>
  </div>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
</style>
