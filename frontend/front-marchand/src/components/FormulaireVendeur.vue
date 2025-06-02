<script setup>
import { ref } from 'vue'

// Référence du formulaire (reactive)
const form = ref({
  nom: '',
  prenom: '',
  produits: '',
  dejaVendu: '',
  lieuVente: 'Non défini',
  actifAilleurs: '',
  email: '',
  telephone: '',
  valeur: '',
})

// État pour gérer la prévisualisation et la soumission
const preview = ref(false)
const submitted = ref(false)

// Fonction appelée lors du clic sur "Soumettre"
const soumettre = async () => {
  try {
    // Conversion Oui/Non en booléens pour la base
    form.value.dejaVendu = form.value.dejaVendu === 'Oui' ? 1 : 0;
    form.value.actifAilleurs = form.value.actifAilleurs === 'Oui' ? 1 : 0;

    // Envoi vers backend
    const response = await fetch("http://localhost:8000/router.php?url=vendeur/store", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify(form.value)
    });

    // Vérification réponse backend
    if (!response.ok) throw new Error(`Erreur serveur : ${response.statusText}`);

    const result = await response.json();
    console.log("Réponse serveur :", result);

    submitted.value = true;
    preview.value = false;

    // Réinitialisation du formulaire
    form.value = {
      nom: '',
      prenom: '',
      produits: '',
      dejaVendu: '',
      lieuVente: 'Non défini',
      actifAilleurs: '',
      email: '',
      telephone: '',
      valeur: '',
    };

  } catch (error) {
    alert("Erreur lors de l'envoi : " + error.message);
    console.error(error);
  }
}
</script>


<template>
  <div class="max-w-3xl mx-auto mt-10 p-6 bg-white shadow-xl rounded-2xl transition-all duration-500 ease-in-out animate-fade-in">
    <h2 class="text-3xl font-bold text-emerald-700 mb-6 tracking-wide">🛒 Formulaire d’adhésion vendeur</h2>

    <!-- Formulaire -->
    <form @submit.prevent="preview = true" v-if="!preview" class="space-y-6 animate-fade-in">
      <!-- Nom et prénom -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Nom</label>
          <input v-model="form.nom" type="text" required class="input" />
        </div>
        <div>
          <label class="label">Prénom</label>
          <input v-model="form.prenom" type="text" required class="input" />
        </div>
      </div>

      <!-- Produits -->
      <div>
        <label class="label">Produits vendus</label>
        <textarea v-model="form.produits" required class="input h-24"></textarea>
      </div>

      <!-- Déjà vendu ailleurs -->
      <div>
        <label class="label">A-t-il déjà vendu ailleurs ?</label>
        <select v-model="form.dejaVendu" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
        <input v-if="form.dejaVendu === 'Oui'" v-model="form.lieuVente" placeholder="Précisez où" class="input mt-2" />
      </div>

      <!-- Actif ailleurs -->
      <div>
        <label class="label">Est-il toujours actif ailleurs ?</label>
        <select v-model="form.actifAilleurs" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
      </div>

      <!-- Email & téléphone -->
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="label">Email</label>
          <input v-model="form.email" type="email" required class="input" />
        </div>
        <div>
          <label class="label">Téléphone</label>
          <input v-model="form.telephone" type="tel" required class="input" />
        </div>
      </div>

      <!-- Valeur -->
      <div>
        <label class="label">Valeur unitaire des articles (€)</label>
        <input v-model="form.valeur" type="number" required class="input" />
      </div>

      <!-- Bouton Prévisualisation -->
      <button type="submit" class="btn-green w-full mt-4 hover:scale-105 transition">
        Prévisualiser
      </button>
    </form>

    <!-- Prévisualisation -->
    <transition name="fade">
      <div v-if="preview" class="space-y-4">
        <h3 class="text-xl font-semibold text-emerald-800">🧐 Vérifiez vos informations</h3>
        <ul class="text-gray-700 space-y-1">
          <li><strong>Nom :</strong> {{ form.nom }}</li>
          <li><strong>Prénom :</strong> {{ form.prenom }}</li>
          <li><strong>Produits vendus :</strong> {{ form.produits }}</li>
          <li><strong>Déjà vendu ailleurs :</strong> {{ form.dejaVendu }} <span v-if="form.lieuVente">({{ form.lieuVente }})</span></li>
          <li><strong>Actif ailleurs :</strong> {{ form.actifAilleurs }}</li>
          <li><strong>Email :</strong> {{ form.email }}</li>
          <li><strong>Téléphone :</strong> {{ form.telephone }}</li>
          <li><strong>Valeur unitaire :</strong> {{ form.valeur }} €</li>
        </ul>

        <div class="flex gap-4 mt-6">
          <button @click="preview = false" class="btn-outline">Modifier</button>
          <button @click="soumettre" class="btn-green">Soumettre</button>
        </div>
      </div>
    </transition>

    <!-- Message de confirmation -->
    <transition name="fade">
      <div v-if="submitted" class="mt-6 p-4 rounded-lg bg-emerald-100 text-emerald-900 border border-emerald-300">
        🎉 Votre demande a été envoyée avec succès !
      </div>
    </transition>
  </div>
</template>



<style scoped>


.animate-fade-in {
  animation: fadeIn 0.6s ease-out both;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

.animate-fade-in {
  animation: fadeIn 0.6s ease-out both;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}
</style>
