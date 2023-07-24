<template>
  <div class="appointments">
    <h1 class="subheading grey--text">Vos rendez-vous</h1>
    <v-container>
      <v-layout row wrap class="mb-4">
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="green" @click="sortBy('title')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>folder</v-icon>
              <span class="caption text-lowercase">Par titre de rendez-vous</span>
            </v-btn>
          </template>
          <span>Tri par titre</span>
        </v-tooltip>
        <v-tooltip bottom>
          <template v-slot:activator="{ props: menu }">
            <v-btn small outlined color="blue" @click="sortBy('date')" class="mr-2" dark v-bind="mergeProps(menu)">
              <v-icon left small>person</v-icon>
              <span class="caption text-lowercase">Par Date</span>
            </v-btn>
          </template>
          <span>Tri par Date</span>
        </v-tooltip>
      </v-layout>
      <v-card flat v-for="appointment in appointments" :key="appointment.id" class="mb-1">
      <v-layout row wrap :class="`pa-3 appointment ${appointment.status}`">
        <v-expansion-panels>
      <v-expansion-panel class="tw-pa-10" :text="appointment.description">
        <template #title>
          <div class="tw-flex tw-items-center tw-justify-start tw-w-full">
            <span class="text-uppercase ">{{ appointment.title }}</span>
            <span class="font-weight-light tw-ml-10">{{ appointment.date }}</span>
          </div>
          <Edit :appointment="appointment"/>
            <v-btn size="30" class="tw-float-right tw-mr-5"  text @click="deleteAppointment(appointment.id)">
              <v-icon size="20">delete</v-icon>
              <v-dialog v-model="showDeleteConfirmation" max-width="500px">
                <v-card>
                  <v-card-title class="headline">Are you sure you want to delete this appointment?</v-card-title>
                  <v-card-actions class="flex justify-center">
                    <v-btn  color="primary" @click="deleteAppointmentConfirmed">Yes</v-btn>
                    <v-btn  color="primary" text @click="showDeleteConfirmation = false">No</v-btn>
                  </v-card-actions>
                </v-card>
              </v-dialog>
            </v-btn>
            
        </template>
        <!-- Content for the expansion panel goes here -->
      </v-expansion-panel>
    </v-expansion-panels>
      </v-layout>
    </v-card>
    </v-container>
  </div>
</template>

<script>
import { mergeProps } from 'vue'
import Edit from '../components/Edit.vue'
import axios from 'axios';

export default {
  name: 'appointments',
  components: {Edit, },
  data: () => ({
    appointments: [],
    showDeleteConfirmation: false,
  }),
  methods: {
    sortBy(prop) {
      this.appointments.sort((a, b) => (a[prop] < b[prop] ? -1 : 1))
    },
    deleteAppointment(appointmentId) {
    // Set the appointment ID to be deleted
    this.appointmentToDeleteId = appointmentId;
    // Show the delete confirmation dialog
    this.showDeleteConfirmation = true;
  },

  deleteAppointmentConfirmed() {
    axios
      .delete(`api/appointments/${this.appointmentToDeleteId}`)
      .then(() => {
        // Remove the deleted appointment from the local list
        this.appointments = this.appointments.filter(appointment => appointment.id !== this.appointmentToDeleteId);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      })
      .catch(error => {
        console.error(error);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      });
  },

    mergeProps
  },
  created() {
    // Récupérer les rendez-vous via la route /appointments
    axios
      .get('api/appointments')
      .then(response => {
        this.appointments = response.data
      })
      .catch(error => {
        console.error(error)
      })
  }
}
</script>

<style>
.appointment {
  border-left: 4px solid #3cd1c2;
}
.appointment.no {
  border-left: 4px solid orange;
}
.appointment.up {
  border-left: 4px solid red;
}
.appointment.yes {
  border-left: 4px solid yellow;
}
.v-chip{
  color: #3cd1c2;
}
.p.ovnored {
  color: orange;
}
.p.up {
  color: red;
}
.p.yes {
  color: yellow;
}
</style>
