<template>
  <v-row justify="center">
    <v-dialog v-model="dialog" persistent max-width="800px">
      <template  v-slot:activator=" { props: menu  } " >
        <v-btn size="30"  text   outlined color="orange" v-bind="mergeProps(menu)" >
            <v-icon small left>update</v-icon>
                <span>Modifier</span>
            </v-btn>
      </template>
      <v-card>
        <v-card-title>
          <span class="headline">Nouveau rendez-vous</span>
        </v-card-title>
         <v-form class="px-3" ref="form" @submit.prevent="updateDoctor">
        <v-card-text>
           
          <v-text-field v-model="formData.name" label="Name" outlined required clearable prepend-icon="account_circle"></v-text-field>
              <v-text-field v-model="formData.email" label="Email Address" outlined required type="email" clearable prepend-icon="mail_lock"></v-text-field>
              <v-text-field v-model="formData.password" label="New Password (optional)" outlined required type="password"  prepend-icon="key"></v-text-field>
              <v-text-field v-model="formData.password_confirmation" label="Confirm Password" outlined required type="password" prepend-icon="check_circle_outline"></v-text-field>
        </v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn color="red" text outlined @click="deleteDoctor(formData.id)">Supprimer Docteur
              <v-icon size="20">close</v-icon>
              <v-dialog v-model="showDeleteConfirmation" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this Doctor?</v-card-title>
                  <v-card-actions class="flex justify-center">
                    <v-btn  color="primary" @click="deleteDoctorConfirmed">Yes</v-btn>
                    <v-btn  color="primary" text @click="showDeleteConfirmation = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-btn>
            <v-btn color="green" type="submit" text outlined >Modifier</v-btn>
        </v-card-actions>
         </v-form>
      </v-card>
    </v-dialog>
  </v-row>
  <v-dialog v-model="successDialog" max-width="400px" >
       <v-card >
         <v-card-title style="text-align: center;">Doctor updated successfully</v-card-title>
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
  emits: ['doctorDeleted','doctorUpdated'],

  


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
      showDeleteConfirmation: false,

      
     
     
      
    }),

    methods: {
      
      mergeProps,
      updateDoctor() {
      axios.put(`/api/updateDoctor/${this.user.id}`, this.formData)
        .then(response => {
          // Handle success, e.g., show a success message
          console.log(response.data.message);
          this.$emit('doctorUpdated');
          this.dialog = false
          this.successDialog=true
          // You may also want to update your local data with the updated user details
        })
        .catch(error => {
          // Handle errors, e.g., show an error message
          console.error('Error updating doctor user:', error);
        });
    },
    Redirect(){
      const router = useRouter();
      router.push('/team');
      
  },
  deleteDoctor(appointmentId) {
    // Set the appointment ID to be deleted
    this.doctorToDeleteId = appointmentId;
    // Show the delete confirmation dialog
    this.showDeleteConfirmation = true;
  },

  deleteDoctorConfirmed() {
    axios.get('/sanctum/csrf-cookie').then(response => {
    axios
      .delete(`api/deleteDoctor/${this.doctorToDeleteId}`)
      .then(() => {
        console.log(response.data.message);
        this.dialog = false
        this.$emit('doctorDeleted');
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      })
      .catch(error => {
        console.error(error);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      });})
  },

      
    },
    created() {
      console.log(this.user)
      this.formData.name = this.user.name || '';
      this.formData.email = this.user.email || '';
      this.formData.id = this.user.id || '';
    },
    props: {
        user: {
        type: Object,
        required: true,
      },
    },
    

   
    


}
</script>