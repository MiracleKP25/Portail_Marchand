<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

import SidebarComponent from '../components/SidebarComponent.vue'
import VendorList from '../components/VendorList.vue'
import AccueilView from '../views/AccueilView.vue'
import DemandeComponent from '../components/DemandeComponent.vue'

const currentView = ref('accueil') // vue par défaut

const router = useRouter()
const logout = () => {
  localStorage.removeItem('adminConnected')
  router.push('/admin/login')
}
</script>

<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <SidebarComponent @navigate="(view) => currentView = view" />

    <!-- Contenu principal -->
    <div class="flex-1 flex flex-col">
      <!-- Barre supérieure avec titre et bouton de déconnexion -->
      <div class="flex justify-between items-center p-6 bg-white border-b border-slate-200 shadow">
        <h1 class="text-2xl font-semibold text-emerald-600 font-serif">Tableau de bord</h1>
        <button
          @click="logout"
          class="bg-emerald-500 text-white px-4 py-2 rounded hover:bg-emerald-600 transition"
        >
          Déconnexion
        </button>
      </div>

      <!-- Contenu dynamique -->
      <div class="flex-1 overflow-y-auto p-6 bg-slate-50">
        <component :is="{
          'accueil': AccueilView,
          'vendeurs': VendorList,
          'demandes': DemandeComponent
        }[currentView]" />
      </div>
    </div>
  </div>
</template>
