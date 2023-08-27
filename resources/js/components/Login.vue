<template dark>
<nav class="tw-sticky tw-top-0 tw-z-50" v-if="!connected">
  <div  class="tw-bg-blue-500 tw-p-4 tw-float">
      <v-toolbar-title class="text-uppercase tw-text-black">
        <span class="font-weight-light ">Dentaire</span>
        <span>Express</span>
      </v-toolbar-title>
      <v-spacer></v-spacer> 
    </div>
  </nav>

  <div class="app" :style="{ backgroundImage: 'url(/bg.jpg)' }">
<v-container  class="tw-min-h-screen tw-flex tw-items-center tw-justify-center " v-if="!connected && !showRegister">
    <v-row justify="center" align="center" class="fill-height" >
      <v-col cols="12" sm="8" md="6" class="tw-bg-blue-500">
        <v-card v-if="!connected && !showRegister">
          <v-card-title class="text-xl font-bold tw-bg-blue-500 tw-text-white" >Login</v-card-title>
          
                <v-divider class="border-opacity-100" :thickness="2"></v-divider>
          <v-card-text>
            <p>Sign in with your email and password: </p><br>
            <v-form @submit.prevent="handleLogin">
              <v-text-field v-model="formData.email" outline label="Email Address" clearable prepend-icon="account_circle"></v-text-field>
              <v-text-field v-model="formData.password" outline label="Password" type="password" prepend-icon="key"></v-text-field>
              <v-alert v-if="LoginMessage" type="error" class="mt-4 mb-4">{{ LoginMessage }}</v-alert>
              <v-row class="justify-center"><br>
                <v-divider class="border-opacity-100" :thickness="2"></v-divider><br>
              <v-btn  class="mr-4" type="submit" color="blue" large>
                <v-icon left>lock</v-icon>
                Login
              </v-btn>
                
                <v-btn @click="showRegisterForm">Register</v-btn>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
        
      </v-col>
    </v-row>
    
  </v-container>
</div>

        
  <register v-if="showRegister" @show-login="showLoginForm" @registration-success="handleRegistrationSuccess"></register>

  <Client v-if="!showRegister && connected && user.type=='client'" :user="user" />
  <Doctor v-if="!showRegister && connected && user.type=='doctor'" :user="user" />

</template>

<script>
import Client from './ClientApp.vue'
import Doctor from './DoctorApp.vue'
import Register from './RegisterDoctor.vue';
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  data() {
    return {
      drawer: true,
      darkTheme: true,
      connected:false,
      secrets: [],
      user: {},
      LoginMessage:'',
      registration:false,
      formData: {
        email: '',
        password: '',
      },
      showRegister: false,
    };
  },
  methods: {
    handleLogin() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/login', this.formData).then((response) => {
          this.connected=true
          axios.get('/api/user').then((response) => {
            console.log(response);
            this.user = response.data;
            this.LoginMessage = 'Login successful!';
          });
        })
        .catch((error) => {
          console.error(error);
          this.LoginMessage =  'Login failed. Please check your credentials.'
        });
      });
    },
    checkAuthentication() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.get('api/check-authentication').then((response) => {
          if (response.data.authenticated) {
            this.connected=true
           
            axios.get('/api/user').then((response) => {
              console.log(response);
              this.user = response.data;
            });
          }
        });
      });
    },
    
    showRegisterForm() {
      this.showRegister = true;
    },
    showLoginForm() {
      this.showRegister = false;
    },
    handleRegistrationSuccess() {
      localStorage.setItem('registrationSuccessMessage','Registration successful!');
      
     
      
    },
  },
  components: {
    register: Register,
    Client,
    Doctor,
  },
  created() {
    this.checkAuthentication();
    const storedRegistrationMessage = localStorage.getItem('registrationSuccessMessage');
    setTimeout(() => {
      if (storedRegistrationMessage) {
      this.LoginMessage = storedRegistrationMessage;
      localStorage.removeItem('registrationSuccessMessage');
    }
    }, 2000);
   
  },

};
</script>

<style>
.form-row {
  margin-bottom: 8px;
}
</style>
