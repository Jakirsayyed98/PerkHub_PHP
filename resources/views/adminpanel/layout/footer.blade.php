<footer class="main-footer text-sm">
  <div class="d-flex justify-content-between align-items-center">
    <div>
      <strong>
        Copyright &copy; {{ date('Y') }}
        <a href="https://www.perkhub.in" target="_blank">PerkHub</a>.
      </strong> 
      All rights reserved.
    </div>
    <div>
      <b>Admin Panel</b> v1.0.0
    </div>
  </div>
</footer>

<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Add any custom control sidebar content here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="{{ asset('adminpanel/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI -->
<script src="{{ asset('adminpanel/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button) // Resolve jQuery UI and Bootstrap conflict
</script>

<!-- Bootstrap 4 -->
<script src="{{ asset('adminpanel/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('adminpanel/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('adminpanel/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('adminpanel/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('adminpanel/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- Daterangepicker -->
<script src="{{ asset('adminpanel/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('adminpanel/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('adminpanel/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('adminpanel/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('adminpanel/dist/js/adminlte.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('adminpanel/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('adminpanel/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Page specific scripts -->
<script>
  $(function () {
    // DataTable Init
    $("#example1").DataTable({
      responsive: true,
      lengthChange: false,
      autoWidth: false,
      buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
      paging: true,
      lengthChange: false,
      searching: false,
      ordering: true,
      info: true,
      autoWidth: false,
      responsive: true,
    });

    // Summernote Init
    $('#compose-textarea, #compose-textarea1').summernote({
      height: 150,
      placeholder: 'Write here...'
    });
  });
</script>

</body>
</html>
