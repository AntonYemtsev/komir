@extends('index.top')

@section('layout')
    <?php
    $action_name = "";
    $controller_name = "";
    $current_path_parts = explode("/",Route::getFacadeRoot()->current()->uri());
    if(isset($current_path_parts[0])){
        $controller_name = $current_path_parts[0];
    }
    if(isset($current_path_parts[1])){
        $action_name = $current_path_parts[1];
    }
	?>

<body>

    <meta name="csrf-token" content="{{ csrf_token() }}" />

	@yield('content')
   
    <script>
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    </script>
</body>

@endsection