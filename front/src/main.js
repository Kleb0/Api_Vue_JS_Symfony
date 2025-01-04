import { createApp, ref } from 'vue';
import App from './App.vue';
import router from './router';

const isLoggedIn = ref(localStorage.getItem('isLoggedIn') === 'true');

const app = createApp(App);
app.use(router);
app.provide('isLoggedIn', isLoggedIn); 
app.mount('#app');
