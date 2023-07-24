<template>
  <v-container class="tw-mt-4">
    <v-row justify="center">
      <v-col cols="12" md="8" lg="6">
        <v-card class="tw-rounded" elevation="2">
          <v-card-title class="tw-text-2xl tw-font-bold">
            Register
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="handleRegistration">
              <v-text-field v-model="formData.name" label="Name" outlined required></v-text-field>
              <v-text-field v-model="formData.email" label="Email Address" outlined required type="email"></v-text-field>
              <v-text-field v-model="formData.password" label="Password" outlined required type="password"></v-text-field>
              <v-text-field v-model="formData.password_confirmation" label="Confirm Password" outlined required type="password"></v-text-field>
              <div v-if="registerMessage" class="tw-bg-red-200 tw-text-red-800 tw-py-2 tw-px-4 tw-rounded tw-mt-4 tw-mb-4">
                {{ registerMessage }}
              </div>
              <v-btn color="primary" class="tw-mr-4" type="submit">
                Register
              </v-btn>
              <v-btn @click="showLoginForm">Login</v-btn>
            </v-form>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
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
