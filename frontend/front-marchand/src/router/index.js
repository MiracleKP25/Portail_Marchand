import { createRouter, createWebHistory } from 'vue-router'
import AccueilView from '@/views/AccueilView.vue'
import SuivieView from '@/views/SuivieView.vue'
import FormulaireVendeur from '@/components/FormulaireVendeur.vue'
import LoginAdmin from '@/components/LoginAdmin.vue'
import DashboardAdmin from '@/views/DashboardAdmin.vue'
import VendorList from '@/components/VendorList.vue'
import DemandeComponent from '@/components/DemandeComponent.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/vendeur', name: 'Accueil', component: AccueilView },
    { path: '/formulaire', name: 'Formulaire', component: FormulaireVendeur },
    { path: '/suivi', name: 'Suivi', component: SuivieView },


    { path: '/', redirect: '/admin/login' },
    { path: '/admin/login', component: LoginAdmin },
    {
      path: '/admin/dashboard',
      component: DashboardAdmin,
      meta: { requiresAuth: true } // ✅ Protection activée
    },

    { path: '/vendeurs', name: 'Vendeurs', component: VendorList },
    { path: '/demandes', name: 'Demandes', component: DemandeComponent }

  ],
})

// ✅ Garde globale de navigation
router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('adminConnected') === 'true'

  if (to.meta.requiresAuth && !isLoggedIn) {
    next('/admin/login') // Redirige si non connecté
  } else {
    next() // Autorise sinon
  }
})

export default router
