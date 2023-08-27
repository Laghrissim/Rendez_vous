<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
   <!-- Template Main CSS File -->
      <!-- Styles -->
      <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
      <link href="assets/css/bootstrap.min.css" rel="stylesheet"> 
      <link href="assets/css/fontawesome-all.min.css" rel="stylesheet">
      <link href="assets/css/swiper.css" rel="stylesheet">
      <link href="assets/css/styles.css" rel="stylesheet">
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"> --}}
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ mix('resources/css/app.css') }}">

        <title>Rendez-vous Website</title>
     
        

    </head>
    <body class="antialiased">
        <div class="flex-center position-ref full-height" id="app">
            
             <login></login>  
                 
       
        </div>
        <script src="{{ mix('resources/js/app.js') }}" type="module"></script>

    </body>
</html>
