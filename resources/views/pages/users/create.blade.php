<form novalidate class="bs-validate" id="user-create-form" method="POST" onSubmit="return checkValidate()" action="{{ route('user-create') }}" enctype="multipart/form-data">
    @csrf
    <div class="row bg-transparent mt-2">
        <div class="col-11 col-lg-8 mx-auto">
            <h1 class="fw-bold text-second-color mb-4">Add new Account</h1>
            
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label-sm text-start">Username* :</label>
                <div class="col-sm-10">
                    <input type="text" required class="form-control form-control-sm" id="username" name="username" value="">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label-sm text-start">Password* :</label>
                <div class="col-sm-10">
                    <input type="password" required class="form-control form-control-sm" id="password" name="password" value="" minlength="6">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="firstname" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                <div class="col-sm-10">
                    <input type="text" required class="form-control form-control-sm" id="firstname" name="firstname" value="">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="lastname" class="col-sm-2 col-form-label-sm text-start">Last name* :</label>
                <div class="col-sm-10">
                    <input type="text" required class="form-control form-control-sm" id="lastname" name="lastname" value="">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="office" class="col-sm-2 col-form-label-sm text-start">Office* :</label>
                <div class="col-sm-10">
                    <input type="text" required class="form-control form-control-sm" id="office" name="office" value="">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label-sm text-start">email* :</label>
                <div class="col-sm-10">
                    <input type="email" required class="form-control form-control-sm" id="email" name="email" value="">
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-sm-2 col-form-label-sm text-start">Role :</label>
                <div class="col-sm-10">
                    <select class="form-select form-select-sm">
                        <option value="" selected disabled>-- select --</option>
                        @foreach($roles as $role)
                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="file_picture" class="col-sm-2 col-form-label-sm text-start">Picture :</label>
                <div class="col-sm-10">
                    <div class="mb-3">
                        <input class="form-control form-control-sm" id="file_picture" type="file" name="file">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-center mt-4">
            <x-button-green :type="_('submit')" :text="_('Add')" class="btn-lg w--10 me-2" />
            <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-create">Cancel</button>
            <small id="user-create-error-notice" class="text-danger mt-3"></small>
        </div>
    </div>
</form>