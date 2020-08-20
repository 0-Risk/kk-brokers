<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('inc.header', [ 'title' => $title])
<body>
    <div class="container-fluid">
        @yield('content')
    </div>
</body>
@include('inc.footer')
</html>
