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
        <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">

                  <i class="menu-icon tf-icons  bx bx-user-plus" style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Alat Terinstall</span>
                  <div class="row">
                    <div class="col-6">
                      <small class="card-title text-nowrap mb-2">Total {{ $allItem }}</small>

                    </div>
                    <div class="col-6">
                      <small class="card-title text-nowrap mb-2">Normal {{ $goodCondition }}</small>

                    </div>
                    <div class="col-6">
                      <small class="card-title text-nowrap mb-2">Rusak {{ $badCondition }}</small>

                    </div>
                    <div class="col-6">
                      <small class="card-title text-nowrap mb-2">Berkendala {{ $reportCondition }}</small>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Laporan Perlu Tanggapan</span>
                  <h1 class="card-title text-nowrap mb-2">{{ $reportProblem }}</h1>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-xs-12 col-sm-12 col-md-12 mb-4">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-4 my-auto">
                  <i class="menu-icon tf-icons bx bx-task bg-transparent-blue"
                    style="font-size:50px;text-align:center;height:100%"></i>
                </div>
                <div class="col-8">
                  <span class="d-block">Rumah Sakit</span>
                  <h1 class="card-title text-nowrap mb-2">{{ $hospital->count() }}</h1>
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
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12">
                    <div class="text-right">
                        <div class="btn btn-outline-warning btn-sm mb-2" onclick="reloadDatatable()">Reload Data</div>
                      </div>
                    <div class="table-responsive">

                      <table id="datatable" style="max-width:100% !important" class="table m-t-30">
                        <thead>
                          <tr>
                            <th>No</th>
                            <th>Nama Rumah Sakit</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Jumlah Alat</th>
                          </tr>
                        </thead>
                        <tbody>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection


@push('script')
  <script>
    let dataTable = $('#datatable').DataTable({
      dom: 'lBfrtip',
      responsive: true,
      processing: true,
      serverSide: true,
      searching: true,
      pageLength: 5,
      lengthMenu: [
        [5, 10, 15, -1],
        [5, 10, 15, "All"]
      ],
      ajax: {
        url: "{{ route('admin.dashboard.data') }}",
        type: 'GET',
      },
      columns: [
        {
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'hospital',
          orderable: true,
          searchable: true
        },
        {
          data: 'address',
          orderable: true,
          searchable: true
        },
        {
          data: 'contact_person',
          orderable: true,
          searchable: true
        },
        {
          data: 'total',
          orderable: true,
          searchable: true
        },
      ]
    });

    //add button reloa
    function reloadDatatable() {
      dataTable.ajax.reload();
    }
  </script>
@endpush
