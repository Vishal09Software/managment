<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Dashboard - Admin Panel</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  @include('admin.layouts.header')


</head>
<body>

  @include('admin.layouts.topbar')

  @include('admin.layouts.sidebar')

    @yield('main-container')

  @include('admin.layouts.footer')
  @include('admin.layouts.script')

</body>
</html>
