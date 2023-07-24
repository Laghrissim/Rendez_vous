<template>
  <div class="team">
    <h1 class="subheading grey--text">Home</h1>
    <v-container>
      <v-row>
        <v-col cols="6" xs="12" md="6" lg="3" >
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="green" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>store</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Article</div>
              <v-list-item-title class="text-h5  text-right">523614</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">person</v-icon>
              <div class="text-overline">Iyad</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#F44336" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>subscriptions</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Abonné</div>
              <v-list-item-title class="text-h5  text-right">+700</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">subscriptions</v-icon>
              <div class="text-overline">AAE IdeaPro</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#03A9F4" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>add_shopping_cart</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Shopping</div>
              <v-list-item-title class="text-h5  text-right">$34,245</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">credit_card</v-icon>
              <div class="text-overline">VISA Card</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col cols="6" xs="12" md="6" lg="3">
          <v-card class="ma-3 pa-2">
            <div class="d-flex justify-space-between ">
            <v-avatar tile class="" style="width: 70px; height: 70px;">
              <v-sheet color="#FFC107" height="100%" width="100%"  class="d-flex align-center justify-center">
                <v-icon dark large>folder_shared</v-icon>
              </v-sheet>
            </v-avatar>
            <div class="ma-2">
              <div class=" text-overline text-right">Folder shared</div>
              <v-list-item-title class="text-h5  text-right">1730</v-list-item-title>
              
            </div>
            
          </div>
          <div><v-divider inset class="border-opacity-100" :thickness="4"></v-divider></div>
            <v-card-actions>
              <v-icon text class="ma-2">folde</v-icon>
              <div class="text-overline">Prodect</div>
            </v-card-actions>
          </v-card>
        </v-col>
        <v-col xs="12" sm="6" md="4" lg="3" v-for="person in team" :key="person.name">
          <v-card class="text-center ma-3">
            <v-responsive class="pt-4">
              <v-avatar size="100" class="tw-red lighten-2">
                <img :src="person.avatar" alt="">
              </v-avatar>
            </v-responsive>
            <v-card-text>
              <div class="subheading">{{ person.name }}</div>
              <div class="grey--text">{{ person.role }}</div>
            </v-card-text>
            <v-card-actions>
              <v-btn outlined color="orange">
                <v-icon small left>message</v-icon>
                <span>Message</span>
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script>
// @ is an alias to /src


export default {
  name: 'team',
  components: {
   
  },
  data : () => ({
    team: [
      {name: 'Iyad', role: 'web developer', avatar:'/img1.png'},
      {name: 'Reda', role: 'Graphic designer', avatar:'/img2.png'},
      {name: 'Zineb', role: 'web developer', avatar:'/img3.png'},
      {name: 'Hu TechGroup', role: 'Desktop developer', avatar:'/img4.png'},
    ]
  }),
}
</script>
