@include('admin.partial.header')


    <aside class="main-sidebar sidebar-dark-primary elevation-4">

           @include('admin.partial.sidebar')

    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @include('admin.partial.breadcumb')
      @yield('main-content')
    </div>

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
     @include('admin.partial.footer')