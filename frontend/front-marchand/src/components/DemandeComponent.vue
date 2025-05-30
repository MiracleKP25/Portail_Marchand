<template>
  <div class="space-y-4">
    <h1 class="text-2xl font-bold text-emerald-600">Demandes d’adhésion</h1>
    <p class="text-slate-700">Liste des nouveaux vendeurs en attente de validation.</p>

    <!-- Exemple de table (à remplacer par données dynamiques) -->
    <div class="overflow-auto rounded-lg shadow bg-white mt-4">
      <table class="min-w-full divide-y divide-slate-200">
        <thead class="bg-slate-100">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Nom</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Email</th>
            <th class="px-6 py-3 text-left text-sm font-semibold text-slate-700">Statut</th>
            <th class="px-6 py-3 text-right text-sm font-semibold text-slate-700">Actions</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
          <tr>
            <td class="px-6 py-4 whitespace-nowrap text-slate-800">Sophie N.</td>
            <td class="px-6 py-4 whitespace-nowrap text-slate-600">sophie@email.com</td>
            <td class="px-6 py-4 whitespace-nowrap">
              <span class="inline-block px-2 py-1 text-xs bg-yellow-100 text-yellow-700 rounded">En attente</span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
              <button class="px-3 py-1 text-sm text-white bg-green-500 hover:bg-green-600 rounded">Accepter</button>
              <button class="px-3 py-1 text-sm text-white bg-red-500 hover:bg-red-600 rounded">Refuser</button>
            </td>
          </tr>
          <!-- ... autres lignes -->
        </tbody>
      </table>
    </div>
  </div>
</template>
