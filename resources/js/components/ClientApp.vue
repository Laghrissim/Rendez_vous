<template>
    <v-app>
    <Navbar :user="user"/>
      <v-main class="ma-4">
        <router-view></router-view>
      </v-main>
       <Footer/>
    </v-app>
   
  </template>
  
  <script>
  
  import Navbar from './Navbar.vue'
  import Footer from './Footer.vue'
  export default {
    name: 'App',
  
    components: {
     Navbar,
     Footer
    },
    props: {
    user: {
      type: Object,
      required: true,
    },
  },
  
    data: () => ({
      //
    }),
  };
  </script>
  