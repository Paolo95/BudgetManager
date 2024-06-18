@if(session()->has('message'))
  <script>
    toastr.success("{{ Session::get('message') }}");
  </script>
@endif