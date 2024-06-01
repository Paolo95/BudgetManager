<!DOCTYPE html>
<html lang="it">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  
  @vite('resources/css/app.css')
  @vite('resources/css/sidebar.css')
  @vite('resources/css/home.css')
  @vite('resources/css/dashboard.css')
  @vite('resources/css/navbar.css')

  @vite('resources/js/app.js')
  @vite('resources/js/todoUpdater.js')
  
  <link rel="icon" href="images/favicon.ico" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

  <script src="//unpkg.com/alpinejs" defer></script>
  
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

  <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
  
  <title>{{ $title ?? 'Budget Manager | Amministra le tue finanze!' }}</title>
</head>

<body>

  <nav class="navigation-bar flex justify-between items-center">
    <a href="/"><img class="w-24" src="{{asset('images/logo.png')}}" alt="" class="logo" /></a>
    <ul class="flex space-x-6 mr-6 text-lg">
      @auth
      <li>
        <span class="font-bold">
          Bentornato {{auth()->user()->name}}
        </span>
      </li>      
      <li>
        <a href="/dashboard/home" class="hover:text-laravel"><i class="fas fa-border-all"></i> Dashboard</a>
      </li>
      <li>
        <form class="inline" method="POST" action="/logout">
          @csrf
          <button type="submit" class="hover:text-laravel">
            <i class="fa-solid fa-door-closed hover:text-laravel"></i> Logout
          </button>
        </form>
      </li>
      @else
      <li>
        <a href="/register" class="hover:text-laravel"><i class="fa-solid fa-user-plus"></i> Registrati</a>
      </li>
      <li>
        <a href="/login" class="hover:text-laravel"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</a>
      </li>
      @endauth
    </ul>
  </nav>

  
  <div class="content">
    {{$slot}}
  </div>
  
  <footer class="flex items-center font-bold bg-laravel text-white h-20 mt-16 opacity-90 md:justify-center">
    <p class="ml-2">Copyright &copy; 2024, Tutti i diritti riservati</p>
  </footer>

  <x-flash-message />

</body>

</html>