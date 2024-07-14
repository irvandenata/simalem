<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default"
  data-assets-path="{{ asset('assets') }}/" data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>SIMALEM</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="{{ asset('assets') }}/img/favicon/favicon.ico" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" type="text/css"
    href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.jqueryui.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">

  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
    integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/css/theme-default.css"
    class="template-customizer-theme-css" />
  <link rel="stylesheet" href="{{ asset('assets') }}/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="{{ asset('assets') }}/vendor/libs/apex-charts/apex-charts.css" />
  {{-- <link rel="stylesheet" href="{{ asset('assets') }}/css/datatable.css" /> --}}

  <link href="https://fonts.cdnfonts.com/css/poppins" rel="stylesheet">
  <style>
    *,
    body {
      font-family: 'Poppins', sans-serif !important;
    }

    .page-item.active .page-link {
      z-index: 2;
    }
  </style>
  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="{{ asset('assets') }}/vendor/js/helpers.js"></script>
  <script src="{{ asset('assets') }}/js/config.js"></script>


  @stack('css')
  @stack('style')
  @include('layouts.admin-css')

</head>

<body>
  <div class="overlay">
    <div class="loader-container">
      <div class="loader spinner-border spinner-border-lg text-primary">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="container-fluid">


      <!-- Layout container -->
      <div class="">
        <!-- Navbar -->


        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="">
            @yield('content')
          </div>
          <!-- / Content -->

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                ©
                <script>
                  document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by
                Simalem
              </div>

            </div>
          </footer>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->



  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="{{ asset('assets') }}/vendor/libs/jquery/jquery.js"></script>
  <script src="{{ asset('assets') }}/vendor/libs/popper/popper.js"></script>
  <script src="{{ asset('assets') }}/vendor/js/bootstrap.js"></script>
  <script src="{{ asset('assets') }}/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="{{ asset('assets') }}/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="{{ asset('assets') }}/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="{{ asset('assets') }}/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/js/all.min.js"
    integrity="sha512-naukR7I+Nk6gp7p5TMA4ycgfxaZBJ7MO5iC3Fp6ySQyKFHOGfpkSZkYVWV5R7u7cfAicxanwYQ5D1e17EfJcMA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <!-- Page JS -->
  {{-- <script src="{{ asset('assets') }}/js/dashboards-analytics.js"></script> --}}
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"
    integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="{{ asset('assets') }}/js/datatable.js"></script>
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
  <script src="https://cdn.datatables.net/responsive/2.2.3/js/responsive.bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: true,
      didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
      }
    })

    $('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true,
      width: 'resolve',
      height: 'resolve'
    });
  </script>
  <script>
    $('.close-modal').on('click', function() {
      $('.modal').modal('hide');
    });

    //function for show image with modal

    function showImage(item) {
      Swal.fire({
        title: 'Image Preview',
        imageUrl: $(item).attr('src'),
        imageWidth: 400,
        imageAlt: 'Image Preview',
        confirmButtonText: 'Close',
      })
    }



    @if (Session::get('errors'))

      @foreach (session('errors') as $error)
        Toast.fire({
          icon: 'error',
          title: '{{ $error }}'
        })
      @endforeach
    @endif


    @if (Session::get('error'))

      Toast.fire({
        icon: 'error',
        title: '{{ Session::get('error') }}'
      })
    @endif
    @if (Session::get('success'))

      Toast.fire({
        icon: 'success',
        title: '{{ Session::get('success') }}'
      })
    @endif
    function showImage(item) {
      Swal.fire({
        title: 'Image Preview',
        imageUrl: $(item).attr('src'),
        imageAlt: 'Image Preview',
        customClass: 'swal-wide',
        showConfirmButton: false,
        showCloseButton: true,
      })
    }
  </script>


  <!-- Place this tag in your head or just before your close body tag. -->
  @stack('js')
  @stack('script')

  <script>
    $(document).ready(function() {
      $('.overlay').hide();
      $('.dropdown-notifications-archive').on('click', function() {
        $(this).parent().parent().parent().remove();

        $.ajax({
          url: "{{ route('admin.read-notif') }}" + "?id=" + $(this).data('id'),
          type: 'GET',
          success: function(result) {
            console.log(result);
          }
        });
      });
    });
  </script>
</body>

</html>
