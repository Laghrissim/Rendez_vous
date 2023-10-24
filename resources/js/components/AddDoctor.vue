<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">
      <template  v-slot:activator=" { props: menu  } " >
        <a class="btn-solid-lg " dark v-bind="mergeProps(menu)">Ajoutez Doctor</a>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Nouveau Docteur</span>
        </v-card-title>
         <v-form class="px-3" ref="form" @submit.prevent="handleRegistration">
        <v-card-text>
           
          <v-text-field v-model="formData.name" label="Name" outlined required clearable prepend-icon="account_circle"></v-text-field>
              <v-text-field v-model="formData.email" label="Email Address" outlined required type="email" clearable prepend-icon="mail_lock"></v-text-field>
              <v-text-field v-model="formData.password" label="Password" outlined required type="password"  prepend-icon="key"></v-text-field>
              <v-text-field v-model="formData.password_confirmation" label="Confirm Password" outlined required type="password" prepend-icon="check_circle_outline"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="blue darken-1" text @click="dialog = false">Fermer</v-btn>
          <v-btn color="green" type="submit" text outlined @click="Redirect">Envoyer</v-btn>
        </v-card-actions>
         </v-form>
      </v-card>
    </v-dialog>
  </v-row>
  <v-dialog v-model="successDialog" max-width="400px" >
       <v-card >
         <v-card-title style="text-align: center;">Appointment created successfully</v-card-title>
         <v-card-actions class="flex justify-center">
           <v-btn color="green" text @click="successDialog = false">OK</v-btn>
         </v-card-actions>
       </v-card>
     </v-dialog>
</template>

<script>
import { mergeProps , computed ,watch ,ref} from 'vue'
import moment from 'moment';
import axios from 'axios';
import { useRouter } from 'vue-router';
export default {
  


    data: vm => ({
      dialog: false,
      title:'',
      content:'',
      due:null,
      successDialog:false,
      formData: {
        name: '',
        email: '',
        type:'doctor',
        password: '',
        password_confirmation: '',
      },
      
     
     
      
    }),

    methods: {
      
      mergeProps,
      handleRegistration() {
      axios.get('/sanctum/csrf-cookie').then(response => {
        axios.post('/api/createDoctor', this.formData)
          .then(response => {
            console.log(response);
            console.log(this.formData.type);
             // Emit the custom event
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
      
    },
    created() {
      
    },

    

   
    


}
</script>