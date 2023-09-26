<form novalidate class="bs-validate" id="meal-create-form" method="POST" action="#" enctype="multipart/form-data">
    @csrf
    <div class="row bg-transparent mt-5">
        <div class="col-sm-12 w-75 mx-auto">
            <h1 class="fw-bold text-second-color mb-4"><span>Add new Meal</h1>

            <div class="row">
                <div class="col-12 px-4 border-end">
                    <div class="mb-3 row">
                        <label for="meal-name" class="col-sm-4 col-form-label-sm text-start">Meal Name* :</label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control form-control-sm" id="meal-name" name="name" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="meal-price" class="col-sm-4 col-form-label-sm text-start">Price* :</label>
                        <div class="col-sm-8">
                            <input type="text" required class="form-control form-control-sm" id="meal-price" name="price" value="">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="meal-detail" class="col-sm-4 col-form-label-sm text-start">Detail Meal :</label>
                        <div class="col-sm-8">
                            <textarea class="form-control form-control-sm" id="meal-detail" name="price" row="3"></textarea>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center mt-4">
                    <x-button-orange :type="_('submit')" :text="_('Add')" class="btn-lg w--10 me-2" />
                    <button type="button" class="btn btn-secondary btn-lg w--10" id="btn-cancel-create">Cancel</button>
                    <small id="user-create-error-notice" class="text-danger mt-3"></small>
                </div>
            </div>

        </div>
    </div>
</form>