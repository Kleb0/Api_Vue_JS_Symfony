<template>
  <div class="login container border p-4">
    <h1 class="text-center mb-4">Login</h1>
    <form @submit.prevent="handleLogin" class="row g-3">
      <div class="col-12">
        <label for="email" class="form-label mt-3">Email</label>
        <input v-model="email" type="email" id="email" class="form-control" required />
      </div>
      <div class="col-12">
        <label for="password" class="form-label mt-3">Password</label>
        <input v-model="password" type="password" id="password" class="form-control" required />
      </div>
      <div class="col-12">
        <button type="submit" :disabled="loading" class="btn btn-primary w-80 mt-4 mx-auto d-block">Login</button>
      </div>
      <div class="col-12">
        <p v-if="errorMessage" :class="{ 'text-danger': true }">
          {{ errorMessage }}
        </p>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, provide, onMounted, inject } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
  setup() {
    const email = ref('');
    const password = ref('');
    const errorMessage = ref('');
    const isLoggedIn = inject('isLoggedIn');

    if (!isLoggedIn) {
      console.error('isLoggedIn is not properly injected.');
    }
    
    const router = useRouter();
    

    const handleLogin = async ()=> {
      try {
        const response = await axios.post('http://localhost:8000/api/login', {
          email: email.value,
          password: password.value,
        }, {
          withCredentials: true,
        });


        //Store token, first name and role in local storage
        const { token, user, refresh_token } = response.data;
        localStorage.setItem('token', token);
        localStorage.setItem('refresh_token', refresh_token);
        localStorage.setItem('userFirstName', user.first_name);
        localStorage.setItem('userRoleName', user.roleName);
        localStorage.setItem('isLoggedIn', 'true');

        const updateUserInfo = inject('updateUserInfo');
        if (updateUserInfo) updateUserInfo();

        // alert('Login successful');
        isLoggedIn.value = true;
        router.push('/');

      }
      catch(error){
        console.error('Login failed:', error);
        errorMessage.value = 'Login failed. Please check your credentials.';
      }
    };

    const checkTokenValidity = async () => {
      const token = localStorage.getItem('token');
      if (token) {
        try {

          await axios.get('http://localhost:8000/api/check-token', {
            headers: { Authorization: `Bearer ${token}` },
          });
          isLoggedIn.value = true;
          localStorage.setItem('isLoggedIn', 'false');
        } catch (error) {
          console.error('Invalid or expired token:', error);
          localStorage.removeItem('token');
          localStorage.removeItem('user');
          isLoggedIn.value = false;
        }
      }
    };

    const logout = async () => {
      try {
        await axios.post('http://localhost:8000/api/logout');
        localStorage.removeItem('token');
        localStorage.removeItem('user');
        isLoggedIn.value = false;
        alert('Logout successful');
      } catch (error) {
        console.error('Error during logout:', error);
      }
    };

    onMounted(checkTokenValidity);

    provide('isLoggedIn', isLoggedIn);

    return {
      email,
      password,
      errorMessage,
      isLoggedIn,
      handleLogin,
      logout,
    };

  }
}

</script>

<style scoped>
.login {
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
</style>
