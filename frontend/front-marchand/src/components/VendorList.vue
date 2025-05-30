<script setup>
import { ref, onMounted, computed} from 'vue'

const vendors = ref([])
const selectedStatus = ref('')

// Chargement des vendeurs à l'initialisation
onMounted(async () => {
  try {
    const res = await fetch('http://localhost:8000/router.php?url=vendeur/allvendors', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
    })

    const result = await res.json()

    // ✅ On extrait uniquement result.data (car Postman retourne { success, data })
    if (result.success) {
      vendors.value = result.data
    } else {
      console.error('Erreur lors de la récupération des vendeurs')
    }
  } catch (error) {
    console.error('Erreur API :', error)
  }
})

// Mise à jour du statut
async function updateStatus(id, status) {
  try {
    const res = await fetch(`http://localhost:8000/router.php?url=vendeur/updatestatus`, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ id, statut: status })
    })

    if (res.ok) {
      // Met à jour localement sans recharger la page
      const index = vendors.value.findIndex(v => v.id === id)
      if (index !== -1) {
        vendors.value[index].statut = status
      }
    }
  } catch (error) {
    console.error('Erreur lors de la mise à jour du statut', error)
  }
}

// Filtrage par statut sélectionné
const filteredVendors = computed(() => {
  if (!selectedStatus.value) return vendors.value
  return vendors.value.filter(v => v.statut.toLowerCase() === selectedStatus.value.toLowerCase())
})
</script>

<template>
  <div class="space-y-6">
    <h1 class="text-2xl font-bold text-emerald-600">Liste des vendeurs</h1>
    <p class="text-slate-700">Tous les vendeurs enregistrés sur la plateforme.</p>

    <!-- Filtre par statut -->
    <select v-model="selectedStatus" class="border p-2 rounded shadow mt-2">
      <option value="">Tous les statuts</option>
      <option value="en_attente">En attente</option>
      <option value="acceptée">Acceptée</option>
      <option value="refusée">Refusée</option>
    </select>

    <!-- Tableau -->
    <table class="w-full bg-white shadow rounded-lg mt-4">
      <thead class="bg-emerald-100 text-emerald-800">
        <tr>
          <th class="p-3 text-left">Nom</th>
          <th class="p-3">Email</th>
          <th class="p-3">Téléphone</th>
          <th class="p-3">Statut</th>
          <th class="p-3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr
          v-for="vendor in filteredVendors"
          :key="vendor.id"
          class="border-t hover:bg-slate-50"
        >
          <td class="p-3">{{ vendor.nom }} {{ vendor.prenom }}</td>
          <td class="p-3">{{ vendor.email }}</td>
          <td class="p-3">{{ vendor.telephone }}</td>
          <td class="p-3 capitalize">
            <span
              :class="{
                'text-yellow-500': vendor.statut === 'en_attente',
                'text-green-600': vendor.statut === 'acceptée',
                'text-red-600': vendor.statut === 'refusée',
              }"
            >
              {{ vendor.statut }}
            </span>
          </td>
          <td class="p-3 flex gap-2">
            <button
              v-if="vendor.statut === 'en_attente'"
              @click="updateStatus(vendor.id, 'acceptée')"
              class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600"
            >
              Accepter
            </button>
            <button
              v-if="vendor.statut === 'en_attente'"
              @click="updateStatus(vendor.id, 'refusée')"
              class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600"
            >
              Refuser
            </button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
</style>
