<template >
    <div v-if="show">
  <header id="header" class="header tw-pt-20">
    <div class="container ">
        <div class="row tw-mt-0 tw-text-center">
            <div class="col-lg-6 col-xl-5 tw-ml-20 tw-mt-20">
                <div class="text-container ">
                    <h1 class="h1-large">Cabinet dentaire DentaireExpress</h1>
                    <p class="p-large">Soins Dentaires Exceptionnels pour Votre Santé Bucco-Dentaire</p>
                    
                    <router-link to="/client" class="btn-solid-lg" @click="show = false; client = true; doctor = false" dark>For Client</router-link>
                    <router-link to="/doctor" class="btn-solid-lg" @click="show = false; client = false; doctor = true"  dark>For Doctor</router-link>
                   
                    
                </div>
            </div> 
            <div class="col-lg-6 col-xl-5">
                <div class="image-container">
                    <img style="width: 100%;" class="img-fluid tw-mt-10" src="assets/images/main.png" alt="alternative" />
                </div> 
            </div> 
        </div> 
    </div> 
  </header> 
  <hr class="section-divider" />

  <div id="services" class="cards-1 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="tw-mb-10">Découvrez nos nouveautés</h3>
                <v-carousel cycle show-arrows="hover">
                    <v-carousel-item
                    v-for="(item,i) in items"
                    :key="i"
                    :src="item.src"
                    cover
                    ><div class="d-flex fill-height justify-center align-center">
                        <div class="text-h4 tw-text-white tw-bg-black tw-mt-80">
                            {{ item.title }} 
                        </div>
                    </div>
                    </v-carousel-item>
                </v-carousel>
            </div> 
        </div>
        
       
    </div>
  </div> 
  <div id="services" class="cards-1 bg-gray">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="tw-mb-10">Découvrez nos services</h3>
            </div> 
        </div>
        <div class="row tw-ml-20">
            <div class="col-lg-12">
                
              
                <div class="card">
                    <div class="card-icon">
                        <img src="/tooth2.png" alt="">
                    </div>
                    <div class="card-body tw-text-left">
                        <h5 class="card-title">Soins Dentaires Préventifs</h5>
                        <p v-html="truncatedText3"></p>
                        <a class="read-more no-line" @click="showFullText3 = !showFullText3">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                    </div>
                </div>
            
                <div class="card">
                    <div class="card-icon red">
                        <img src="/dental-implant.png" alt="">
                    </div>
                    <div class="card-body tw-text-left">
                        <h5 class="card-title">Implants Dentaires pour un Sourire Complet</h5>
                        <p v-html="truncatedText4"></p>
                        <a class="read-more no-line" @click="showFullText4 = !showFullText4">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                    </div>
                </div>
              
                <div class="card">
                    <div class="card-icon green">
                        <img src="/tooth.png" alt="">
                    </div>
                    <div class="card-body tw-text-left">
                        <h5 class="card-title">Traitements Esthétiques pour un Sourire Éblouissant</h5>
                        <p v-html="truncatedText5"></p>
                        <a class="read-more no-line" @click="showFullText5 = !showFullText5">Learn more <span class="fas fa-long-arrow-alt-right"></span></a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
  </div> 
  <hr class="section-divider" />

  <div id="details" class="basic-2">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-xl-7">
                <div class="image-container">
                    <img class="img-fluid" src="assets/images/second.png" alt="alternative" />
                </div> 
            </div> 
            <div class="col-lg-6 col-xl-5">
                <div class="text-container tw-mr-24">
                    <div class="section-title">CE QUE NOUS FAISONS</div>
                    <h2>Prendre soin de votre sourire et de votre santé bucco-dentaire</h2>
                    <p v-html="truncatedText2"></p>
                    <a class="btn-solid-reg" @click="showFullText2 = !showFullText2">Details</a>
                </div> 
            </div> 
        </div>
    </div> 
  </div>
  <hr class="section-divider" />

  <div class="basic-1 ">
    <div class="container tw-ml-40">
        <div class="row">
            <div class="col-lg-6 col-xl-6">
                <div class="text-container tw-mr-40">
                    <div class="section-title">À PROPOS DE NOUS</div>
                    <h2>Nous avons dix ans d'expérience</h2>
                    <p  v-html="truncatedText"></p>
                    <a class="btn-outline-reg tw-mb-5" @click="showFullText = !showFullText">Details</a>
                </div> 
            </div> 
            <div class="col-lg-6 col-xl-6">
                <div class="image-container tw-ml-10">
                    <img style="width: 70%;" class="img-fluid" src="assets/images/third.png" alt="alternative" />
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

  <!-- <div id="features" class="accordion-1">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <h2 class="h2-heading">Online service features</h2>
                <p class="p-heading">Suspendisse vitae enim arcu. Aliquam convallis risus a felis blandit, at mollis nisi bibendum. Aliquam nec purus at ex blandit posuere nec a odio. Proin lacinia dolor justo</p>
            </div> 
        </div>   
        <div class="row">
            <div class="col-xl-5">
                <div class="accordion" id="accordionExample">
                    
                   
                    <div class="accordion-item">
                        <div class="accordion-icon">
                            <span class="fas fa-tv"></span>
                        </div> 
                        <div class="accordion-header" id="headingOne">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Analyse the product and design plan
                            </button>
                        </div>
                        <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">Mauris ornare libero et pharetra hendrerit. Cura elementum lectus quis tellus pretium, vitae lobortis dui sagittis aliquam et enim vel semon anticus</div>
                        </div>
                    </div>
                   
                   
                    <div class="accordion-item">
                        <div class="accordion-icon blue">
                            <span class="fas fa-microphone"></span>
                        </div> 
                        <div class="accordion-header" id="headingTwo">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Find the market opportunities
                            </button>
                        </div>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">Mauris ornare libero et pharetra hendrerit. Cura elementum lectus quis tellus pretium, vitae lobortis dui sagittis aliquam et enim vel semon anticus</div>
                        </div>
                    </div>
                   
                   
                    <div class="accordion-item">
                        <div class="accordion-icon purple">
                            <span class="fas fa-video"></span>
                        </div> 
                        <div class="accordion-header" id="headingThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Prepare the product launch campaign
                            </button>
                        </div>
                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body">Mauris ornare libero et pharetra hendrerit. Cura elementum lectus quis tellus pretium, vitae lobortis dui sagittis aliquam et enim vel semon anticus</div>
                        </div>
                    </div>
                   
                    
                   
                    <div class="accordion-item">
                        <div class="accordion-icon orange">
                            <span class="fas fa-tools"></span>
                        </div> 
                        <div class="accordion-header" id="headingFour">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                Evaluate the campaign and adjust
                            </button>
                        </div>
                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                            <div class="accordion-body">Mauris ornare libero et pharetra hendrerit. Cura elementum lectus quis tellus pretium, vitae lobortis dui sagittis aliquam et enim vel semon anticus</div>
                        </div>
                    </div>
                   
                </div> 
            </div> 
            <div class="col-xl-7">
                <div class="image-container">
                    <img class="img-fluid" src="assets/images/features-dashboard.png" alt="alternative"/>
                </div> 
            </div> 
        </div>
    </div> 
  </div>  -->
  
  <!-- <div class="slider-1">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h4>Trusted by over <span class="blue">5000</span> customers worldwide</h4>
                <hr class="section-divider" />
             
                <div class="slider-container">
                    <div class="swiper-container image-slider">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-1.png" alt="alternative" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-2.png" alt="alternative" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-3.png" alt="alternative" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-4.png" alt="alternative" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-5.png" alt="alternative" />
                            </div>
                            <div class="swiper-slide">
                                <img class="img-fluid" src="assets/images/customer-logo-6.png" alt="alternative" />
                            </div>
                        </div>
                    </div> 
                </div> 
               
            </div> 
        </div>
    </div> 
  </div> 
  ]
  <div class="basic-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="text-container">
                    <h2>Find the right influencer for your product</h2>
                    <p class="p-large">Eu convallis arcu ultrices in. Mauris ornare libero et pharetra hendrerit. Curabitur elementum lectus quis vioc tellus</p>
                    <a class="btn-solid-lg" href="#contact">Get free quote</a>
                </div> 
            </div> 
        </div>
    </div> 
  </div>  -->
