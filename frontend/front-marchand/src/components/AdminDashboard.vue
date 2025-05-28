<!-- src/views/AdminDashboard.vue -->
<template>
  <div class="min-h-screen bg-emerald-50 p-6">
    <h1 class="text-3xl font-bold text-emerald-700 mb-6">Tableau de bord admin</h1>

    <div class="overflow-x-auto">
      <table class="min-w-full bg-white rounded-xl shadow">
        <thead>
          <tr class="bg-emerald-100 text-emerald-800">
            <th class="px-4 py-2">Nom</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Téléphone</th>
            <th class="px-4 py-2">Statut</th>
            <th class="px-4 py-2">Changer</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="vendeur in vendeurs" :key="vendeur.id" class="text-gray-700">
            <td class="px-4 py-2">{{ vendeur.nom }} {{ vendeur.prenom }}</td>
            <td class="px-4 py-2">{{ vendeur.email }}</td>
            <td class="px-4 py-2">{{ vendeur.telephone }}</td>
            <td class="px-4 py-2">{{ vendeur.statut }}</td>
            <td class="px-4 py-2">
              <select v-model="vendeur.nouveauStatut" @change="changerStatut(vendeur)" class="rounded border-gray-300">
                <option disabled selected>Changer</option>
                <option value="En attente">En attente</option>
                <option value="Acceptée">Acceptée</option>
                <option value="Refusée">Refusée</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const vendeurs = ref([])

const getVendeurs = async () => {
  try {
    const response = await axios.get('http://localhost:8000/admin/vendeurs', { withCredentials: true })
    vendeurs.value = response.data.map(v => ({ ...v, nouveauStatut: v.statut }))
  } catch (err) {
    console.error('Erreur récupération vendeurs :', err)
  }
}

const changerStatut = async (vendeur) => {
  try {
    const form = new FormData()
    form.append('statut', vendeur.nouveauStatut)

    await axios.post(`http://localhost:8000/admin/statut/${vendeur.id}`, form, { withCredentials: true })

    vendeur.statut = vendeur.nouveauStatut
  } catch (err) {
    console.error('Erreur mise à jour statut :', err)
  }
}

onMounted(getVendeurs)
</script>

