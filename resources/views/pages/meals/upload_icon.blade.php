<div class="modal fade" id="upload-icon" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Upload Icon</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 col-lg-8">
                        <form id="form-upload-icon" enctype="multipart/form-data">
                            <fieldset id="fieldset-upload-icon">
                                <input type="hidden" name="_token" id="icon-token" value="{{ csrf_token() }}">
                                <div class="mb-4 row">
                                    <label for="meal-name" class="col-sm-3 col-form-label-sm text-start">Icon Name* :</label>
                                    <div class="col-sm-9">
                                        <input type="text" required class="form-control form-control-sm" id="icon-name" name="name" value="">
                                    </div>
                                </div>
                                <div class="mb-4 row">
                                    <label for="meal-name" class="col-sm-3 col-form-label-sm text-start">Icon File* :</label>
                                    <div class="col-sm-9">
                                        <label class="btn btn-light btn-sm cursor-pointer position-relative w-100 rounded border mb-4" style="background-color: #fff;">
                                            <input required type="file" name="file_icon" id="file-icon"
                                                data-file-ext="jepg, jpg, png, gif, svg"
                                                data-file-max-size-kb-per-file="1048"
                                                data-file-max-size-kb-total="2048"
                                                data-file-max-total-files="100"
                                                data-file-ext-err-msg="Allowed:"
                                                data-file-exist-err-msg="File already exists:"
                                                data-file-size-err-item-msg="File too large!"
                                                data-file-size-err-total-msg="Total allowed size exceeded!"
                                                data-file-size-err-max-msg="Maximum allowed files:"
                                                data-file-toast-position="bottom-center"
                                                data-file-preview-container=".js-file-input-container-multiple-list-static-icon"
                                                data-file-preview-img-height="80"
                                                data-file-btn-clear="a.js-file-input-btn-multiple-list-static-remove-icon"
                                                data-file-preview-show-info="true"
                                                data-file-preview-list-type="list"
                                                class="custom-file-input absolute-full cursor-pointer"
                                                title="jpeg, jpg, png, gif, svg (1MB)" data-bs-toggle="tooltip"
                                            >

                                            <span class="group-icon cursor-pointer">
                                                <i class="fi fi-arrow-upload"></i>
                                                <i class="fi fi-circle-spin fi-spin"></i>
                                            </span>

                                            <span class="cursor-pointer">Upload icon</span>
                                        </label>

                                        <div class="row">
                                            <div class="col-10">
                                                <div class="js-file-input-container-multiple-list-static-icon position-relative hide-empty mt-2"><!-- container --></div>
                                            </div>
                                            <div class="col-2 text-center">
                                                <!-- remove button -->
                                                <a href="javascript:void(0)" title="Clear Images" data-bs-toggle="tooltip" class="js-file-input-btn-multiple-list-static-remove-icon hide btn btn-secondary mt-4 text-center">
                                                    <i class="fi fi-close mx-auto"></i>
                                                </a>
                                            </div>
                                        </div>

                                        <p class="mb-0 text-danger" id="error-upload-icon-notice"></p>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-sm-12 col-lg-4 border-start">
                        <strong>Icon List : </strong>
                        <ul id="show-meal-icon-list"></ul>

                        <p class="mb-0 text-danger" id="error-edit-icon-notice"></p>
                    </div>
                </div>
			</div>
            
			<div class="modal-footer">
                <i class="fi fi-loading-dots fi-spin d-none" id="btn-upload-icon-loading"></i>
                <x-button-green 
                    class="w--20 me-2 border-radius-10"
                    id="btn-upload-icon"
                    :type="_('submit')"
                    :text="_('Upload')"
                />
				<button type="button" class="btn btn-secondary border-radius-10" id="btn-cancel-icon" data-bs-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<style>
    ul#show-meal-icon-list li {
        line-height: 32px;
    }
</style>

<script>
const form = document.querySelector('#form-upload-icon')
const err = document.querySelector('#error-upload-icon-notice')
const err2 = document.querySelector('#error-edit-icon-notice')
const btn_upload_new_icon = document.querySelector('#btn-upload-icon')
const btn_cancel_icon = document.querySelector('#btn-cancel-icon')
const btn_upload_icon_loading = document.querySelector('#btn-upload-icon-loading')
let current_icon_edit = ''

$("#btn-upload-icon").click(function(e){
    e.preventDefault()
    let postData = new FormData(form)
    postData.append("name", $("#icon-name").val())
    postData.append("_token", $("#icon-token").val())
    postData.append("file", $("#icon-file"))
    $.ajax({
        type: 'POST',
        url: "{{ route('meal-upload-icon') }}",
        data: postData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        beforeSend: function(){
            err.innerHTML = ''
            btn_upload_new_icon.disabled = btn_cancel_icon.disabled = true
            btn_upload_icon_loading.classList.remove('d-none')
        },
        success: function(response){
            if(response.status === 'success') {
                err.innerHTML = ''
                loadFileIcon('#meal-icon')
                $('#icon-name').val('')
                $('.js-file-input-btn-multiple-list-static-remove-icon').click()
                $('#upload-icon').modal('hide')
            }
            else {
                err.innerHTML = response.message
            }
        },
        complete: function(response){
            btn_upload_new_icon.disabled = btn_cancel_icon.disabled = false
            btn_upload_icon_loading.classList.add('d-none')
        }
    })
})

function confirmDeleteIcon(index) {
    $.ajax({
        type: 'POST',
        url: "{{ route('meal-delete-icon') }}",
        data: {
            key: index
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function(){
            err2.innerHTML = ''
            iconDisabled(true)
        },
        success: function(response){
            if(response.status === 'success') {
                loadFileIcon('#meal-icon-edit', current_icon_edit)
                showIconList()
            }
            else {
                err2.innerHTML = response.message
            }
        },
        complete: function(response){
            iconDisabled(false)
        }
    })
}

function iconDisabled(status) {
    let icons = document.querySelectorAll('.meal-icon-delete')
    icons.forEach((icon, index) => {
        icon.disabled = status
    })
}
</script>