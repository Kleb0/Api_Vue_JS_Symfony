
Voici comment ajuster la disposition du formulaire pour répondre à tes besoins. Nous allons modifier les classes Bootstrap pour la grille et réorganiser les éléments du formulaire.

Code mis à jour
vue
Copier le code
<template>
  <div class="register container border p-4">
    <h1 class="text-center mb-4">Inscription</h1>
    <form @submit.prevent="registerUser" class="row g-3">
      <!-- Email occupe toutes les colonnes -->
      <div class="col-12">
        <label for="email" class="form-label mt-3">Email</label>
        <input v-model="form.email" type="email" id="email" class="form-control" required />
      </div>
      
      <!-- First Name et Last Name prennent chacun 50% -->
      <div class="col-md-6">
        <label for="firstName" class="form-label mt-3">First name</label>
        <input v-model="form.firstName" type="text" id="firstName" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="lastName" class="form-label mt-3">Last name</label>
        <input v-model="form.lastName" type="text" id="lastName" class="form-control" required />
      </div>

      <!-- Street Name et les autres champs -->
      <div class="col-md-6">
        <label for="streetName" class="form-label mt-3">Street name</label>
        <input v-model="form.streetName" type="text" id="streetName" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="streetNumber" class="form-label mt-3">Number</label>
        <input v-model="form.streetNumber" type="number" id="streetNumber" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="city" class="form-label mt-3">Town</label>
        <input v-model="form.city" type="text" id="city" class="form-control" required />
      </div>
      <div class="col-md-6">
        <label for="postalCode" class="form-label mt-3">Zip code</label>
        <input v-model="form.postalCode" type="text" id="postalCode" class="form-control" required />
      </div>

      <!-- Password et Confirm Password -->
      <div class="col-md-6">
        <label for="password" class="form-label mt-3">Password</label>
        <input v-model="form.password" type="password" id="password" class="form-control" required autocomplete="new-password" />
      </div>
      <div class="col-md-6">
        <label for="confirmPassword" class="form-label mt-3">Confirm Password</label>
        <input v-model="form.confirmPassword" type="password" id="confirmPassword" class="form-control" required autocomplete="new-password" />
      </div>
      
      <div class="col-12">
        <button :disabled="loading" type="submit" class="btn btn-primary w-80 mt-4 mx-auto d-block">Subscribe</button>
      </div>
      
      <div class="col-12">
        <p v-if="errorMessage" :class="{ 'text-danger': !isSuccess, 'text-success': isSuccess }">
          {{ errorMessage }}
        </p>
      </div>
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
    loading: false, // add a loading state
  };
},
methods: {
  async registerUser() {
    if (this.form.password !== this.form.confirmPassword) {
      this.errorMessage = 'Passwords must match.';
      this.isSuccess = false;
      return;
    }

    this.loading = true; // prevent multiple requests
    try {
      const response = await fetch('http://localhost:8000/api/register-user', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
        },
        body: JSON.stringify({
          email: this.form.email,
          firstName: this.form.firstName,
          lastName: this.form.lastName,
          streetName: this.form.streetName,
          streetNumber: this.form.streetNumber,
          city: this.form.city,
          postalCode: this.form.postalCode,
          password: this.form.password,
        }),
      });

      const data = await response.json();

      if (!response.ok) {
        this.errorMessage = data.message || 'An error occured.';
        this.isSuccess = false;
      } else {
        this.errorMessage = data.message;
        this.isSuccess = true;
        setTimeout(() => {
          this.$router.push('/');
        }, 1500);
      }
    } catch (error) {
      this.errorMessage = 'Server unreachable, please try later.';
      this.isSuccess = false;
    } finally {
      this.loading = false; 
    }
  },
},
};
</script>

<style scoped >
.register {
  background-color: #f8f9fa;
  padding: 30px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

button {
  width: 10%;
  display: block;
  margin: 0 auto;
}

button:disabled {
  background-color: #6c757d;
  cursor: not-allowed;
}

.text-danger {
  color: red;
}

.text-success {
  color: green;
}
</style>