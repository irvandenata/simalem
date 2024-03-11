@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush

@push('style')
@endpush

@section('content')
  <div class="row">
    <div class="col-xl-12 col-xxl-12 ">
      <div class="w-100">
        <div class="row">
          <div class="col-12">
            <div class="card p-4">
              <div class="text-right">
                <a href="{{ $createLink }}" class="btn btn-success btn-sm mb-2">Tambah Data</a>
                <div class="btn btn-outline-warning btn-sm mb-2" onclick="reloadDatatable()">Reload Data</div>
              </div>
              <div class="text-right row my-4">
                <div class="form-group col-3">
                  <label for="" class="label mb-2">Tempat</label>
                  <select name="" id="hospital" class="form-control select2">
                    <option value="all">All</option>
                    @foreach ($hospitals as $item)
                      <option value="{{ $item->hospital }}">{{ $item->hospital }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="" class="label mb-2">Alat</label>
                  <select name="" id="item" class="form-control select2">
                    <option value="all">All</option>
                    @foreach ($items as $item)
                      <option value="{{ $item->id }}">{{ $item->name }} - Merk : {{ $item->brand }} - Tipe :
                        {{ $item->type }}</option>
                    @endforeach
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="" class="label mb-2">Kondisi Alat</label>
                  <select name="" id="condition" class="form-control ">
                    <option value="all">All</option>
                    <option value="0">Normal</option>
                    <option value="1">Rusak</option>
                    <option value="2">Perbaikan</option>
                    <option value="3">Berkendala</option>
                  </select>
                </div>
                <div class="form-group col-3">
                  <label for="" class="label mb-2">Maintenance Ke</label>
                  <select name="" id="maintenance" class="form-control ">
                    <option value="all">All</option>
                    <option value="0">Belum Pernah</option>
                    <option value="1">Pertama</option>
                    <option value="2">Kedua</option>
                    <option value="3">Ketiga</option>
                  </select>
                </div>
                <div class="form-group col-3 mt-4">
                  <label for="" class="label mb-2">Status Garansi</label>
                  <select name="" id="warranty" class="form-control">
                    <option value="all">All</option>
                    <option value="1">Berlaku</option>
                    <option value="2">Tidak Berlaku</option>
                  </select>
                </div>
                <div class="form-group col-3 mt-4 d-flex align-items-end">
                  <button id="reset" class="btn btn-success" style="height: 40px">Reset</button>
                </div>
              </div>
              <div >
                <table id="datatable" style="max-width:100% !important" class="table table-responsive m-t-30 table-striped">
                  <thead>
                    <tr>
                      <th>No</th>
                      @foreach ($rows['name'] as $item)
                        <th>{{ $item }}</th>
                      @endforeach
                      <th width="10%">Action</th>
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
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush

@push('script')
  @include('utils.js')
  <script>
    sessionStorage.setItem('location', null)
    sessionStorage.setItem('room', null)


    $('.select-room').select2({
      ajax: {
        url: "/api/get-rooms",
        data: function(params) {
          var data = {
            data: params.term
          }
          return data;
        },
        processResults: function(data) {
          tampEquipment = data
          return {
            results: $.map(data, function(item) {
              return {
                text: item.name,
                id: item.name,
              }
            })
          }
        }
      },
      placeholder: "--- Select an Option ---",
      allowClear: true
    });

    $('.select-location').select2({
      ajax: {
        url: "/api/get-rooms",
        data: function(params) {
          var data = {
            data: params.term
          }
          return data;
        },

      },
      placeholder: "--- Select an Option ---",
      allowClear: true
    });

    $('.select-2').select2();
    $('.select-location').on('change', function() {
      sessionStorage.setItem('location', $(this).val())
      reloadDatatable();
    })
    $('.select-room').on('change', function() {
      sessionStorage.setItem('room', $(this).val())
      reloadDatatable();
    })

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
        url: child_url,
        type: 'GET',
        data: function(d) {
          d.hospital = $('#hospital').val()
          d.item = $('#item').val()
          d.condition = $('#condition').val()
          d.maintenance = $('#maintenance').val()
          d.warranty = $('#warranty').val()
        },
      },

      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false

        },
        @foreach ($rows['column'] as $item)
          {
            data: '{{ $item }}',
            orderable: true,
          },
        @endforeach {
          data: 'action',
          name: '#',
          orderable: false,
          searchable: false
        },
      ]
    });
  </script>

  <script>
    function deleteItem(id) {
      deleteConfirm(id)
    }
  </script>

  <script>
    let limitOrder = 0;
    /** reload dataTable Setelah mengubah data**/
function copyLink(code) {
    var link = '{{ url('/') }}/report-problem/' + code ;
    var dummy = document.createElement("textarea");
    document.body.appendChild(dummy);
    dummy.value = link;
    dummy.select();
    document.execCommand("copy");
    document.body.removeChild(dummy);

    }
    $('#hospital').on('change', function() {
      reloadDatatable();
    })
    $('#item').on('change', function() {
      reloadDatatable();
    })
    $('#condition').on('change', function() {
      reloadDatatable();
    })
    $('#maintenance').on('change', function() {
      reloadDatatable();
    })
    $('#warranty').on('change', function() {
      reloadDatatable();
    })
    $('#reset').on('click', function() {
      $('#hospital').val('all').trigger('change')
      $('#item').val('all').trigger('change')
      $('#condition').val('all')
      $('#maintenance').val('all')
      $('#warranty').val('all')
      reloadDatatable();
    })
    function reloadDatatable() {
      dataTable.ajax.reload(null, false);

    }

    function preview(e) {
      if (e.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#preview>img').attr('src', e.target.result);
        }
        reader.readAsDataURL(e.files[0]);
        $('#preview>img').removeClass('d-none');
      }
    }

  </script>
@endpush
