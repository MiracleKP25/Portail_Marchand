<template>
  <!-- Barre latérale fixe avec largeur, fond blanc, ombre et pleine hauteur -->
  <aside class="w-64 bg-white shadow-lg h-screen rounded-tr-2xl rounded-br-2xl">
    <!-- En-tête de la sidebar -->
    <div class="p-6 border-b border-slate-200">
      <h2 class="text-2xl font-bold text-emerald-600">Espace Admin</h2>
    </div>

    <!-- Menu de navigation -->
    <nav class="p-4 space-y-3">
      <!-- Lien vers la page d'accueil admin -->
      <a
        href="#"
        @click.prevent="$emit('navigate', 'accueil')"
        class="block px-4 py-2 rounded-lg text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition"
      >
        🏠 Accueil
      </a>

      <!-- Lien vers la gestion des vendeurs -->
      <a
        href="#"
        @click.prevent="$emit('navigate', 'vendeurs')"
        class="block px-4 py-2 rounded-lg text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition"
      >
        👥 Vendeurs
      </a>

      <!-- Lien vers la gestion des demandes -->
      <a
        href="#"
        @click.prevent="$emit('navigate', 'demandes')"
        class="block px-4 py-2 rounded-lg text-slate-700 font-medium hover:bg-emerald-50 hover:text-emerald-700 transition"
      >
        📥 Demandes
      </a>
    </nav>
  </aside>
</template>

<script setup>
// Le composant est un simple "layout" qui émet des événements vers le parent.
// Ici, on n'utilise pas de script complexe, mais on utilise $emit pour signaler des clics.

// Exemple :
// Lorsque l'utilisateur clique sur "Vendeurs",
// le composant émet : $emit('navigate', 'vendeurs')
// C'est le parent (ex: AdminDashboard.vue) qui captera cet événement pour afficher la bonne vue.
</script>

<style scoped>
/* Vous pouvez ajouter ici des styles personnalisés si besoin */
</style>
