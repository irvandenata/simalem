@extends('utils.modal')
@section('modal-size', 'modal-lg')
@section('input-form')
  <div class="row">
    <div class="form-group mb-1 col-12">
      <div class="form-line mb-4">
        <label for="name">Nama Alat</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <div class="form-line mb-4">
        <label for="name">Tipe Alat</label>
        <select name="type" class="form-control select2creation" required>
          <option selected value="" disabled>Pilih Atau Tambah Tipe</option>
          <option value="adwd">awdawd</option>

          @foreach ($types as $type)
            <option value="{{ $type->name }}">{{ $type->name }}</option>
            @endforeach
        </select>
      </div>
      <div class="form-line mb-4">
        <label for="name">Merek Alat</label>
        <select name="brand" class="form-control select2creation" required>
          <option value="" selected disabled>Pilih Atau Tambah Merek</option>
            @foreach ($brands as $brand)
                <option value="{{ $brand->name }}">{{ $brand->name }}</option>
            @endforeach
        </select>
      </div>
    </div>
  </div>
@endsection

