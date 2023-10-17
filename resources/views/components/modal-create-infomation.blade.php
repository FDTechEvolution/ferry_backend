<div class="modal fade" id="create-infomation" style="z-index: 1061;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add new station infomation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
                <div class="row">
                    <div class="col-12 px-4">
                        <form id="form-create-infomation" enctype="multipart/form-data">
                            <fieldset id="fieldset-create-infomation">
                                <input type="hidden" name="_token" id="infomation-token" value="{{ csrf_token() }}">
                                <input type="hidden" name="station_id" id="station-id-info" value="">
                                <input type="hidden" name="station_type" id="station-type-info" value="">
                                <div class="mb-3 row">
                                    <label for="station-info-name" class="col-sm-2 col-form-label-sm text-start">Name* :</label>
                                    <div class="col-sm-8">
                                        <input required type="text" class="form-control form-control-sm" id="station-info-name" name="name">
                                    </div>
                                </div>

                                <div class="mb-3 row">
                                    <label class="col-sm-2 col-form-label-sm text-start">Detail* :</label>
                                    <div class="col-sm-8">
                                        <div class="quill-editor"
                                            id="station-info-detail"
                                            data-ajax-url="_ajax/demo.summernote.php"
                                            data-ajax-params="['action','upload']['param2','value2']"
                                            data-textarea-name="detail"
                                            data-quill-config='{
                                                "modules": {
                                                    "toolbar": [
                                                        [{ "header": [2, 3, 4, 5, 6, false] }],
                                                        ["bold", "italic", "underline", "strike"],
                                                        [{ "color": [] }, { "background": [] }],
                                                        [{ "script": "super" }, { "script": "sub" }],
                                                        ["blockquote"],
                                                        [{ "list": "ordered" }, { "list": "bullet"}, { "indent": "-1" }, { "indent": "+1" }],
                                                        [{ "align": [] }],
                                                        ["link", "image", "video"],
                                                        ["clean", "code-block"]
                                                    ]
                                                },

                                                "placeholder": "Type here..."
                                            }'>
                                            <p></p>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                    <div class="col-12 text-center mt-6">
                        <i class="fi fi-loading-dots fi-spin d-none" id="icon-create-info-loading"></i>
                        <x-button-green 
                            class="w--15 me-2 border-radius-10"
                            id="btn-infomation-create"
                            :type="_('submit')"
                            :text="_('Add')"
                        />
                        <button type="button" class="btn btn-secondary border-radius-10 w--15" id="btn-infomation-cancel" data-bs-dismiss="modal" onClick="cancelModalCreateInfomation()">Cancel</button>
                        <small id="station-info-create-error-notice" class="text-danger mt-3"></small>
                    </div>
                </div>
			</div>
			<!-- <div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div> -->
		</div>
	</div>
</div>

<script>
const form = document.querySelector('#form-create-infomation')
const btn_infomation_create = document.querySelector('#btn-infomation-create')
const btn_infomation_cancel = document.querySelector('#btn-infomation-cancel')
const err = document.querySelector('#station-info-create-error-notice') 
const loading = document.querySelector('#icon-create-info-loading')

$("#btn-infomation-create").click(function(e){
    e.preventDefault()
    let name = document.querySelector('#station-info-name')
    let detail = document.querySelector('.ql-editor')
    btn_infomation_cancel.click()
    // loadNewInfomation(_station_id, _type, _list_id, _ul_id, _input_id)

    let postData = new FormData(form)
    postData.append("name", name.value)
    postData.append("detail", detail.innerHTML)
    postData.append("_token", $("#infomation-token").val())
    postData.append("station_id", $("#station-id-info").val())
    $.ajax({
        type: 'POST',
        url: "{{ route('ajax-create-station-info') }}",
        data: postData,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        processData: false,
        contentType: false,
        beforeSend: function(){
            err.innerHTML = ''
            btn_infomation_create.disabled = btn_infomation_cancel.disabled = true
            loading.classList.remove('d-none')
        },
        success: function(response){
            if(response.status === 'success') {
                err.innerHTML = ''
                name.value = ''
                detail.innerHTML = ''
                loadNewInfomation(_station_id, _type, _list_id, _ul_id, _input_id)
            }
            else {
                err.innerHTML = response.message
            }
        },
        complete: function(response){
            loading.classList.add('d-none')
            btn_infomation_create.disabled = btn_infomation_cancel.disabled = false
            // if(_type === 'from') $('#station-from-selected').val(_station_id)
            // if(_type === 'to') $('#station-to-selected').val(_station_id)
        }
    })
})
</script>