</div>
    <div v-else>
    <Login v-if="client"/>
    <Doctor v-if="doctor" />

    </div>
  </template>
  
  <script>
  import Popup from './Popup.vue'
  import Login from './Login.vue';
  import Doctor from './LoginDocteur.vue';
  import axios from 'axios';


  export default {
      data() {
      return {
        show: true,
        client: false,
        doctor: false,
        text: `Nous sommes ravis de vous accueillir à l'Hôpital Dentaire <strong>DENTAIREEXPRESS</strong>, votre destination privilégiée pour des soins dentaires d'exception. Notre équipe dévouée de professionnels qualifiés est passionnée par votre santé bucco-dentaire et est déterminée à offrir des services de premier ordre pour vous aider à atteindre un sourire éclatant et une santé dentaire optimale.<br>Notre hôpital dentaire moderne et chaleureux est équipé des dernières avancées technologiques pour assurer des traitements précis, efficaces et confortables. Des soins préventifs complets aux interventions dentaires complexes, nous sommes là pour vous accompagner à chaque étape de votre parcours de soins.<br>Chez <strong>DENTAIREEXPRESS</strong>, nous croyons en une approche personnalisée et centrée sur le patient. Notre équipe prendra le temps de vous écouter, de comprendre vos besoins et de répondre à toutes vos questions. Votre satisfaction et votre bien-être sont notre priorité absolue.\n\nExplorez notre site pour en savoir plus sur nos services, notre équipe médicale, et les témoignages de nos patients satisfaits. Prenez rendez-vous dès aujourd'hui pour découvrir comment nous pouvons améliorer votre sourire et votre santé dentaire. Faites confiance à l'Hôpital Dentaire Sourire Radieux pour des soins dentaires exceptionnels, car chaque sourire mérite d'être célébré !`,
        showFullText: false,
        showFullText2: false,
        showFullText3: false,
        showFullText4: false,
        showFullText5: false,
        welcomeDescription: `Bienvenue à l'Hôpital Dentaire <strong>DENTAIREEXPRESS</strong>! Nous sommes fiers de vous offrir une gamme complète de services dentaires de qualité pour prendre soin de votre sourire et de votre santé bucco-dentaire. Voici ce que nous faisons pour vous :
  
        <br><strong>1. Soins Dentaires Préventifs :</strong> La prévention est la clé d'une bonne santé dentaire. Nous vous proposons des examens réguliers, des nettoyages professionnels et des conseils personnalisés pour maintenir vos dents en excellente condition.
  
        <br><strong>2. Traitements Dentaires Restaurateurs :</strong> En cas de caries ou de dommages dentaires, notre équipe experte propose des traitements restaurateurs tels que des obturations, des couronnes et des restaurations esthétiques pour retrouver la fonction et l'apparence naturelle de vos dents.
  
        <br><strong>3. Implants Dentaires :</strong> Si vous avez perdu une ou plusieurs dents, nos solutions d'implants dentaires vous permettent de retrouver un sourire complet et une mastication efficace.
  
        <br><strong>4. Chirurgie Buccale :</strong> Nous réalisons des interventions chirurgicales dentaires avancées, telles que l'extraction des dents de sagesse et la préparation pour la pose d'implants.
  
        <br><strong>5. Orthodontie :</strong> Pour des dents droites et un sourire harmonieux, nous proposons des traitements d'orthodontie adaptés à vos besoins, y compris des appareils orthodontiques discrets tels que les aligneurs invisibles.
  
        <br><strong>6. Traitements Esthétiques :</strong> Votre sourire est notre priorité. Nous offrons des traitements esthétiques tels que le blanchiment des dents, les facettes dentaires et plus encore pour vous aider à obtenir le sourire dont vous rêvez.
  
        <br><strong>7. Urgences Dentaires :</strong> En cas d'urgence dentaire, notre équipe est disponible pour vous fournir des soins rapides et efficaces afin de soulager la douleur et de résoudre les problèmes.
  
  Chez l'Hôpital Dentaire Sourire Radieux, nous sommes dédiés à votre bien-être et à votre satisfaction. Notre équipe attentionnée et professionnelle est là pour vous accompagner tout au long de votre parcours dentaire. Prenez rendez-vous dès aujourd'hui et découvrez pourquoi nous sommes le choix idéal pour des soins dentaires de qualité et un sourire radieux.`,
        formattedDescription: "",
        text3:`Chez l'Hôpital Dentaire Éclat Dentaire, nous croyons en la puissance de la prévention pour maintenir votre sourire éclatant. Nos soins dentaires préventifs comprennent des examens réguliers, des nettoyages professionnels et des conseils personnalisés pour prendre soin de vos dents et de vos gencives. En identifiant les problèmes dès le début, nous pouvons prévenir les complications futures et vous aider à garder une excellente santé bucco-dentaire tout au long de votre vie.`,
        text4:` Si vous avez perdu une ou plusieurs dents, nos services d'implants dentaires sont là pour vous redonner le sourire complet que vous méritez. Nos dentistes expérimentés utilisent des techniques avancées pour placer des implants dentaires durables et esthétiques, offrant une solution permanente pour remplacer vos dents manquantes. Avec nos soins personnalisés, vous retrouverez une mastication efficace et un sourire radieux qui vous redonnera confiance en vous.`,
        text5:`Votre sourire est votre carte de visite, c'est pourquoi nous offrons une gamme complète de traitements esthétiques pour vous aider à obtenir un sourire éblouissant. Des techniques de blanchiment des dents aux facettes dentaires, nos traitements esthétiques sont conçus pour améliorer l'apparence de vos dents et vous offrir un sourire radieux. Nous sommes déterminés à créer un sourire personnalisé qui mettra en valeur votre beauté naturelle et vous permettra de rayonner de confiance.`,
        items: [
      { src:'/slid1.jpg',title:'Nouvelles technologies dentaires : Découvrez nos avancées médicales !'},
      { src:'/slid2.jpg',title:'Sourire éclatant : Nos dernières innovations pour des soins dentaires de pointe'},
      { src:'/slid3.jpg',title:'Inauguration de notre nouvel équipement : Les dernières avancées à votre service'},
      { src:'/slid4.jpg',title:'Offres spéciales du mois : Explorez nos dernières promotions dentaires'},
    ],     
     

      };
    },
    computed: {
      isTruncated() {
        return this.text.length > 50;
      },
      isTruncated2() {
        return this.formattedDescription.length > 50;
      },
      isTruncated3() {
        return this.text3.length > 50;
      },
      isTruncated4() {
        return this.text4.length > 50;
      },
      isTruncated5() {
        return this.text5.length > 50;
      },
      truncatedText() {
        if (this.showFullText) {
          return this.text;
        } else if (this.isTruncated) {
          return this.text.slice(0, 391);
        } else {
          return this.text;
        }
      },
      truncatedText2() {
        if (this.showFullText2) {
          return this.formattedDescription;
        } else if (this.isTruncated2) {
          return this.formattedDescription.slice(0, 300);
        } else {
          return this.formattedDescription;
        }
      },
      truncatedText3() {
        if (this.showFullText3) {
          return this.text3;
        } else if (this.isTruncated2) {
          return this.text3.slice(0, 125);
        } else {
          return this.text3;
        }
      },
      truncatedText4() {
        if (this.showFullText4) {
          return this.text4;
        } else if (this.isTruncated2) {
          return this.text4.slice(0, 142);
        } else {
          return this.text4;
        }
      },
      truncatedText5() {
        if (this.showFullText5) {
          return this.text5;
        } else if (this.isTruncated2) {
          return this.text5.slice(0, 165);
        } else {
          return this.text5;
        }
      },
    },
    created() {
      this.formatDescription();
      this.show=true
   

    },
    methods: {
      formatDescription() {
        this.formattedDescription = this.welcomeDescription.replace(
          /<strong>(.*?)<\/strong>/g,
          "<strong><span style='font-weight: bold;'>$1</span></strong>"
        );
      },
     
  
    },
    components: {
    Doctor,
    Login,
    Popup,
    },
  };
  
  
  
  
  </script>
  
  
  <style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }
  
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
  