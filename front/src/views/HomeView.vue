<template>
  <div class="home">
    <MainCatalogueView /> <!-- Vérifie que le composant est correctement référencé -->
  </div>
</template>

<script>
import MainCatalogueView from '@/views/MainCatalogueView.vue'; 

export default {
  name: 'HomeView',
  components: {
    MainCatalogueView,
  },
};
</script>

<style scoped>
.home {
  padding: 20px;
  background-color: #e5e5e5;
}
</style>
