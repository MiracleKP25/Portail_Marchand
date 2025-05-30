<template>
  <aside class="w-64 bg-white shadow-md h-full">
    <div class="p-6 border-b border-slate-200">
      <h2 class="text-lg font-bold text-emerald-600">Admin</h2>
    </div>
    <nav class="p-4 space-y-4">
      <router-link to="/accueil" class="block text-slate-700 hover:text-emerald-600 font-medium">Accueil</router-link>
      <router-link to="/vendeurs" class="block text-slate-700 hover:text-emerald-600 font-medium">Vendeurs</router-link>
      <router-link to="/demandes" class="block text-slate-700 hover:text-emerald-600 font-medium">Demandes</router-link>
    </nav>
  </aside>
</template>
