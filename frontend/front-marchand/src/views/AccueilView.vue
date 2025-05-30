<template>
  <div class="space-y-4">
    <h1 class="text-2xl font-bold text-emerald-600">Bienvenue sur le tableau de bord</h1>
    <p class="text-slate-700">Gérez facilement les demandes d’adhésion des vendeurs et suivez leur statut en temps réel.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
      <div class="bg-white p-4 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-slate-800">Vendeurs en attente</h2>
        <p class="text-2xl font-bold text-emerald-600">12</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-slate-800">Demandes acceptées</h2>
        <p class="text-2xl font-bold text-green-500">8</p>
      </div>
      <div class="bg-white p-4 rounded-xl shadow">
        <h2 class="text-lg font-semibold text-slate-800">Demandes refusées</h2>
        <p class="text-2xl font-bold text-red-500">4</p>
      </div>
    </div>
  </div>
</template>
