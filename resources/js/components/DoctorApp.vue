<template>
    <v-app>
    <Navbar :user="user"/>
      <v-main >
        <router-view name="doctor"></router-view>
        <hr class="section-divider" />

  <div class="cards-2 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h2 class="h2-heading">Commentaires des clients</h2>
            </div> 
        </div>
        <div class="row ">
            <div class="col-lg-12 ">
                
                <div class="card tw-ml-5" v-for="comment in comments" :key="comment.id">
                    <v-btn   v-if="user && user.id === comment.user_id" size="30" class="tw-float-right " @click="deleteComment(comment.id)" text >
                    <v-icon size="20">close</v-icon>
                    <v-dialog v-model="showDeleteConfirmation" max-width="500px">
                        <v-card>
                        <v-card-title class="headline">Are you sure you want to delete this comment?</v-card-title>
                        <v-card-actions class="flex justify-center">
                            <v-btn  color="primary" @click="deleteCommentConfirmed">Yes</v-btn>
                            <v-btn  color="primary" text @click="showDeleteConfirmation = false">No</v-btn>
                        </v-card-actions>
                        </v-card>
                    </v-dialog>
                    </v-btn>
                    <img class="quotes" :src="profilePictures[comment.id]" alt="alternative" />
                    <div class="card-body">
                        <p class="testimonial-text">{{ comment.comment }}</p>
                        <div class="testimonial-author">{{ comment.name }}</div>
                        <div class="occupation">{{ comment.user_id === user.id ? 'You' : 'Client' }}</div>
                        
                    </div>
                   
                    <div class="gradient-floor" :class="comment.user_id === user.id ? 'red-to-blue' : ''"></div>
                </div>
              
              
            </div> 
        </div>
    </div> 
  </div> 
        <hr class="section-divider" />

  <div class="footer bg-gray">
    <img class="decoration-circles" src="assets/images/decoration-circles.png" alt="alternative" />
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Nous sommes ravis d'être en mesure de vous offrir une nouvelle façon de rester connectés avec nous - via les réseaux sociaux !</h4>
                <div class="social-container">
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-facebook-f fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-twitter fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-pinterest-p fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-instagram fa-stack-1x"></i>
                        </a>
                    </span>
                    <span class="fa-stack">
                        <a href="#your-link">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fab fa-youtube fa-stack-1x"></i>
                        </a>
                    </span>
                </div> 
            </div> 
        </div>
    </div> 
  </div> 
  <div class="copyright bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-12 col-sm-12">
                <ul class="list-unstyled li-space-lg p-small">
                    <li><a href="#">Article Details</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div> 
            <div class="col-lg-3 col-md-12 col-sm-12">
                <p class="p-small statement">Copyright © <a href="#">DentaireExpress </a></p>
            </div> 
            <div class="col-lg-3 col-md-12 col-sm-12">
                <p class="p-small statement">Distributed by <a href="https://masukmia.com" target="_blank">DentaireExpress </a></p>
            </div> 
        </div> 
    </div> 
  </div>
  <button id="myBtn">
    <img src="assets/images/up-arrow.png" alt="alternative" />
  </button>
      </v-main>
      
       <Footer/>
    </v-app>
   
  </template>
  
  <script>
  
  import Navbar from './DoctorNavbar.vue'
  import Footer from './Footer.vue'
  import Dashboard from '../views/DoctorDashboard.vue'

  import axios from 'axios';

  export default {
    name: 'App',
  
    components: {
     Navbar,
     Footer,
     Dashboard
    },
    props: {
    user: {
      type: Object,
      required: true,
    },
  },
  
  data: () => ({
        name: '',
        email: '',
        comment: '',
        comments: [],
        profilePictures: {},
        showDeleteConfirmation: false,
    }),
    methods: {
    submitComment() {
      const commentData = {
        name: this.user.name,
        email: this.user.email,
        comment: this.comment,
      };

      // Make a POST request to your backend API to save the comment
      axios.post('/api/comments', commentData)
        .then(response => {
          // Handle the response or show a success message
          console.log(response.data);
          this.fetchComments
          // Reset the form fields after successful submission
          this.name = '';
          this.email = '';
          this.comment = '';
          this.fetchComments();

        })
        .catch(error => {
          // Handle errors or show an error message
          console.error(error);
          alert('Error submitting comment.');
        });
    }, 
    async fetchComments() {
      await axios.get('/api/comments')
        .then(response => {
          this.comments = response.data;
        })
        .catch(error => {
          console.error(error);
        });
    },
    
    deleteComment(commentId) {
    // Set the appointment ID to be deleted
    this.commentToDeleteId = commentId;
    // Show the delete confirmation dialog
    this.showDeleteConfirmation = true;
  },

  deleteCommentConfirmed() {
    axios.get('/sanctum/csrf-cookie').then(response => {
    axios
      .delete(`api/comments/${this.commentToDeleteId}`)
      .then(() => {
        // Remove the deleted appointment from the local list
        this.comments = this.comments.filter(comment => comment.id !== this.commentToDeleteId);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      })
      .catch(error => {
        console.error(error);
        // Hide the delete confirmation dialog
        this.showDeleteConfirmation = false;
      });})
  },

  async fetchProfilePicture(userId) {
    try {
      const response = await axios.get(`api/comments/${userId}/profile-picture`); // Replace with your actual route
      // Assuming your API returns the profile picture URL in response.data.profile_picture
      return response.data.profile_picture;
    } catch (error) {
      console.error(`Error fetching profile picture for user ${userId}:`, error);
      return ''; // Return an empty string or a default image URL in case of an error
    }
  },
  },
  async created() {
    
    await this.fetchComments();
   
      for (const comment of this.comments) {
    const profilePicture = await this.fetchProfilePicture(comment.user_id);
    this.profilePictures[comment.id] = profilePicture;
    
  }
      
     
    },

  };
  </script>
  <style>
  h1 {
	color: #223150;
	font-weight: 700;
	font-size: 2.5rem;
	line-height: 3.25rem;
	letter-spacing: -0.4px;
}

h2 {
	color: #223150;
	font-weight: 700;
	font-size: 2rem;
	line-height: 2.5rem;
	letter-spacing: -0.4px;
}

h3 {
	color: #223150;
	font-weight: 700;
	font-size: 1.75rem;
	line-height: 2.25rem;
	letter-spacing: -0.2px;
}

h4 {
	color: #223150;
	font-weight: 700;
	font-size: 1.5rem;
	line-height: 2rem;
	letter-spacing: -0.2px;
}

h5 {
	color: #223150;
	font-weight: 700;
	font-size: 1.25rem;
	line-height: 1.625rem;
}

h6 {
	color: #223150;
	font-weight: 700;
	font-size: 1rem;
	line-height: 1.375rem;
}
</style>