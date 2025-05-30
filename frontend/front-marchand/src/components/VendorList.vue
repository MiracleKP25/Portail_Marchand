<script setup>
// Importation des fonctions nécessaires de Vue
import { ref, onMounted, computed } from 'vue'

// Déclaration de la liste des vendeurs (réactive)
const vendors = ref([])

// Statut sélectionné pour le filtrage (ex: "accepté", "rejeté", etc.)
const selectedStatus = ref('')

/**
 * Au montage du composant, on effectue un appel API pour récupérer tous les vendeurs.
 */
onMounted(async () => {
  try {
    // Requête vers l'API pour récupérer les vendeurs
    const res = await fetch('http://localhost:8000/router.php?url=vendeur/allvendors', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
    })

    // Traitement de la réponse JSON
    const result = await res.json()

    // Si l'appel a réussi, on met à jour la liste des vendeurs
    if (result.success) {
      vendors.value = result.data
    } else {
      console.error('Erreur lors de la récupération des vendeurs')
    }
  } catch (error) {
    // Gestion des erreurs en cas d'échec de la requête
    console.error('Erreur API :', error)
  }
})

/**
 * Fonction pour mettre à jour le statut d'un vendeur
 * @param {number} id - L'identifiant du vendeur
 * @param {string} status - Le nouveau statut à attribuer
 */
async function updateStatus(id, status) {
  try {
    // Requête POST vers l'API pour mettre à jour le statut
    const res = await fetch(`http://localhost:8000/router.php?url=vendeur/updatestatus`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, statut: status }) // Envoi de l'ID et du nouveau statut
    })

    // Si la mise à jour a réussi côté serveur
    if (res.ok) {
      // On met à jour localement le vendeur dans la liste
      const index = vendors.value.findIndex(v => v.id === id)
      if (index !== -1) vendors.value[index].statut = status
    }
  } catch (error) {
    // Gestion des erreurs de la requête
    console.error('Erreur lors de la mise à jour du statut', error)
  }
}

/**
 * Liste filtrée des vendeurs selon le statut sélectionné
 * Si aucun statut n’est sélectionné, on retourne toute la liste.
 */
const filteredVendors = computed(() => {
  if (!selectedStatus.value) return vendors.value
  return vendors.value.filter(v => v.statut.toLowerCase() === selectedStatus.value.toLowerCase())
})
</script>


<template>
  <div class="space-y-6">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-2xl font-bold text-emerald-600">📋 Liste des vendeurs</h1>
        <p class="text-slate-600">Gestion et suivi des demandes d'adhésion.</p>
      </div>
      <select
        v-model="selectedStatus"
        class="border border-slate-300 rounded-md px-3 py-2 shadow-sm focus:ring-emerald-500 focus:border-emerald-500 text-sm"
      >
        <option value="">Tous les statuts</option>
        <option value="en_attente">En attente</option>
        <option value="acceptée">Acceptée</option>
        <option value="refusée">Refusée</option>
      </select>
    </div>

    <!-- Tableau des vendeurs -->
    <div class="overflow-auto rounded-lg shadow-md">
      <table class="min-w-full bg-white text-sm text-left border border-slate-200">
        <thead class="bg-emerald-100 text-emerald-800 text-sm">
          <tr>
            <th class="px-4 py-3">#</th>
            <th class="px-4 py-3">Nom complet</th>
            <th class="px-4 py-3">Email</th>
            <th class="px-4 py-3">Téléphone</th>
            <th class="px-4 py-3">Statut</th>
            <th class="px-4 py-3 text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="vendor in filteredVendors"
            :key="vendor.id"
            class="hover:bg-slate-50 transition"
          >
            <td class="px-4 py-3 font-medium text-slate-700">{{ vendor.id }}</td>
            <td class="px-4 py-3">{{ vendor.nom }} {{ vendor.prenom }}</td>
            <td class="px-4 py-3 text-slate-600">{{ vendor.email }}</td>
            <td class="px-4 py-3 text-slate-600">{{ vendor.telephone }}</td>
            <td class="px-4 py-3">
              <span
                class="px-2 py-1 rounded-full text-xs font-semibold"
                :class="{
                  'bg-yellow-100 text-yellow-700': vendor.statut === 'en_attente',
                  'bg-green-100 text-green-700': vendor.statut === 'acceptée',
                  'bg-red-100 text-red-700': vendor.statut === 'refusée',
                }"
              >
                {{ vendor.statut }}
              </span>
            </td>
            <td class="px-4 py-3 text-center">
              <div v-if="vendor.statut === 'en_attente'" class="flex gap-2 justify-center">
                <button
                  @click="updateStatus(vendor.id, 'acceptée')"
                  class="px-3 py-1 text-xs bg-green-600 hover:bg-green-700 text-white rounded transition"
                >
                  Accepter
                </button>
                <button
                  @click="updateStatus(vendor.id, 'refusée')"
                  class="px-3 py-1 text-xs bg-red-600 hover:bg-red-700 text-white rounded transition"
                >
                  Refuser
                </button>
              </div>
              <span v-else class="text-slate-400 text-xs italic">—</span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<style scoped>
</style>
