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
      <v-card flat v-for="appointment in appointments" :key="appointment.title" class="mb-1">
      <v-layout row wrap :class="`pa-3 appointment ${appointment.status}`">
        <v-expansion-panels>
      <v-expansion-panel class="tw-pa-10" :text="appointment.description">
        <template #title>
          <span class="text-uppercase tw-mr-14">{{ appointment.title }}</span>
          <span class=" font-weight-light  tw-ml-14"> {{ appointment.date }}</span>
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
import axios from 'axios';

export default {
  name: 'appointments',
  components: {},
  data: () => ({
    appointments: []
  }),
  methods: {
    sortBy(prop) {
      this.appointments.sort((a, b) => (a[prop] < b[prop] ? -1 : 1))
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
