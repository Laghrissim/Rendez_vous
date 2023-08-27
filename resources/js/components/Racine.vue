<template>
    <v-app>
      <v-main >
        <router-view name="first"></router-view>
        
      </v-main>
      
       
    </v-app>
   
  </template>
  
  <script>
  
  import Navbar from './Navbar.vue'
  import Footer from './Footer.vue'
  import axios from 'axios';

  export default {
    name: 'App',
  
    components: {
     Navbar,
     Footer
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
    }, fetchComments() {
      axios.get('/api/comments')
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
  },
  created() {
      this.fetchComments();

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