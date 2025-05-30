<script setup>
import SidebarComponent from '../components/SidbarComponent.vue'
import VendorList from '../components/VendorList.vue'




</script>


<template>
  <div class="flex h-screen">
    <!-- Sidebar -->
    <SidebarComponent @navigate="(view) => currentView = view" />

    <!-- Contenu dynamique à droite -->
    <div class="flex-1 p-6 overflow-y-auto bg-slate-50">
      <component :is="{
        'accueil': 'div', // tu peux créer une vue Accueil.vue
        'vendeurs': VendorList,
        'demandes': 'div', // ou plus tard Demandes.vue
      }[currentView]" />
      MainComponet
    </div>
  </div>
</template>


<style scoped>
</style>
