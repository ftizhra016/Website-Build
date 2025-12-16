<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ $title }}</title>

  <!-- custom style -->
  @stack('style')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>

<body>
  <div class="wrapper">
    @include('components.partials.sidebar')

    <!-- Content -->
    <div id="content" class="content">
      @include('components.partials.top-navbar')
      
      <!-- Card -->
      <div class="px-4">
        {{ $slot }}
      </div>

    </div>
  </div>

  <script src="{{ asset('js/dashboard.js') }}"></script>

  <!-- plugin -->
  <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  @stack('plugin')

  <!-- custom script -->
  @stack('script')
</body>

</html>