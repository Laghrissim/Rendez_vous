<template>
<v-container fluid  class="tw-min-h-screen tw-flex tw-items-center tw-justify-center" v-if="!connected">
    <v-row justify="center" align="center" class="fill-height" >
      <v-col cols="12" sm="8" md="6">
        <v-card v-if="!connected && !showRegister">
          <v-card-title class="text-xl font-bold">Login</v-card-title>
          <v-card-text>
            <v-form @submit.prevent="handleLogin">
              <v-text-field v-model="formData.email" label="Email Address"></v-text-field>
              <v-text-field v-model="formData.password" label="Password" type="password"></v-text-field>
              <v-alert v-if="LoginMessage" type="error" class="mt-4 mb-4">{{ LoginMessage }}</v-alert>
              <v-row class="justify-center">
                <v-btn type="submit" color="primary" class="mr-4">Sign In</v-btn>
                <v-btn @click="showRegisterForm">Register</v-btn>
              </v-row>
            </v-form>
          </v-card-text>
        </v-card>
        <div v-else>
        <register v-if="showRegister" @show-login="showLoginForm" @registration-success="handleRegistrationSuccess"></register>
        
          
            <!-- <div  class="user">
              <p>Welcome <em>{{ user.name }}</em></p>
              <p>Email: <strong>{{ user.email }}</strong></p>
            </div>
            <v-alert v-if="LoginMessage" type="success" class="mt-4 tw-mb-8 ">{{ LoginMessage }}</v-alert>
            <v-row class="justify-center">
              <v-btn v-if="!showRegister" @click="logout">Sign Out</v-btn>
            </v-row> -->
           
          
            
        </div>
      </v-col>
    </v-row>
    
  </v-container>
  <client v-if="!showRegister && connected" :user="user" />
  
</template>

<script>
import Client from './ClientApp.vue'
import Register from './Register.vue';
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  data() {
    return {
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
    getSecrets() {
      axios.get('/api/secrets').then((response) => {
        console.log(response);
        this.secrets = response.data;
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
    client: Client,
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
