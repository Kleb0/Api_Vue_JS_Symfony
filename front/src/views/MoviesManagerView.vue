<template>
    <div>
      <!-- Gestion des Films -->
      <h1>Gestion des Films</h1>
  
      <form @submit.prevent="addMovie">
        <label for="title">Titre :</label>
        <input type="text" v-model="newMovie.title" required />
  
        <label for="releaseDate">Date de sortie :</label>
        <input type="date" v-model="newMovie.releaseDate" required />
  
        <label for="summary">Résumé :</label>
        <textarea v-model="newMovie.summary" required></textarea>
  
        <label for="director">Réalisateur :</label>
        <input type="text" v-model="newMovie.director" required />
  
        <label for="actors">Acteurs (séparés par des virgules) :</label>
        <input type="text" v-model="newMovie.actors" required />
  
        <!-- Bouton pour afficher la section des catégories -->
        <button type="button" @click="showCategorySelector = !showCategorySelector">
          Ajouter une ou plusieurs catégories au film
        </button>
  
        <!-- Section pour sélectionner et afficher les catégories -->
        <div v-if="showCategorySelector" style="margin-top: 10px;">
          <label for="categories">Catégories :</label>
          <select v-model="selectedCategory" @change="addCategoryToMovie">
            <option v-for="category in categories" :key="category.customId" :value="category.customId">
              {{ category.categoryName }}
            </option>
          </select>
  
          <ul>
            <li v-for="categoryId in newMovie.selectedCategories" :key="categoryId">
              {{ getCategoryName(categoryId) }}
              <button @click="removeCategoryFromMovie(categoryId)">Supprimer</button>
            </li>
          </ul>
        </div>
  
        <label for="image">Image :</label>
        <input type="file" @change="onFileChange" />
        <div v-if="file">
          <h3>Prévisualisation :</h3>
          <img :src="imagePreview" alt="Prévisualisation de l'image" style="max-width: 100px;" />
        </div>
  
        <button type="submit">Ajouter le film</button>
      </form>
  
      <h2>Liste des Films</h2>
      <table border="1">
        <thead>
          <tr>
            <th>ID</th>
            <th>Titre</th>
            <th>Date de sortie</th>
            <th>Résumé</th>
            <th>Réalisateur</th>
            <th>Acteurs</th>
            <th>Catégories</th>
            <th>Image</th>
            <th>Likes</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movie in movies" :key="movie.id">
            <td>{{ movie.customId }}</td>
            <td>{{ movie.title }}</td>
            <td>{{ movie.releaseDate }}</td>
            <td>{{ movie.summary }}</td>
            <td>{{ movie.director }}</td>
            <td>{{ movie.actors.join(', ') }}</td>
            <td>
              <ul>
                <li v-for="category in movie.categories" :key="category">{{ category }}</li>
              </ul>
            </td>
            <td>
                <img 
                  :src="movie.image" alt="Image du film" style="max-width: 100px;" 
                />
              </td>
            <td>{{ movie.likes }}</td>
          </tr>
        </tbody>
      </table>
  
      <!-- Gestion des Catégories -->
      <h1>Gestion des Catégories</h1>
  
      <form @submit.prevent="addCategory">
        <label for="categoryName">Entrez le nom de la nouvelle catégorie :</label>
        <input type="text" v-model="newCategory" id="categoryName" required />
        <button type="submit">Ajouter</button>
      </form>
  
      <h2>Catégories existantes</h2>
      <ul>
        <li v-for="category in categories" :key="category.id">
          <strong>ID:</strong> {{ category.customId }} - <strong>Nom:</strong> {{ category.categoryName }}
          <button @click="editCategory(category)">Modifier</button>
          <button @click="deleteCategory(category.customId)">Supprimer</button>
        </li>
      </ul>
  
      <div v-if="editMode">
        <h3>Modifier la catégorie</h3>
        <input type="text" v-model="editedCategoryName" />
        <button @click="updateCategory">Mettre à jour</button>
      </div>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'MovieManagerView',
    data() {
      return {
        // Gestion des catégories
        newCategory: '',
        categories: [],
        editMode: false,
        editedCategory: null,
        editedCategoryName: '',
  
        // Gestion des films
        newMovie: {
          title: '',
          releaseDate: '',
          summary: '',
          director: '',
          actors: '',
          selectedCategories: [], 
          image: null,
        },
        movies: [],
        file: null,
        showCategorySelector: false, 
        selectedCategory: null, 
      };
    },
    methods: {
      // Gestion des catégories

    async fetchCategories() {
        try {
          const response = await axios.get('http://localhost:8000/api/categories-list');
          this.categories = response.data;
        } catch (error) {
          console.error('Erreur lors du chargement des catégories :', error);
        }
      },

    async addCategory() {
        try {
          await axios.post('http://localhost:8000/api/categories_insertions', {
            categoryName: this.newCategory,
          });
          this.newCategory = '';
          this.fetchCategories();
        } catch (error) {
          console.error('Erreur lors de l\'ajout de la catégorie :', error);
        }
      },

    async deleteCategory(customId) {
        if (confirm('Voulez-vous vraiment supprimer cette catégorie ?')) {
          try {
            await axios.delete(`http://localhost:8000/api/categories_delete/${customId}`);
            this.fetchCategories();
          } catch (error) {
            console.error('Erreur lors de la suppression de la catégorie :', error);
          }
        }
      },
    
    editCategory(category) {
        this.editMode = true;
        this.editedCategory = category;
        this.editedCategoryName = category.categoryName;
      },

    async updateCategory() {
        try {
          await axios.patch(`http://localhost:8000/api/categories_modify/${this.editedCategory.customId}`, {
            categoryName: this.editedCategoryName,
          });
          this.editMode = false;
          this.fetchCategories();
        } catch (error) {
          console.error('Erreur lors de la mise à jour de la catégorie :', error);
        }
      },
  
      // Gestion des films
      async fetchMovies() {
        try {
            const response = await axios.get('http://localhost:8000/api/movies_list');
            this.movies = response.data.map(movie => {
            return {
                ...movie,
                categories: movie.categories.map(catId => this.getCategoryName(catId)),
                file: null,
            };
            });
        } catch (error) {
            console.error('Erreur lors du chargement des films :', error);
        }
    },
      
    async addMovie() {
        if (!this.newMovie.title || !this.newMovie.releaseDate || !this.newMovie.summary || !this.newMovie.director || !this.newMovie.actors) {
            alert('Veuillez remplir tous les champs obligatoires.');
            return;
        }

        const formData = new FormData();
        formData.append('title', this.newMovie.title);
        formData.append('releaseDate', this.newMovie.releaseDate);
        formData.append('summary', this.newMovie.summary);
        formData.append('director', this.newMovie.director);

        // Convertir les acteurs en tableau JSON
        const actorsArray = this.newMovie.actors.split(',').map(actor => actor.trim());
        formData.append('actors', JSON.stringify(actorsArray));

        // Ajouter les catégories (seulement les customId)
        formData.append('categories', JSON.stringify(this.newMovie.selectedCategories));

        // Ajouter l'image si elle est présente
        if (this.file) {
            formData.append('image', this.file);
        }

        try {
            await axios.post('http://localhost:8000/api/movies_insert', formData, {
            headers: { 'Content-Type': 'multipart/form-data',
              'X-Requested-With': 'XMLHttpRequest'
            },
            });
            alert('Film ajouté avec succès !');
            this.newMovie = {
            title: '',
            releaseDate: '',
            summary: '',
            director: '',
            actors: '',
            selectedCategories: [],

            };
            this.file = null;
            console.log(this.newMovie.image);
    
            this.fetchMovies();
        } catch (error) {
            console.error('Erreur lors de l\'ajout du film :', error);
            alert('Erreur lors de l\'ajout du film.');
        }
    },

    addCategoryToMovie() {
        if (this.selectedCategory && !this.newMovie.selectedCategories.includes(this.selectedCategory)) {
          this.newMovie.selectedCategories.push(this.selectedCategory);
        }
    },
    
    removeCategoryFromMovie(categoryId) {
        this.newMovie.selectedCategories = this.newMovie.selectedCategories.filter(id => id !== categoryId);
    },
    
    getCategoryName(categoryId) {
        const category = this.categories.find(cat => cat.customId === categoryId);
        return category ? category.categoryName : 'Inconnu';
    },

    onFileChange(event) {
      this.file = event.target.files[0];
      this.imagePreview = URL.createObjectURL(this.file); 

      const selectedMovie = this.movies.find(movie => movie.id === this.selectedMovieId);
      if (selectedMovie) {
        selectedMovie.file = this.file;
      }
    },
    },

    mounted() {
      this.fetchCategories();
      this.fetchMovies();
    },
  };
  </script>
  
  <style scoped>
  h1, h2 {
    margin-bottom: 10px;
  }
  
  form {
    margin-bottom: 20px;
  }
  
  input, textarea, select {
    margin-bottom: 10px;
    display: block;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
  }
  
  th, td {
    padding: 10px;
    text-align: left;
  }
  
  th {
    background-color: #f4f4f4;
  }
  </style>
  