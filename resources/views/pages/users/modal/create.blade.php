<div class="modal fade" id="add-user" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticAddUser" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel">สร้างผู้ใช้งาน</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body px-4">
                <form novalidate class="bs-validate" id="user-create-form" method="POST" action="{{ route('user-create') }}">
                @csrf
                    <fieldset id="user-form-creating">
                        <div class="row g-3 mb-3">
                            <div class="col-xl-12">
                                <div class="d-flex justify-content-between">
                                    <div class="flex-none pt-1" style="width:40px">
                                        <svg class="text-gray-300" width="32" height="32" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 460.8 460.8" fill="currentColor">
                                            <path d="M230.432,0c-65.829,0-119.641,53.812-119.641,119.641s53.812,119.641,119.641,119.641s119.641-53.812,119.641-119.641S296.261,0,230.432,0z"></path>
                                            <path d="M435.755,334.89c-3.135-7.837-7.314-15.151-12.016-21.943c-24.033-35.527-61.126-59.037-102.922-64.784c-5.224-0.522-10.971,0.522-15.151,3.657c-21.943,16.196-48.065,24.555-75.233,24.555s-53.29-8.359-75.233-24.555c-4.18-3.135-9.927-4.702-15.151-3.657c-41.796,5.747-79.412,29.257-102.922,64.784c-4.702,6.792-8.882,14.629-12.016,21.943c-1.567,3.135-1.045,6.792,0.522,9.927c4.18,7.314,9.404,14.629,14.106,20.898c7.314,9.927,15.151,18.808,24.033,27.167c7.314,7.314,15.673,14.106,24.033,20.898c41.273,30.825,90.906,47.02,142.106,47.02s100.833-16.196,142.106-47.02c8.359-6.269,16.718-13.584,24.033-20.898c8.359-8.359,16.718-17.241,24.033-27.167c5.224-6.792,9.927-13.584,14.106-20.898C436.8,341.682,437.322,338.024,435.755,334.89z"></path>
                                        </svg>
                                    </div>
                                    <div class="w-100">
                                        <strong class="d-block fs-5 fw-medium">รายละเอียดผู้ใช้งาน</strong> 
                                        <ul class="list-unstyled small mb-0">
                                            <li class="list-item">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label for="account_first_name" class="form-label mb-0">ชื่อ</label>
                                                        <input required id="account_first_name" name="firstname" type="text" class="form-control border-bottom-only form-control-sm me-2">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="account_last_name" class="form-label mb-0">นามสกุล</label>
                                                        <input required id="account_last_name" name="lastname" type="text" class="form-control border-bottom-only form-control-sm">
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="border border-dashed border-bottom-0 my-3"><!-- divider --></div>

                            <div class="d-flex justify-content-between">
                                <span class="flex-none pt-1" style="width:40px">
                                    <svg width="32" height="32" class="text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="12" cy="12" r="4"></circle>
                                        <path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-3.92 7.94"></path>
                                    </svg>
                                </span>
                                <span class="w-100">
                                    <strong class="d-block fs-5 fw-medium">อีเมล์</strong> 
                                    <input required id="account_email" name="email" type="email" class="form-control border-bottom-only form-control-sm">
                                </span>
                            </div>

                            <div class="border border-dashed border-bottom-0 my-3"><!-- divider --></div>

                            <div class="d-flex justify-content-between">
                                <span class="flex-none pt-1" style="width:40px">
                                    <svg width="32" height="32" class="text-gray-300" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor">
                                        <path fill-rule="evenodd" d="M8 .5c-.662 0-1.77.249-2.813.525a61.11 61.11 0 0 0-2.772.815 1.454 1.454 0 0 0-1.003 1.184c-.573 4.197.756 7.307 2.368 9.365a11.192 11.192 0 0 0 2.417 2.3c.371.256.715.451 1.007.586.27.124.558.225.796.225s.527-.101.796-.225c.292-.135.636-.33 1.007-.586a11.191 11.191 0 0 0 2.418-2.3c1.611-2.058 2.94-5.168 2.367-9.365a1.454 1.454 0 0 0-1.003-1.184 61.09 61.09 0 0 0-2.772-.815C9.77.749 8.663.5 8 .5zm.5 7.415a1.5 1.5 0 1 0-1 0l-.385 1.99a.5.5 0 0 0 .491.595h.788a.5.5 0 0 0 .49-.595L8.5 7.915z"></path>
                                    </svg>
                                </span>
                                <span class="w-100">
                                    <strong class="d-block fs-5 fw-medium">ระดับ</strong> 
                                    <select require name="role" id="account_role" class="form-select border-bottom-only form-select-sm">
                                        <option value="" selected disabled>-- เลือก --</option>
                                        @foreach($roles as $role)
                                            <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                                        @endforeach
                                    </select>
                                </span>
                            </div>
    
                        </div>
                    </fieldset>
                </form>
			</div>
			<div class="modal-footer">
				<button type="button" id="cancel-user-create" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                <x-button-loading 
                    :text="_('เพิ่มผู้ใช้')"
                    :form_id="_('user-create-form')"
                    :fieldset_id="_('user-form-creating')"
                    :cancel_id="_('cancel-user-create')"
                />
			</div>
		</div>
	</div>
</div>