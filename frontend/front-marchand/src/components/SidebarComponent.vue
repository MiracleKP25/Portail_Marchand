<template>
  <aside class="w-64 bg-white shadow-md h-full">
    <div class="p-6 border-b border-slate-200">
      <h2 class="text-lg font-bold text-emerald-600">Admin</h2>
    </div>
    <nav class="p-4 space-y-4">
      <a
        href="#"
        @click.prevent="$emit('navigate', 'accueil')"
        class="block text-slate-700 hover:text-emerald-600 font-medium"
      >
        Accueil
      </a>
      <a
        href="#"
        @click.prevent="$emit('navigate', 'vendeurs')"
        class="block text-slate-700 hover:text-emerald-600 font-medium"
      >
        Vendeurs
      </a>
      <a
        href="#"
        @click.prevent="$emit('navigate', 'demandes')"
        class="block text-slate-700 hover:text-emerald-600 font-medium"
      >
        Demandes
      </a>
    </nav>
  </aside>
</template>
