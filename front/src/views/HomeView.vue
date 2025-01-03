<template>
  <div class="home">
    <img alt="Vue logo" src="../assets/logo.png">
    <HelloWorld msg="Welcome to Your Vue.js App"/>

    <!-- <p>Test de connexion avec l'API</p> -->

    <!-- <h1>Liste des personnes</h1> -->
    <!-- <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Prénom</th>
          <th>Nom</th>
        </tr>
      </thead>
      <tbody>
        <tr v-if="persons.length === 0">
          <td colspan="3">Aucune donnée trouvée.</td>
        </tr>
        <tr v-else v-for="person in persons" :key="person.id">
          <td>{{ person.id }}</td>
          <td>{{ person.firstName }}</td>
          <td>{{ person.lastname }}</td>
        </tr>
      </tbody>
    </table> -->
  </div>
</template>

<script>
// import HelloWorld from '@/components/HelloWorld.vue';
import api from '@/api';

export default {
  // name: 'HomeView',
  // components: {
  //   HelloWorld,
  // },
  data() {
    return {
      persons: [], // Tableau pour stocker les données de l'API
    };
  },
  mounted() {
    api.getPersons()
      .then((response) => {
        console.log(response.data); // Vérifie la structure de la réponse
        this.persons = response.data.member; // Accède aux données dans "member"
      })
      .catch((error) => {
        console.error('Erreur lors de la récupération des données:', error);
      });
  },
};
</script>

<style>
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}
th, td {
  border: 1px solid #ddd;
  padding: 8px;
}
th {
  background-color: #f4f4f4;
}
</style>
