
<footer class="main-footer">
    <strong>Copyright &copy; 2021 <a href="https://www.messenger.com/t/100012069192979" target="_blank">Shahinul islam sujon</a></strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Version</b> 1.0.0
    </div>
</footer>
</div>
<!-- <script     >
    CKEDITOR.replace( 'summary-ckeditor' );
</script> -->
<script     src="{{asset('/assets/admin')}}/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script    src="{{asset('/assets/admin')}}/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script    src="{{asset('/assets/admin')}}/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script    src="{{asset('/assets/admin')}}/jquery.mousewheel.js"></script>
<script    src="{{asset('/assets/admin')}}/raphael.min.js"></script>
<script    src="{{asset('/assets/admin')}}/jquery.mapael.min.js"></script>
<script    src="{{asset('/assets/admin')}}/usa_states.min.js"></script>
<!-- ChartJS -->
<script    src="{{asset('/assets/admin')}}/Chart.min.js"></script>
<script    src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<!-- AdminLTE for demo purposes -->
<script    src="{{asset('/assets/admin')}}/demo.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- <script    src="//cdn.ckeditor.com/4.14.1/full/ckeditor.js"></script> -->
{{--<script    src="{{asset('admin')}}/dashboard2.js"></script>--}}

<script>
     $('.select2').select2();

     toastr.options = {
  "closeButton": false,
  "debug": false,
  "newestOnTop": false,
  "progressBar": false,
  "positionClass": "toast-top-right",
  "preventDuplicates": false,
  "onclick": null,
  "showDuration": "300",
  "hideDuration": "1000",
  "timeOut": "5000",
  "extendedTimeOut": "1000",
  "showEasing": "swing",
  "hideEasing": "linear",
  "showMethod": "fadeIn",
  "hideMethod": "fadeOut"
}


</script>
<script>
    @if(Session::get('success')) 
    toastr.success('{!! Session::get('success') !!}')
    @endif
    @if(Session::get('error'))
    toastr.success('{!! Session::get('error') !!}')   
    @endif    
</script>


</body>
</html>
