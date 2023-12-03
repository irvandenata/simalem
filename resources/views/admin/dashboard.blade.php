@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <style>
    .data .bx-devices:before {
      padding: 4px;
      background-color: rgb(255, 254, 234);
      border-radius: 10px;
      color: rgb(244, 248, 0);
    }

    .data .bx-task {
      padding: 3px;
      background-color: rgb(224, 255, 243);
      border-radius: 10px;
      color: rgb(42, 255, 184);
    }

    .data .bx-collection {
      padding: 3px;
      background-color: rgb(255, 227, 226);
      border-radius: 10px;
      color: rgb(255, 51, 51);
    }

    .data .bx-user-plus {
      padding: 2px;
      background-color: rgb(255, 234, 214);
      border-radius: 10px;
      color: rgb(255, 131, 49);
    }
  </style>
@endpush
@section('content')
  <div class="row">
    <!--/ Total Revenue -->
    <div class="col-12">
      <div class="row data">
        <div class="col-lg-3 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">

                  <i class="menu-icon tf-icons  bx bx-user-plus" style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Users</span>
                  <h3 class="card-title text-nowrap mb-2">0 People</h3>
                  <h3 class="card-title text-nowrap mb-2">0 New</h3>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Show Article</span>
                  <h3 class="card-title text-nowrap mb-2">0 Activity</h3>
                  <h3 class="card-title text-nowrap mb-2">0 User</h3>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Show Ads</span>
                  <h3 class="card-title text-nowrap mb-2">0 Activity</h3>
                  <h3 class="card-title text-nowrap mb-2">0 User</h3>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Test</span>
                  <h3 class="card-title text-nowrap mb-2">0 Activity</h3>
                  <h3 class="card-title text-nowrap mb-2">0 User</h3>
                </div>
              </div>
            </div>
          </div>
        </div>


      </div>
    </div>
    <!-- Total Revenue -->
    <div class="col-lg-12 col-12 col-xs-12  mb-4">
      <div class="card">
        <div class="row row-bordered g-0">
          <div class="col-12">
            <h4 class="card-header m-0 me-2 pb-3">User Activity</h4>
            <div id="totalRevenueChart" class="px-2"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@push('script')
  <script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
  <script src="{{ asset('assets/js/dashboard.js') }}"></script>
@endpush

@push('js')

@endpush
