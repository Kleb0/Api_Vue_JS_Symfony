const { defineConfig } = require('@vue/cli-service');

module.exports = defineConfig({
  // Emplacement où les fichiers générés seront stockés après le build
  outputDir: '../back/public/dist',

  // Chemin public utilisé par Vue.js pour accéder aux fichiers statiques
  publicPath: '/dist/',

  // Configuration du serveur de développement
  devServer: {
    // Redirection des requêtes vers le backend Symfony
    proxy: {
      '/api': {
        target: 'http://localhost:8000', // URL du backend Symfony
        changeOrigin: true,
        secure: false,
        pathRewrite: { '^/api': '/api' }, // Réécriture des chemins API
      },
    },
    historyApiFallback: true, // Permet de rediriger les routes Vue.js côté frontend
  },

  // Activer la génération des fichiers source map en production (optionnel)
  productionSourceMap: false,

  // Configuration supplémentaire pour les fichiers statiques
  css: {
    extract: true, // Extraire les CSS dans des fichiers séparés
    sourceMap: false, // Désactiver les source maps CSS
  },
});
