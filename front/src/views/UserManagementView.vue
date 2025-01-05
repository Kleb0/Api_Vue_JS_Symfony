D'accord <template>
  <div>
    <h1>User Management</h1>
    <p>Welcome, Admin! Here you can manage users.</p>

    <table border="1" cellspacing="0" cellpadding="10">
      <thead>
        <tr>
          <th>Custom ID</th>
          <th>Email</th>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Role Name</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in users" :key="user.customId">
          <td>{{ user.customId }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.firstName }}</td>
          <td>{{ user.lastName }}</td>
          <td>{{ user.roleName }}</td>
          
          <td>
            <template v-if="user.email === currentUserEmail">
              Vous n'avez pas le droit d'effectuer ces actions sur votre compte
            </template>
            <template v-else>
              <button 
                @click="updateUserRole(user)" 
                class="btn-update-role"
              >
                Update Role
              </button>
              <button 
                  @click="banUser(user)" 
                  class="btn-ban-user"
                >
                  Ban User
              </button>
            </template>
          </td>


        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "UserManagementView",
  data() {
    return {
      users: [],
      roles: [],
      currentUserEmail: "", // Stocke l'email de l'utilisateur connecté
    };
  },
  created() {
    this.currentUserEmail = localStorage.getItem('userEmail') || ''; 
    this.fetchUsers();
    this.fetchRoles();
  },

  methods: {


    async fetchUsers() {
      try {
        const response = await axios.get("http://localhost:8000/api/users");
        this.users = response.data.member.map(user => ({
          ...user,
          newRole: user.roleName, // Par défaut, rôle actuel
        }));
      } catch (error) {
        console.error("Error fetching users:", error);
      }
    },
    async fetchRoles() {
      try {
        const response = await axios.get("http://localhost:8000/api/roles");
        this.roles = response.data;
      } catch (error) {
        console.error("Error fetching roles:", error);
      }
    },
    async updateUserRole(user) {
      try {
        const newRoleId = user.roleName === 'ADMIN' ? 2 : 1;
        const newRoleName = newRoleId === 1 ? 'ADMIN' : 'USER';

        await axios.patch(`http://localhost:8000/api/users/${user.customId}`, {
          roleId: newRoleId,
          roleName: newRoleName, 
        });

        user.roleName = newRoleName; 
      } catch (error) {
        console.error('Error updating user role:', error);
        alert('An error occurred while updating the role.');
      }
    },
    async banUser(user) { // Déplacement ici, dans methods
      if (confirm(`Are you sure you want to ban ${user.firstName}?`)) {
        try {
          await axios.delete(`http://localhost:8000/api/users/${user.customId}/ban`);
          alert(`${user.firstName} has been banned.`);
          this.fetchUsers(); // Actualise la liste des utilisateurs
        } catch (error) {
          console.error('Error banning user:', error);
          alert('An error occurred while banning the user.');
        }
      }
    }
  }
};
</script>

<style scoped>
  table {
    width: 100%;
    text-align: left;
  }
  th, td {
    padding: 10px;
  }
  .btn-update-role {
    padding: 5px 10px;
    background-color: #4caf50;
    color: white;
    border: none;
    cursor: pointer;
  }

  .btn-update-role:hover {
    background-color: #46a049;
  }

  .btn-ban-user {
    padding: 5px 10px;
    background-color: #e74c3c;
    color: white;
    border: none;
    cursor: pointer;
  }

  .btn-ban-user:hover {
    background-color: #c0392b;
  }
</style>
