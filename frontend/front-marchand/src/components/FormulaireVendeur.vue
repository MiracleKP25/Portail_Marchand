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
  <div class="max-w-3xl mx-auto mt-10 p-8 bg-white shadow-2xl rounded-3xl transition-all duration-500 ease-in-out animate-fade-up">
    <h2 class="text-4xl font-extrabold text-emerald-700 mb-8 tracking-tight text-center">
      🛍️ Adhérez comme vendeur
    </h2>

    <!-- Formulaire -->
    <form @submit.prevent="preview = true" v-if="!preview" class="space-y-6 animate-scale-in">
      <!-- Nom et prénom -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="label">👤 Nom</label>
          <input v-model="form.nom" type="text" required class="input" />
        </div>
        <div>
          <label class="label">🧍‍♂️ Prénom</label>
          <input v-model="form.prenom" type="text" required class="input" />
        </div>
      </div>

      <!-- Produits -->
      <div>
        <label class="label">📦 Produits vendus</label>
        <textarea v-model="form.produits" required class="input h-24"></textarea>
      </div>

      <!-- Déjà vendu ailleurs -->
      <div>
        <label class="label">🛒 Avez-vous déjà vendu ailleurs ?</label>
        <select v-model="form.dejaVendu" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
        <input v-if="form.dejaVendu === 'Oui'" v-model="form.lieuVente" placeholder="Précisez où" class="input mt-2" />
      </div>

      <!-- Actif ailleurs -->
      <div>
        <label class="label">🌍 Êtes-vous actif ailleurs ?</label>
        <select v-model="form.actifAilleurs" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
      </div>

      <!-- Email & téléphone -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="label">📧 Email</label>
          <input v-model="form.email" type="email" required class="input" />
        </div>
        <div>
          <label class="label">📞 Téléphone</label>
          <input v-model="form.telephone" type="tel" required class="input" />
        </div>
      </div>

      <!-- Valeur -->
      <div>
        <label class="label">💶 Valeur unitaire (€)</label>
        <input v-model="form.valeur" type="number" required class="input" />
      </div>

      <!-- Bouton Prévisualisation -->
      <button type="submit" class="btn-green w-full mt-4 hover:shadow-lg active:scale-95 transition">
        🔍 Prévisualiser
      </button>
    </form>

    <!-- Prévisualisation -->
    <transition name="fade">
      <div v-if="preview" class="space-y-4 animate-fade-up">
        <h3 class="text-2xl font-semibold text-emerald-800 mb-4">🧐 Vérifiez vos informations</h3>
        <ul class="text-gray-700 space-y-2 pl-4">
          <li><strong>Nom :</strong> {{ form.nom }}</li>
          <li><strong>Prénom :</strong> {{ form.prenom }}</li>
          <li><strong>Produits :</strong> {{ form.produits }}</li>
          <li><strong>Déjà vendu ailleurs :</strong> {{ form.dejaVendu }} <span v-if="form.lieuVente">({{ form.lieuVente }})</span></li>
          <li><strong>Actif ailleurs :</strong> {{ form.actifAilleurs }}</li>
          <li><strong>Email :</strong> {{ form.email }}</li>
          <li><strong>Téléphone :</strong> {{ form.telephone }}</li>
          <li><strong>Valeur :</strong> {{ form.valeur }} €</li>
        </ul>

        <div class="flex gap-4 mt-6 justify-center">
          <button @click="preview = false" class="btn-outline hover:shadow-md">✏️ Modifier</button>
          <button @click="soumettre" class="btn-green hover:shadow-lg active:scale-95 transition">✅ Soumettre</button>
        </div>
      </div>
    </transition>

    <!-- Message de confirmation -->
    <transition name="fade">
      <div v-if="submitted" class="mt-6 p-5 rounded-xl bg-emerald-100 text-emerald-900 border border-emerald-300 animate-fade-up text-center text-lg font-medium">
        🎉 Merci ! Votre demande a bien été envoyée.
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
