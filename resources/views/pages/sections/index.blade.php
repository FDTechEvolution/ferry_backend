@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 mb-0" id="station-page-title"><span class="text-main-color-2">Manage</span> Section</h1>
    <x-a-href-green :text="_('Add Section')" :href="route('section.create')" :target="_('_self')" class="ms-3 btn-sm w--15" />
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div class="row bg-transparent mt-2">
            <div class="col-12 mb-3">
                <a href="{{ route('stations-index') }}" class="btn btn-secondary" id="btn-section-cancel-manage">< Back</a>
            </div>
            <div class="col-12">
                <div id="to-section-list" class="table-responsive">
                    <div class="card-body">
                        <table class="table-datatable table table-datatable-custom" id="section-datatable"
                            data-lng-empty="No data available in table"
                            data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                            data-lng-filtered="(filtered from _MAX_ total entries)"
                            data-lng-loading="Loading..."
                            data-lng-processing="Processing..."
                            data-lng-search="Search..."
                            data-lng-norecords="No matching records found"
                            data-lng-sort-ascending=": activate to sort column ascending"
                            data-lng-sort-descending=": activate to sort column descending"

                            data-enable-col-sorting="false"
                            data-items-per-page="15"

                            data-enable-column-visibility="false"
                            data-enable-export="true"
                            data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                            data-lng-pdf="PDF"
                            data-lng-xls="XLS"
                            data-lng-all="All"
                            data-export-pdf-disable-mobile="true"
                            data-export='["pdf", "xls"]' data-responsive="false"
                        >
                            <thead>
                                <tr>
                                    <th class="text-center w--5">#</th>
                                    <th>name</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($sections as $index => $section)
                                    <tr class="text-center">
                                        <td id="section-sort-{{ $index }}">{{ $section->sort}}</td>
                                        <td id="section-name-{{ $index }}" class="text-start">{{ $section['name'] }}</td>
                                        <td class="text-center">
                                            {{-- <x-isactive :isactive="$section->isactive" /> --}}
                                            <label class="d-flex justify-content-center align-items-center">
                                                <input class="d-none-cloaked section-isactive" type="checkbox" name="isactive" value="{{ $section->id }}" @checked(old('isactive', $section->isactive == 'Y'))>
                                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                                                {{-- <span class="px-2 user-select-none">{{ $section->isactive == 'Y' ? 'On' : 'Off' }}</span> --}}
                                            </label>
                                        </td>
                                        <td>
                                            <input type="hidden" name="section_id" id="section-id-{{ $index }}" value="{{ $section['id'] }}">
                                            <x-action-edit
                                                class="me-2"
                                                :url="_('javascript:void(0)')"
                                                id="btn-section-edit"
                                                onClick="updateSectionEditData({{ $index }})"
                                            />
                                            <x-action-delete
                                                :url="route('section.destroy', ['id' => $section])"
                                                :message="_('Are you sure? Delete '. $section['name'] .'?')"
                                            />
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="to-section-edit" class="m-auto d-none">
                    <form novalidate class="bs-validate" id="section-edit-form" method="POST" action="{{ route('section.update') }}">
                        @csrf
                        <fieldset id="section-edit">
                            <div class="row bg-transparent mt-3">
                                <div class="col-sm-6 mx-auto">
                                    <h1 class="fw-bold text-second-color mb-4">Section edit</h1>

                                    <div class="mb-4 row">
                                        <label for="section-name-edit" class="col-sm-3 col-form-label-sm text-start">Section* :</label>
                                        <div class="col-sm-9">
                                            <input type="text" required class="form-control form-control-sm" id="section-name-edit" name="name" value="">
                                        </div>
                                    </div>
                                    <div class="mb-4 row">
                                        <label for="section-name-edit" class="col-sm-3 col-form-label-sm text-start">Sort* :</label>
                                        <div class="col-sm-9">
                                            <select class="form-select form-select-sm" id="section-sort-edit" name="sort">
                                                @for($i = 1; $i <= $max_sort; $i++)
                                                    <option id="option_{{ $i }}" value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            {{-- <input type="number" required class="form-control form-control-sm" id="section-sort-edit" name="sort" value=""> --}}
                                        </div>
                                    </div>

                                    <div class="text-center mt-5">
                                        <x-button-submit-loading
                                            class="btn-lg w--30 me-5"
                                            :form_id="_('section-edit-form')"
                                            :fieldset_id="_('section-edit')"
                                            :text="_('Edit')"
                                        />
                                        <button type="button" class="btn btn-secondary btn-lg w--30" id="btn-section-cancel-edit">Cancel</button>
                                        <small id="section-edit-error-notice" class="text-danger mt-3"></small>
                                    </div>
                                </div>
                                <input type="hidden" name="section_id" id="section-id-edit" value="">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('script')
<script src="{{ asset('assets/js/app/station.js') }}"></script>
@stop
