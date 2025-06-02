<template>
  <div class="min-h-screen bg-emerald-50 flex items-center justify-center px-4">
    <div class="bg-white shadow-2xl rounded-3xl p-10 max-w-3xl w-full text-center space-y-8 animate-fade-in">
      <!-- Titre principal -->
      <h1 class="text-3xl font-bold text-emerald-700">Bienvenue dans l'espace vendeur</h1>
      <p class="text-gray-600 text-lg">Rejoignez notre marché ou suivez l’évolution de votre demande.</p>

      <!-- Illustration -->
      <img
        src="https://cdn-icons-png.flaticon.com/512/3595/3595455.png"
        alt="Vendor Illustration"
        class="mx-auto w-32 h-32"
      />

      <!-- Boutons d'action -->
      <div class="flex flex-col md:flex-row justify-center gap-6 mt-6">
        <router-link
          to="/formulaire"
          class="bg-emerald-600 text-white px-6 py-3 rounded-xl text-lg font-semibold shadow hover:bg-emerald-700 transition"
        >
          Formulaire d'adhésion
        </router-link>
        <router-link
          to="/suivi"
          class="bg-white border border-emerald-600 text-emerald-700 px-6 py-3 rounded-xl text-lg font-semibold shadow hover:bg-emerald-50 transition"
        >
          Suivi de la demande
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>

</script>

<style scoped>
/* Animation légère d’entrée */
@keyframes fade-in {
  from {
    opacity: 0;
    transform: translateY(20px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}
.animate-fade-in {
  animation: fade-in 0.8s ease-out;
}
</style>
