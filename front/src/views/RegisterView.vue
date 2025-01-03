<template>
  <div class="register">
    <h1>Inscription</h1>
    <form @submit.prevent="registerUser">
      <div>
        <label for="email">Email</label>
        <input v-model="form.email" type="email" id="email" required />
      </div>
      <div>
        <label for="adress">Adresse</label>
        <input v-model="form.adress" type="text" id="adress" required />
      </div>
      
      <div>
        <label for="password">Mot de passe</label>
        <input v-model="form.password" type="password" id="password" required autocomplete="new-password" />
      </div>
      <div>
        <label for="confirmPassword">Confirmez le mot de passe</label>
        <input v-model="form.confirmPassword" type="password" id="confirmPassword" required autocomplete="new-password" />
      </div>

      <button :disabled="loading" type="submit">S'inscrire</button>
      <p v-if="errorMessage" :class="{ error: !isSuccess, success: isSuccess }">
        {{ errorMessage }}
      </p>
    </form>
  </div>
</template>

<script>
export default {
  
  data() {
  return {
    form: {
      email: '',
      adress: '',
      password: '',
      confirmPassword: '',
    },
    errorMessage: '',
    isSuccess: false,
    loading: false, // Ajout de l'état de chargement
  };
},
methods: {
  async registerUser() {
    if (this.form.password !== this.form.confirmPassword) {
      this.errorMessage = 'Les mots de passe ne correspondent pas.';
      this.isSuccess = false;
      return;
    }

    this.loading = true; // Empêche le clic multiple
    try {
      const response = await fetch('http://localhost:8000/api/register-user', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: this.form.email,
          adress: this.form.adress,
          password: this.form.password,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        this.errorMessage = data.message || 'Une erreur est survenue.';
        this.isSuccess = false;
      } else {
        this.errorMessage = data.message;
        this.isSuccess = true;
        setTimeout(() => {
          this.$router.push('/');
        }, 1500);
      }
    } catch (error) {
      this.errorMessage = 'Le serveur est inaccessible. Veuillez réessayer plus tard.';
      this.isSuccess = false;
    } finally {
      this.loading = false; 
    }
  },
},
};
</script>

<style>
.error {
  color: red;
}

.success {
  color: green;
}
</style>
