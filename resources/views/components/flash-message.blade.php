@if(session()->has('message'))
  <script>
    toastr.success("{{ Session::get('message') }}");
  </script>
@endif

@if(session()->has('warning'))
  <script>
    toastr.warning("{{ Session::get('warning') }}");
  </script>
@endif