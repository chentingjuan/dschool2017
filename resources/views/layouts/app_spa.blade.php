<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (isset($meta_og))
        <title>{{$meta_og['title']}}</title>
        <meta property="og:title" content="{{$meta_og['title']}}">
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{url()->current()}}">
        <meta property="og:image" content="{{$meta_og['cover']}}">
        <meta property="og:description" content="{{$meta_og['description']}}">
    @else
       <title>D-School 臺大創新設計學院</title>
      <meta property="og:title" content="D-School 臺大創新設計學院">
      <meta property="og:type" content="website">
      <meta property="og:image" content="">
      <meta property="og:description" content="D-School 臺大創新設計學院">
  
    @endif


      <meta name="google-site-verification" content="rjddDPy5PhR_RofqCyriMeBqtEdESBMhbuQxFBvKi2g">

      <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <!-- <link href="{{ asset('css/overwrite/master.css') }}" rel="stylesheet"> -->

    <link href="https://fonts.googleapis.com/earlyaccess/notosanstc.css" rel="stylesheet">

    <!-- Scripts -->
    <script>
      window.Laravel = {!! json_encode([
      'csrfToken' => csrf_token(),
      ]) !!};
      window.csrf_token = "{{ csrf_token() }}";
      window.user = {!! json_encode(
       Auth::user()
      ) !!};
    </script>

  </head>
  <body class="lang_all">
  
    <App id="app"></App>
    @yield('blade_pass_variables')
    {{-- Script BEFORE app.js --}}
    @yield('require_js')
    <script>
    if (document.domain.indexOf("dschool2017.dev")!=-1){
        document.write('<script src="http://' + (location.host || 'localhost').split(':')[0] +':35729/livereload.js?snipver=1"></' + 'script>');
      }
    </script>
    <script async src="/js/app.js"></script>
     {{-- Script AFTER app.js --}}
    @yield('require_js_after')
  </body>
</html>