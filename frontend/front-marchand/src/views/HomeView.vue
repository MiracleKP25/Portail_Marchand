<template>
  <div class="min-h-screen bg-emerald-50 flex flex-col items-center justify-center px-4 py-12 animate-fade-in">
    <h1 class="text-4xl font-extrabold text-emerald-700 mb-10 tracking-wide">Bienvenue sur le Portail Marchand</h1>

    <div class="max-w-5xl w-full grid grid-cols-1 md:grid-cols-2 gap-8">

      <!-- Carte Vendeur -->
      <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-emerald-600">Espace Vendeur</h2>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M16 7a4 4 0 01-8 0m8 0a4 4 0 01-8 0m8 0V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m0 0v2a4 4 0 004 4h0a4 4 0 004-4V7z" />
          </svg>
        </div>
        <p class="text-slate-600 mb-6">
          Rejoignez notre marché local et devenez vendeur dès aujourd’hui.
        </p>
        <router-link
          to="/vendeur/accueil"
          class="btn-green"
        >
          Espace Vendeur
        </router-link>
      </div>

      <!-- Carte Admin -->
      <div class="bg-white rounded-2xl shadow-xl p-8 hover:shadow-2xl hover:scale-[1.02] transition-all duration-300">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-slate-800">Espace Admin</h2>
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 11c0-1.1-.9-2-2-2s-2 .9-2 2m4 0c0 1.1.9 2 2 2s2-.9 2-2m-6 4h6m2 0a2 2 0 00-2-2H6a2 2 0 00-2 2m14 0v4H4v-4" />
          </svg>
        </div>
        <p class="text-slate-600 mb-6">
          Connectez-vous à l’espace administrateur pour gérer les inscriptions.
        </p>
        <router-link
          to="/admin/login"
          class="btn-outline"
        >
          Connexion admin
        </router-link>
      </div>

    </div>
  </div>
</template>
