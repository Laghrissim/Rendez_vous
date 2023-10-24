<template >
  <div class="app" :style="{ backgroundImage: 'url(/bg.jpg)' }">
  <v-container rounded class="tw-h-screen " >
    <v-row  justify="center"  class="tw-h-full tw-items-center tw-justify-center " >
      <v-col cols="12" md="10" lg="8" class="tw-bg-blue-500">
        <v-card >
          <v-card-title class="tw-text-2xl tw-font-bold tw-bg-blue-500 tw-text-white">
            Register
          </v-card-title>
          <v-divider class="border-opacity-100" :thickness="2"></v-divider>
          <v-card-text>
            <v-form @submit.prevent="handleRegistration">
              <v-text-field v-model="formData.name" label="Name" outlined required clearable prepend-icon="account_circle"></v-text-field>
              <v-text-field v-model="formData.email" label="Email Address" outlined required type="email" clearable prepend-icon="mail_lock"></v-text-field>
             
             
              <v-text-field v-model="formData.password" label="Password" outlined required type="password"  prepend-icon="key"></v-text-field>
              <v-text-field v-model="formData.password_confirmation" label="Confirm Password" outlined required type="password" prepend-icon="check_circle_outline"></v-text-field>
              <div v-if="registerMessage" class="tw-bg-red-200 tw-text-red-800 tw-py-2 tw-px-4 tw-rounded tw-mt-4 tw-mb-4">
                {{ registerMessage }}
              </div>
              <v-divider class="border-opacity-100" :thickness="2"></v-divider><br>
              <v-btn  class="tw-mr-4" type="submit" color="blue" large>
                <v-icon left><span class="material-icons mr-2">
                  app_registration
                  </span></v-icon>
                Register
              </v-btn>
              <v-btn @click="showLoginForm">Login</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</div>
</template>



<script>
import axios from 'axios';
axios.defaults.withCredentials = true;

export default {
  emits: ['show-login'],
  data() {
    return {
      registerMessage: '',
      formData: {
        name: '',
        email: '',
        type:'client',
        password: '',
        password_confirmation: '',
      },
    };
  },
  methods: {
    handleRegistration() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/register', this.formData)
          .then(response => {
            console.log(response);
            console.log(this.formData.type);
            this.$emit('registration-success'); // Emit the custom event
            location.reload();
          })
          .catch(error => {
            console.error(error);
            if (error.response && error.response.data && error.response.data.message) {
              this.registerMessage = error.response.data.message;
            } else {
              this.registerMessage = 'Registration failed. Please try again.';
            }
            console.error(error);
          });
      });
    },
    showLoginForm() {
      this.$emit('show-login'); // Emit the custom event
    },
  },
};
</script>

<style>
.form-row {
  margin-bottom: 8px;
}
</style>
