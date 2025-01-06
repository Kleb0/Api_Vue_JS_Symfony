import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import RegisterView from '../views/RegisterView.vue'
import LoginView from '../views/LoginView.vue'
import UserManagementView from '../views/UserManagementView.vue'
import MoviesManagerView from '../views/MoviesManagerView.vue';
import MainCatalogueView from '../views/MainCatalogueView.vue';
import MovieView from '../views/MovieView.vue';

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView
  },
  {
    path: '/about',
    name: 'about',
    // route level code-splitting
    // this generates a separate chunk (about.[hash].js) for this route
    // which is lazy-loaded when the route is visited.
    component: () => import(/* webpackChunkName: "about" */ '../views/AboutView.vue'),
  },
  {
    path: '/register',
    name: 'register',
    component : RegisterView
  },
  {
    path: '/login',
    name: 'login',
    component : LoginView
  },

  {
    path: '/user-management',
    name: 'user-management',
    component: UserManagementView,
    beforeEnter: (to, from, next) => {
      const role = localStorage.getItem('userRoleName');
      if (role === 'ADMIN') {
        next();
      } else {
        alert('Access denied. Admins only!');
        next('/');
      }
    },
  },
  {
    path: '/movies-management',
    name: 'movies-management',
    component: MoviesManagerView,
    beforeEnter: (to, from, next) => {
      const role = localStorage.getItem('userRoleName');
      if (role === 'ADMIN') {
        next();
      } else {
        alert('Access denied. Admins only!');
        next('/');
      }
    },
  },
  {
    path: '/main-catalog',
    name: 'main-catalog',
    component: MainCatalogueView,
  },
  {
    path: '/movie/:customId',
    name: 'movie',
    component: MovieView,
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
