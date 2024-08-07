@extends('layouts.admin')

@section('title', $title)
@section('breadcrumb', $breadcrumb)

@push('css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-modal/2.2.6/css/bootstrap-modal.min.css"
    integrity="sha512-888I2nScRzrb/WNZ3qsa5kiZNmaEsvz8HEVQZRGokIEOj/sMnUlLClqP7itKJYDhXWsmp+1usxoCidSEfW2rWw=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
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
              <form action="{{ $storeLink }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="name">Rumah Sakit</label>
                      <select name="hospital" class="form-control select2creation" required>
                        <option value="" selected disabled>Pilih Atau Tambah Rumah Sakit</option>
                        @foreach ($hospitals as $item)
                          <option value="{{ $item->hospital }}">{{ $item->hospital }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Alamat Rumah Sakit</label>
                     <textarea name="address" id="" cols="30" rows="5" class="form-control">{{ old('address')  }}</textarea>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Kontak Person </label>
                    <input type="text" placeholder="Masukkan Nomor Kontak" value="{{ old('contact_person') }}"
                    name="contact_person" class="form-control" onkeyup="this.value = this.value.replace(/[^\d]/,'')" >
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="title">Pilih Alat Elektromedik</label>
                      <select name="item_id" id="" class="form-control select2" required>
                        @foreach ($items as $item)
                          <option disabled selected value="">Select an Option</option>
                          <option value="{{ $item->id }}">{{ $item->name }} - Merek : {{ $item->brand }} - Tipe :
                            {{ $item->type }} </option>
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Serial Number</label>
                    <input type="text" placeholder="Masukkan Serial Number Alat" name="serial_number" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Nomor PO</label>
                    <input type="text" placeholder="Masukkan Nomor PO" name="po_number" class="form-control" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Tanggal Installasi</label>
                      <input type="date"
                       name="date_installed"  onfocus="this.showPicker()"  class="form-control"
                      id="installed_date" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Tanggal Akhir Garansi</label>
                      <input type="date"  onfocus="this.showPicker()" name="warranty_date" class="form-control" id="warranty_date" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Tanggal Maintenance Pertama</label>
                      <input type="date"  onfocus="this.showPicker()" name="maintenance_date_first" class="form-control" id="maintenance_first" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Tanggal Maintenance Kedua</label>
                      <input type="date"  onfocus="this.showPicker()" name="maintenance_date_second" class="form-control" id="maintenance_second" required>
                    </div>
                  </div>
                  <div class="form-group mb-3 col-12">
                    <div class="form-line">
                      <label for="source">Tanggal Maintenance Ketiga</label>
                      <input type="date"  onfocus="this.showPicker()" name="maintenance_date_third" class="form-control" id="maintenance_third" required>
                    </div>
                  </div>
                </div>
                <div class="mt-4">
                  <a href="{{ $indexLink }}" class="btn btn-secondary mt-2">Back</a>
                  <button type="submit" class="btn btn-success mt-2" id="submit">Save</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection

@push('js')
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
  <script src="https://cdn.tiny.cloud/1/i1nnds4l5jeoaufjhsu6l45pa8zxzdwc4vwh9dktv8d5gig4/tinymce/6/tinymce.min.js"
    referrerpolicy="origin"></script>
  {{-- <script src="https://cdn.jsdelivr.net/npm/@tinymce/tinymce-jquery@2/dist/tinymce-jquery.min.js"></script> --}}
@endpush

@push('script')
  <script>
    tinymce.init({
      selector: 'textarea.myeditorinstance', // Replace this CSS selector to match the placeholder element for TinyMCE
      plugins: 'code table lists',
      toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table'
    });

    function getError(errors) {
      $.each(errors, function(index, value) {
        toastr.error(value, 'Error', {
          closeButton: true,
          progressBar: true,
        });
      });
    }

    $('.preview').on('change', function() {
      preview(this)
    })

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

    $(".select2creation").select2({
      tags: true,
    });

    $('#installed_date').on('change',function(){
        var date = $(this).val();
        var newdate = new Date(date);
        newdate.setDate(newdate.getDate() + 365);
       // day format dd
        var dd = newdate.getDate();
        if(dd.toString().length == 1) {
            dd = '0'+dd;
        }
        // month format mm
        var mm = newdate.getMonth() + 1;
        if(mm.toString().length == 1) {
            mm = '0'+mm;
        }
        // year format yyyy
        var y = newdate.getFullYear();
        // someFormattedDate = y + '-' + mm + '-' + dd;

        var someFormattedDate = y + '-' + mm + '-' + dd;
        $('#warranty_date').val(someFormattedDate);
        var newdate2 = new Date(date);
        newdate2.setDate(newdate2.getDate() + 90);
        var dd2 = newdate2.getDate();
        if(dd2.toString().length == 1) {
            dd2 = '0'+dd2;
        }
        var mm2 = newdate2.getMonth() + 1;
        if(mm2.toString().length == 1) {
            mm2 = '0'+mm2;
        }
        var y2 = newdate2.getFullYear();
        var someFormattedDate2 = y2 + '-' + mm2 + '-' + dd2;
        $('#maintenance_first').val(someFormattedDate2);

        var newdate3 = new Date(date);
        newdate3.setDate(newdate3.getDate() + 180);
        var dd3 = newdate3.getDate();
        if(dd3.toString().length == 1) {
            dd3 = '0'+dd3;
        }
        var mm3 = newdate3.getMonth() + 1;
        if(mm3.toString().length == 1) {
            mm3 = '0'+mm3;
        }
        var y3 = newdate3.getFullYear();
        var someFormattedDate3 = y3 + '-' + mm3 + '-' + dd3;
        $('#maintenance_second').val(someFormattedDate3);

        var newdate4 = new Date(date);
        newdate4.setDate(newdate4.getDate() + 270);
        var dd4 = newdate4.getDate();
        if(dd4.toString().length == 1) {
            dd4 = '0'+dd4;
        }
        var mm4 = newdate4.getMonth() + 1;
        if(mm4.toString().length == 1) {
            mm4 = '0'+mm4;
        }
        var y4 = newdate4.getFullYear();
        var someFormattedDate4 = y4 + '-' + mm4 + '-' + dd4;
        $('#maintenance_third').val(someFormattedDate4);

    })
  </script>
@endpush
