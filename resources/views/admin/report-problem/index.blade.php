@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

@push('style')
  <style>
    #datatable_filter {
      margin-bottom: 10px !important;
    }
  </style>
@endpush

@section('content')
  <div class="row">
    <div class="col-lg-12 order-2 order-md-3 order-lg-2 mb-4">
      <div class="card p-4">
        <div class="text-right">
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
              <label for="" class="label mb-2">Status Tanggapan</label>
              <select name="" id="status" class="form-control ">
                <option value="all">All</option>
                <option value="0">Belum Ditanggapi</option>
                <option value="1">Sudah Ditanggapi</option>
                <option value="2">Selesai</option>
              </select>
            </div>

            <div class="form-group col-3 mt-4 d-flex align-items-end">
              <button id="reset" class="btn btn-success" style="height: 40px">Reset</button>
            </div>
          </div>
        <div class="table-responsive">
          <table id="datatable" style="max-width:100% !important" class="table m-t-30">
            <thead>
              <tr>
                <th>No</th>
                <th width="10%">Action</th>
                @foreach ($rows['name'] as $item)
                  <th>{{ $item }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @include($view . '._form')
@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/i1nnds4l5jeoaufjhsu6l45pa8zxzdwc4vwh9dktv8d5gig4/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
@endpush

@push('script')
  @include('utils.js')
  <script>
    tinymce.init({
      selector: 'textarea#myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
      plugins: 'code table lists',
      toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });
    $('.select-2').select2();
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
        data: function(data) {
          data.hospital = $('#hospital').val();
          data.item = $('#item').val();
          data.status = $('#status').val();
        }
      },
      columns: [{
          data: 'DT_RowIndex',
          orderable: false,
          searchable: false
        },
        {
          data: 'action',
          name: '#',
          orderable: false,
          searchable: false
        },
        @foreach ($rows['column'] as $item)
          {
            data: '{{ $item }}',
            orderable: true,
          },
        @endforeach
      ]
    });

    $('#reset').on('click', function() {
      $('#hospital').val('all').trigger('change');
      $('#item').val('all').trigger('change');
      $('#status').val('all').trigger('change');
      reloadDatatable();
    })
    $('#hospital').on('change', function() {
      reloadDatatable();
    })
    $('#item').on('change', function() {
      reloadDatatable();
    })
    $('#status').on('change', function() {
      reloadDatatable();
    })
  </script>

  <script>
    function createItem() {
      setForm('create', 'POST', ('Tambah {{ $title }}'), true)
      $('#preview>img').addClass('d-none');
      $('#preview>img').attr('src', '');
    }

    function editItem(id) {

      setForm('update', 'PUT', 'Edit {{ $title }}', true)
      editData(id)
    }

    function deleteItem(id) {
      deleteConfirm(id)

    }
  </script>

  <script>
    /** set data untuk edit**/
    function setData(result) {
      $('input[name=id]').val(result.id);
      $('input[name=name]').val(result.name);
      $('select[name=type]').val(result.type).trigger('change');
      $('select[name=brand]').val(result.brand).trigger('change');
    }


    /** reload dataTable Setelah mengubah data**/
    function reloadDatatable() {
      dataTable.ajax.reload();
    }

    $(".select2creation").select2({
      tags: true,
      dropdownParent: $('.modal')
    });
  </script>
@endpush
