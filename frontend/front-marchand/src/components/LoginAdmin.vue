<template>
  <div class="min-h-screen flex items-center justify-center bg-emerald-100">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md animate-fade-in">
      <h2 class="text-3xl font-bold text-emerald-700 mb-6 text-center">Connexion Admin</h2>

      <form @submit.prevent="handleLogin" class="space-y-4">
        <input
          v-model="email"
          type="email"
          placeholder="Adresse e-mail"
          class="w-full p-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
          required
        />

        <input
          v-model="password"
          type="password"
          placeholder="Mot de passe"
          class="w-full p-3 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500"
          required
        />

        <button
          type="submit"
          class="w-full bg-emerald-600 text-white p-3 rounded-lg font-semibold hover:bg-emerald-700 transition flex items-center justify-center gap-2"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 12h14M12 5l7 7-7 7" />
          </svg>
          Se connecter
        </button>

        <p v-if="errorMessage" class="text-red-600 text-center font-medium mt-2">
          {{ errorMessage }}
        </p>
      </form>
    </div>
  </div>
</template>

<script setup>
// Import des outils Vue nécessaires
import { ref } from 'vue'
import { useRouter } from 'vue-router'

// Déclaration des variables réactives
const email = ref('')         // Stocke l'email saisi par l'utilisateur
const password = ref('')      // Stocke le mot de passe saisi
const errorMessage = ref('')  // Message d'erreur à afficher si la connexion échoue
const router = useRouter()    // Accès au routeur pour rediriger après connexion

// Fonction de gestion de la soumission du formulaire
const handleLogin = async () => {
  errorMessage.value = '' // Réinitialiser le message d'erreur

  try {
    // Envoi de la requête POST au backend pour tenter une connexion
    const response = await fetch('http://localhost:8000/router.php?url=admin/login', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        email: email.value,
        password: password.value
      })
    })

    const result = await response.json() // Transformation de la réponse en JSON

    // Vérification du résultat de la connexion
    if (result.success) {
      localStorage.setItem('adminConnected', 'true') // Enregistrer la session localement
      router.push('/admin/dashboard') // Rediriger vers le dashboard
    } else {
      errorMessage.value = result.message // Afficher le message d'erreur retourné
    }
  } catch (err) {
    // Gérer les erreurs réseau ou autres
    errorMessage.value = "Impossible de se connecter au serveur. Veuillez réessayer."
    console.error(err)
  }
}
</script>

<style scoped>
/* Animation légère au chargement */
@keyframes fadeIn {
  from {
    opacity: 0;
    transform: translateY(12px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

.animate-fade-in {
  animation: fadeIn 0.5s ease-out both;
}
</style>
