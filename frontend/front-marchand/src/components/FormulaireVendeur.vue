<script setup>
import { ref } from 'vue'
import NavComponent from './NavComponent.vue'

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

const preview = ref(false)
const submitted = ref(false)

const soumettre = async () => {
  try {
    form.value.dejaVendu = form.value.dejaVendu == 'Oui' ? 1 : 0;
    form.value.actifAilleurs = form.value.actifAilleurs == 'Oui' ? 1 : 0;

    const response = await fetch("http://localhost:8000/router.php?url=vendeur/store", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
        "Accept": "application/json"
      },
      body: JSON.stringify(form.value)
    });


    if (!response.ok) {
      throw new Error(`Erreur serveur : ${response.statusText}`);
    }

    const result = await response.json();
    console.log("Réponse serveur :", result);

    submitted.value = true;
    preview.value = false;

    form.value = {
      nom: '',
      prenom: '',
      produits: '',
      dejaVendu: '',
      lieuVente: '',
      actifAilleurs: '',
      email: '',
      telephone: '',
      valeur: '',
    };

  } catch (error) {
    alert("Erreur lors de l'envoi du formulaire : " + error.message);
    console.log(error);
  }
}



</script>

<template>
<NavComponent/>
  <div class="max-w-2xl mx-auto mt-10 p-6 bg-white shadow-lg rounded-2xl">
    <h2 class="text-2xl font-semibold text-emerald-700 mb-6">Formulaire d’adhésion vendeur</h2>

    <form @submit.prevent="preview = true" v-if="!preview" class="space-y-4">
      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Nom</label>
          <input v-model="form.nom" type="text" required class="input" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Prénom</label>
          <input v-model="form.prenom" type="text" required class="input" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Produits vendus</label>
        <textarea v-model="form.produits" required class="input"></textarea>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">A-t-il déjà vendu ailleurs ?</label>
        <select v-model="form.dejaVendu" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
        <input v-if="form.dejaVendu === 'Oui'" v-model="form.lieuVente" placeholder="Précisez où" class="input mt-2" />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Est-il toujours actif ailleurs ?</label>
        <select v-model="form.actifAilleurs" class="input" required>
          <option disabled value="">Sélectionner</option>
          <option>Oui</option>
          <option>Non</option>
        </select>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700">Adresse email</label>
          <input v-model="form.email" type="email" required class="input" />
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700">Numéro de téléphone</label>
          <input v-model="form.telephone" type="tel" required class="input" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700">Valeur unitaire de ses articles (en €)</label>
        <input v-model="form.valeur" type="number" required class="input" />
      </div>

      <button type="submit" class="btn-green mt-4 w-full">Prévisualiser</button>
    </form>

    <!-- Étape de prévisualisation -->
    <div v-if="preview" class="space-y-4">
      <h3 class="text-xl font-semibold text-emerald-700 mb-2">Vérifiez vos informations</h3>
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

    <div v-if="submitted" class="mt-6 p-4 rounded-lg bg-emerald-100 text-emerald-900 border border-emerald-300">
      🎉 Votre demande a été envoyée avec succès !
    </div>
  </div>
</template>


<style scoped>

</style>
