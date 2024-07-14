  <div class="modal fade " id="modalFormProfil" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <form method="POST" id="updateProfile">
          @csrf
          @method('POST')
          <input id="id" type="hidden" name="id" value="">
          <div class="modal-header">
            <h4 class="modal-title" id="title">Pengaturan Akun</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group mb-1 col-12">
                <div class="form-line mb-4">
                  <label for="name">Email</label>
                  <input type="text" name="name" class="form-control" disabled
                    value="{{ auth()->user()->email }}">
                </div>
              </div>

              <div class="form-group mb-1 col-12">
                <div class="form-line mb-4">
                  <label for="name">Password</label>
                  <input type="password" name="password" class="form-control" id="pass">
                </div>
              </div>
              <div class="form-group mb-1 col-12">
                <div class="form-line mb-4">
                  <label for="name">Password Confirm</label>
                  <input type="password" name="password_confirm" class="form-control">
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-link waves-effect btn-primary">Simpan</button>
            <button type="button" class="btn btn-link waves-effect btn-danger close-modal"
              data-dismiss="modal">Tutup</button>
          </div>
        </form>
      </div>
    </div>
  </div>
