import { createRouter, createWebHistory } from 'vue-router'
import AccueilView from '@/views/AccueilView.vue'
import SuivieView from '@/views/SuivieView.vue'
import AdminLogin from '@/views/AdminLogin.vue'
import FormulaireVendeur from '@/components/FormulaireVendeur.vue'
import AdminDashboard from '@/components/AdminDashboard.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    { path: '/', name: 'Accueil', component: AccueilView },
    { path: '/formulaire', name: 'Formulaire', component: FormulaireVendeur },
    { path: '/suivi', name: 'Suivi', component: SuivieView },
    { path: '/admin/login', component: AdminLogin },
    { path: '/admin/dashboard', component: AdminDashboard }
  ],
})

export default router
