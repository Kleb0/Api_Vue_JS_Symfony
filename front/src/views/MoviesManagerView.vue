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
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="movie in movies" :key="movie.customId || movie.id">
            <td>{{ movie.customId || 'Inconnu' }}</td>
            <td>
              <span v-if="!editMode[movie.customId]">{{ movie.title }}</span>
              <input v-else type="text" v-model="editedMovie.title" />
            </td>

            <td>
                <span v-if="!editMode[movie.customId]">{{ movie.releaseDate }}</span>
                <input v-else type="date" v-model="editedMovie.releaseDate" />
            </td>

            <td>
              <span v-if="!editMode[movie.customId]">{{ movie.summary }}</span>
              <textarea v-else v-model="editedMovie.summary"></textarea>
            </td>
          
            <td>
              <span v-if="!editMode[movie.customId]">{{ movie.director }}</span>
              <input v-else type="text" v-model="editedMovie.director" />
            </td>

            <td>
              <span v-if="!editMode[movie.customId]">{{ movie.actors.join(', ') }}</span>
              <input v-else type="text" v-model="editedMovie.actors" />
            </td>
            
            <td>
              <ul>
                <li v-for="category in movie.categories" :key="category.customId">
                  <span v-if="!editMode[movie.customId]">{{ category.categoryName }}</span>
                  <div v-else>
                    {{ category.categoryName }}
                    <button @click="removeCategoryFromEditedMovie(category.customId)">Supprimer</button>
                  </div>
                </li>
              </ul>
            </td>

            <td>
              <div v-if="!editMode[movie.customId]">
                <img :src="movie.image" alt="Image du film" style="max-width: 100px;" />
              </div>          
            </td>


            <td>{{ movie.likes }}</td>
            <td>
              <button v-if="!editMode[movie.customId]" @click="enableEditMode(movie)">Modifier</button>
              <button v-else @click="saveMovieChanges(movie)">Enregistrer</button>
            </td>
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

        editedMovie: {
          title:'',
          releaseDate: '',
          summary: '',
          director: '',
          actors: '',
          selectedCategories: [],
        },
        
  
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
        console.log('Films récupérés :', response.data); 

        this.movies = response.data.map(movie => ({
        ...movie,
        categories: movie.categories, 
        file: null,
      }));
      } catch (error) {
        console.error('Erreur lors du chargement des films :', error);
      }
    },
    enableEditMode(movie) {
      if (movie.customId)
      {
        this.editMode = {
          ...this.editMode, 
          [movie.customId]: true
        };
        this.editedMovie = { 
          ...movie,
          actors: Array.isArray(movie.actors) ? movie.actors.join(', ') : movie.actors,
          selectedCategories: movie.categories.map(cat => cat.customId),
          image: movie.image,
         };
      } 
      else 
      {
        console.error('Le film n\'a pas de customId défini', movie);
      }
    },

    async saveMovieChanges(movie) {
      try {

        await axios.patch(`http://localhost:8000/api/movies_update/${movie.customId}`, {
          title: this.editedMovie.title,
          releaseDate: this.editedMovie.releaseDate,
          summary: this.editedMovie.summary,
          director: this.editedMovie.director,
          actors: this.editedMovie.actors.split(',').map(actor => actor.trim()),
          categories: this.editedMovie.selectedCategories,
        });

        movie.title = this.editedMovie.title;
        movie.releaseDate = this.editedMovie.releaseDate;
        movie.summary = this.editedMovie.summary;
        movie.director = this.editedMovie.director;
        movie.actors = this.editedMovie.actors.split(',').map(actor => actor.trim());

        movie.categories = this.categories.filter(cat => this.editedMovie.selectedCategories.includes(cat.customId));
        movie.image = this.editedMovie.image;

        this.editMode = { ...this.editMode, [movie.customId]: false };
        this.editedMovie = { 
          title: '',
          releaseDate: '',
          summary: '',
          director: '',
          actors: '',
          selectedCategories: [], 
        };
      } catch (error) {
        console.error('Erreur lors de la modification :', error);
      }
    },

    removeCategoryFromEditedMovie(categoryId) {
    const categoryIndex = this.editedMovie.categories.findIndex(cat => cat.customId === categoryId);
      if (categoryIndex !== -1) {

        const removedCategory = this.editedMovie.categories.splice(categoryIndex, 1)[0];
        const movieTitle = this.editedMovie.title || 'inconnu';

        alert(`Avant suppression: ${JSON.stringify(this.editedMovie.selectedCategories)}`);
        this.editedMovie.selectedCategories = this.editedMovie.selectedCategories.filter(catId => catId !== removedCategory.customId);
        alert(`Après suppression: ${JSON.stringify(this.editedMovie.selectedCategories)}`);

        alert(`Vous avez supprimé la catégorie "${removedCategory.categoryName}" du film "${movieTitle}" en front.`);
      } else {
        alert(`La catégorie avec l'ID ${categoryId} n'a pas été trouvée.`);
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
  