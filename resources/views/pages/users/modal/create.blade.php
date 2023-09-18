<div class="modal fade" id="add-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticAddUser" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">สร้างผู้ใช้งาน</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <form novalidate class="bs-validate" id="user-create-form" method="POST" action="{{ route('create-user') }}">
                @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-xl-6">
                            <input required placeholder="ชื่อ" id="account_first_name" name="firstname" type="text" class="form-control form-control-sm">
                        </div>
                        <div class="col-xl-6">
                            <input required placeholder="นามสกุล" id="account_last_name" name="lastname" type="text" class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="mb-3">
                        <input required placeholder="อีเมล์" id="account_email" name="email" type="email" class="form-control form-control-sm">
                    </div>

                    <div class="mb-3">
                        <select require name="role" class="form-select form-select-sm">
                            <option value="" selected disabled>ระดับ</option>
                            @foreach($roles as $role)
                                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <button type="submit" class="btn btn-primary" id="btn-submit-form">
                    <span>เพิ่มผู้ใช้</span>
                    <svg class="rtl-flip" height="18px" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 8a.5.5 0 0 1 .5-.5h5.793L8.146 5.354a.5.5 0 1 1 .708-.708l3 3a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708-.708L10.293 8.5H4.5A.5.5 0 0 1 4 8z"></path>
                    </svg>
                </button>
			</div>
		</div>
	</div>
</div>