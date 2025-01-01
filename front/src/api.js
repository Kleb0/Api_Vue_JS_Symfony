import axios from 'axios';

const api = {
  getPersons() {
    return axios.get('http://127.0.0.1:8000/api/people'); // Assure-toi que l'URL est correcte
  },
};

export default api;
