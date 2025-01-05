<template>
    <div>
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
      newCategory: '',
      categories: [],
      editMode: false,
      editedCategory: null,
      editedCategoryName: '',
    };
  },
  methods: {
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
  },
  mounted() {
    this.fetchCategories();
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
  
  input {
    margin-right: 10px;
  }
  </style>
  