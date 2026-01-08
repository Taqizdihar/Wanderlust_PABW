<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Organizer Dashboard</title>
    <link rel="stylesheet" href="{{ asset('css/dashboardPTW.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    @include('partials.ptw.sidebar_ptw')

    <div class="main-content">
        
        @include('partials.ptw.header_ptw')

        <div class="content-body">
            @yield('content')
        </div>
    </div>

</body>
</html>