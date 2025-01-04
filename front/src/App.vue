<template>
  <nav class="navbar">
    <router-link to="/">Home</router-link> |
    <router-link to="/about">About</router-link> |

    <template v-if="!isLoggedIn">
      <router-link to="/register"> Register</router-link> |
      <router-link to="/login">Login</router-link>
    </template>
    <template v-else>

    <template v-if="userRoleName === 'ADMIN'">
        <router-link to="/user-management">User Management</router-link> |
    </template>
            
    <div class="user-info">
        <span> Hello, {{ userFirstName }}</span>
        <hr v-if="userRoleName === 'ADMIN'" class="divider" />
        <span v-if="userRoleName === 'ADMIN'" class="admin-info">
          Vous êtes <span class="admin-highlight">Admin</span>
        </span>
        <hr class="divider" />
        <button @click="logout" class="btn-logout">Logout</button>
      </div>
    </template>

  </nav>
  <router-view/>
</template>

<script>

import { ref, provide, onMounted, watch } from 'vue';
import axios from 'axios';


export default {
  setup() {
    const isLoggedIn = ref(localStorage.getItem('isLoggedIn') === 'true');
    const userFirstName = ref(localStorage.getItem('userFirstName') || '');
    const userRoleName = ref(localStorage.getItem('userRoleName') || '');

    const updateUserInfo = () => {
      userFirstName.value = localStorage.getItem('userFirstName') || '';
      userRoleName.value = localStorage.getItem('userRoleName') || '';
    };

    const checkToken = async () => {
    const token = localStorage.getItem('token');
    if (token) {
        try {
            // Vérifie si le token est valide
            await axios.get('http://localhost:8000/api/check-token', {
                headers: { Authorization: `Bearer ${token}` },
            });
            isLoggedIn.value = true;
            localStorage.setItem('isLoggedIn', 'true');
        } catch (error) {
            console.error('Invalid or expired token:', error);
            localStorage.removeItem('token');
            localStorage.removeItem('refresh_token');
            localStorage.removeItem('userFirstName');
            localStorage.removeItem('userRoleName');
            isLoggedIn.value = false;
            localStorage.setItem('isLoggedIn', 'false');
        }
    } else {
        isLoggedIn.value = false;
        localStorage.setItem('isLoggedIn', 'false');
    }
  };

  const logout = async () => {
      try {
            await axios.post('http://localhost:8000/api/logout', {}, {
                withCredentials: true, 
                headers: {
                    Authorization: `Bearer ${localStorage.getItem('token')}`,
                },
            });
            localStorage.clear();
            isLoggedIn.value = false;
            localStorage.setItem('userFirstName', '');
            localStorage.setItem('userRoleName', '');        
        } catch (error) {
            console.error('Error during disconnection:', error);
        }
    };

    watch(isLoggedIn, (newValue) => {
      if (newValue) {
        updateUserInfo(); // Met à jour userFirstName et userRoleName
      }
    });


    onMounted(() => {
      checkToken();
      updateUserInfo();
    });

    provide('isLoggedIn', isLoggedIn);
    provide('updateUserInfo', updateUserInfo);

    return {
      isLoggedIn,
      userFirstName,
      userRoleName,
      logout,
    };
  },
};
</script>


<style scoped>
.navbar {
  background-color: #42b983; 
  padding: 35px;
  display: flex;
  justify-content: space-between; 
  align-items: center;
  flex-wrap: wrap; 
  margin-bottom: 80px;
}

.nav-links {
  display: flex;
  gap: 5px; /* Espacement entre les liens */
}

nav a {
  font-weight: bold;
  color: white;
  text-decoration: none;
  font-size: 1.2em;
}

.nav a:hover {
  color: rgb(61, 66, 77);
}

nav a.router-link-exact-active {
  text-decoration: underline;
  color: rgb(61, 66, 77);
}

.btn-logout {
  background: none;
  border: none;
  color: white;
  font-weight: bold;
  cursor: pointer;
}

.btn-logout {
  background: none;
  border: none;
  color: red;
  font-weight: bold;
  cursor: pointer;
}

.btn-logout:hover {
  text-decoration: underline;
  color: darkred; 
}

.user-info {
  background-color: white;
  color: #42b983;
  padding: 10px 20px;
  border-radius: 25px;
  font-size: 1em;
  font-weight: bold;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.divider {
  margin: 8px 0;
  border: none;
  border-top: 1px solid #ccc;
  width: 100%;
}

.admin-highlight {
  color: red;
  font-weight: bold;
}




</style>