<template>
  <div class="main-catalog">
    <h1>Catalogue de Films</h1>

    <!-- Filtre par catégorie -->
    <div class="filter-section">
      <label for="categoryFilter">Filtrer par catégorie :</label>
      <select v-model="selectedCategory" @change="filterMovies">
        <option value="">Toutes les catégories</option>
        <option 
          v-for="category in categories" 
          :key="category.customId" 
          :value="category.customId"
        >
          {{ category.categoryName }}
        </option>
      </select>
    </div>

    <div class="carousel-wrapper">
      <!-- Flèche gauche -->
      <button 
        class="carousel-arrow left-arrow" 
        @click="scrollLeft" 
        :disabled="startIndex === 0"
      >
        &lt;
      </button>

      <!-- Liste des films -->
      <div class="carousel" ref="carousel">
        <div 
          class="card movie-card" 
          v-for="movie in visibleMovies" 
          :key="movie.customId"
        >
          <img 
            :src="movie.image" 
            class="card-img-top" 
            :alt="movie.title" 
          />
          <div class="card-body text-center">
            <h5 class="card-title">{{ movie.title }}</h5>
            <p class="card-text text-truncate" style="max-height: 4rem; overflow: hidden;">
              {{ movie.summary }}
            </p>
            <button 
              class="btn btn-primary mt-auto" 
              @click="viewMovie(movie.customId)"
            >
              Voir le Film
            </button>
          </div>
        </div>
      </div>

      <!-- Flèche droite -->
      <button 
        class="carousel-arrow right-arrow" 
        @click="scrollRight" 
        :disabled="startIndex + 5 >= filteredMovies.length"
      >
        &gt;
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'MainCatalogView',
  data() {
    return {
      movies: [], // Tous les films
      filteredMovies: [], // Films filtrés selon la catégorie
      categories: [], // Liste des catégories
      selectedCategory: '', // Catégorie sélectionnée
      startIndex: 0, // Index de début pour les films visibles
    };
  },
  computed: {
    visibleMovies() {
      // Retourne uniquement les 5 films visibles
      return this.filteredMovies.slice(this.startIndex, this.startIndex + 5);
    },
  },
  methods: {
    async fetchMovies() {
      try {
        const response = await axios.get('http://localhost:8000/api/movies_list');
        this.movies = response.data;
        this.filteredMovies = [...this.movies]; // Par défaut, tous les films sont affichés
      } catch (error) {
        console.error('Erreur lors du chargement des films :', error);
      }
    },
    async fetchCategories() {
      try {
        const response = await axios.get('http://localhost:8000/api/categories-list');
        this.categories = response.data;
      } catch (error) {
        console.error('Erreur lors du chargement des catégories :', error);
      }
    },
    filterMovies() {
      if (this.selectedCategory) {
        // Filtrer les films selon la catégorie sélectionnée
        this.filteredMovies = this.movies.filter(movie =>
          movie.categories.some(cat => cat.customId === this.selectedCategory)
        );
      } else {
        // Afficher tous les films si aucune catégorie n'est sélectionnée
        this.filteredMovies = [...this.movies];
      }
      this.startIndex = 0; // Réinitialiser l'index de départ
    },
    viewMovie(customId) {
      this.$router.push({ name: 'movie', params: { customId } });
    },
    scrollLeft() {
      if (this.startIndex > 0) {
        this.startIndex -= 1;
      }
    },
    scrollRight() {
      if (this.startIndex + 5 < this.filteredMovies.length) {
        this.startIndex += 1;
      }
    },
  },
  mounted() {
    this.fetchMovies();
    this.fetchCategories();
  },
};
</script>

<style scoped>
.main-catalog {
  padding: 10px;
  text-align: center;
  background-color: #f8f9fa;
  margin-bottom: 20px;
}

.filter-section {
  margin-bottom: 20px;
}

.carousel-wrapper {
  position: relative;
  overflow: hidden;
  width: 100%;
}

.carousel {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.movie-card {
  flex: 0 0 200px; 
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease-in-out;
}

.movie-card:hover {
  transform: scale(1.05);
}

.card-img-top {
  max-height: 150px;
  object-fit: cover;
}

.card-body {
  padding: 10px;
  text-align: center;
}

.carousel-arrow {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  background-color: rgba(0, 0, 0, 0.5);
  color: white;
  border: none;
  padding: 10px;
  cursor: pointer;
  z-index: 1;
  font-size: 1.5rem;
}

.left-arrow {
  left: 0;
}

.right-arrow {
  right: 0;
}

.carousel-arrow:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}
</style>
