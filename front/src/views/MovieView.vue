<template>
  <div v-if="movie">
    <h1>{{ movie.title }}</h1>
    <p><strong>Résumé :</strong> {{ movie.summary }}</p>
    <p><strong>Date de sortie :</strong> {{ movie.releaseDate }}</p>
    <p><strong>Réalisateur :</strong> {{ movie.director }}</p>
    <p><strong>Acteurs :</strong> {{ Array.isArray(movie.actors) ? movie.actors.join(', ') : movie.actors }}</p>
    <p><strong>Catégories :</strong></p>
    <ul>
      <li v-for="category in movie.categories" :key="category.customId">
        {{ category.categoryName }}
      </li>
    </ul>
    <img :src="movie.image" alt="Affiche du film" style="max-width: 200px;" />
  </div>
  <div v-else>
    <p>Chargement du film...</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MovieView',
  data() {
    return {
      movie: null,
    };
  },
  created() {
    const customId = this.$route.params.customId;
    this.fetchMovie(customId);
  },
  methods: {
    async fetchMovie(customId) {
      try {
        const response = await axios.get(`http://localhost:8000/api/movies/${customId}`);
        const movie = response.data;
        movie.actors = Array.isArray(movie.actors) ? movie.actors : []; // Assure que actors est un tableau
        this.movie = movie;
      } catch (error) {
        console.error('Erreur lors du chargement du film :', error);
      }
    },
  },
};
</script>

<style scoped>
h1 {
  margin-bottom: 10px;
}
img {
  margin-top: 10px;
}
</style>
