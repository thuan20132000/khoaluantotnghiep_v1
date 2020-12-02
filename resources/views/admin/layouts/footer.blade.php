
<!-- jQuery -->
<script src="{{ asset('theme/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src=" {{ asset('theme/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- DataTables --}}
<script src="{{asset('js/style.js')}}"></script>
<script src="{{ asset('libs/toastr.min.js') }}"></script>


<script src="{{ asset('theme/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('theme/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('theme/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('theme/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('theme/dist/js/adminlte.js') }}"></script>


<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('theme/plugins/chart.js/Chart.js') }}"></script>
<script src="{{ asset('theme/dist/js/demo.js') }}"></script>
<script src="{{ asset('theme/dist/js/pages/dashboard3.js') }}"></script>

<script src=" {{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script src="{{asset('js/helper.js')}}"></script>

<script >
    $(function () {

        $("#example2").DataTable({
            "responsive": true,
            "autoWidth": false,
        });
        // $('#example2').DataTable({
        //     "paging": true,
        //     "lengthChange": false,
        //     "searching": false,
        //     "ordering": false,
        //     "info": true,
        //     "autoWidth": false,
        //     "responsive": true,
        // });

    });


$('#lfm').filemanager('image');

</script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
  <script>
    AOS.init();
  </script><!-- s -->

</body>
</html>
