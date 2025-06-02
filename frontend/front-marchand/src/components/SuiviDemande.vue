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
  <div class="max-w-md mx-auto mt-20 px-8 py-10 bg-white shadow-2xl rounded-3xl border border-emerald-100">
    <h2 class="text-3xl font-extrabold text-center bg-gradient-to-r from-emerald-600 to-emerald-400 text-transparent bg-clip-text mb-8 animate-fade-in">
      🔍 Suivi de votre demande
    </h2>

    <form @submit.prevent="verifierStatut" class="space-y-6">
      <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1">Adresse email</label>
        <input
          v-model="email"
          type="email"
          required
          class="w-full px-4 py-2.5 rounded-xl border border-gray-300 shadow-inner focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-emerald-600 transition duration-300"
          placeholder="exemple@email.com"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-emerald-600 hover:bg-emerald-700 active:scale-95 text-white font-bold py-3 rounded-xl transition duration-300 flex items-center justify-center gap-2"
        :disabled="loading"
      >
        <svg
          v-if="loading"
          class="animate-spin h-5 w-5 text-white"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
        >
          <circle
            class="opacity-25"
            cx="12"
            cy="12"
            r="10"
            stroke="currentColor"
            stroke-width="4"
          ></circle>
          <path
            class="opacity-75"
            fill="currentColor"
            d="M4 12a8 8 0 018-8v8H4z"
          ></path>
        </svg>
        <span>{{ loading ? 'Recherche en cours...' : 'Voir le statut' }}</span>
      </button>
    </form>

    <transition name="slide-fade">
      <div
        v-if="statut"
        class="mt-8 p-5 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 font-semibold shadow-md flex items-start gap-2"
      >
        <span class="text-2xl">✅</span>
        <span>Statut de votre demande : <strong>{{ statut }}</strong></span>
      </div>
    </transition>

    <transition name="slide-fade">
      <div
        v-if="erreur"
        class="mt-8 p-5 rounded-xl bg-red-50 border border-red-300 text-red-800 font-semibold shadow-md flex items-start gap-2"
      >
        <span class="text-2xl">⚠️</span>
        <span>{{ erreur }}</span>
      </div>
    </transition>
  </div>
</template>

<style scoped>
/* Entrée fluide */
@keyframes fade-in {
  0% {
    opacity: 0;
    transform: translateY(-10px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.6s ease-out forwards;
}

/* Animation entrée */
.slide-fade-enter-active {
  transition: all 0.4s ease;
}
.slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateY(10px);
}
</style>
