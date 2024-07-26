@props(['fee' => []])

@php
    $type = $fee['type'];
@endphp
<div class="card mb-4">
    <div class="card-body bg-light">
        <div class="row">
            <div class="col-12 d-block d-lg-none">
                <h2 class="text-main-color-2 text-center">{{ $fee['name'] }}</h2>
            </div>
            <div class="col-12 col-md-10 order-2 order-lg-1">
                <div class="row">
                    <div class="col-12 d-none d-lg-block">
                        <h2 class="text-main-color-2">{{ $fee['name'] }}</h2>
                    </div>
                    <div class="col-12 col-lg-6 border-lg-end border-2 border-bottom border-lg-bottom-0 border-color-main mb-3 mb-lg-0 pb-3 pb-lg-0">
                        <h6 class="text-center mb-3 fw-bold">Processing fee (เลือกได้เพียงอย่างเดียว)</h6>
                        <div class="checkgroup" data-checkgroup-checkbox-single="true">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check mb-2 float-end">
                                                <input class="form-check-input form-check-input-primary is-pf-perperson-{{ $type }}"
                                                    type="checkbox" name="is_pf_perperson_{{ $type }}"
                                                    value="Y" id="perperson-pf-check-{{ $type }}"
                                                    @checked($fee['is_pf_perperson'] == 'Y')
                                                >
                                                <label class="form-check-label" for="perperson-pf-check-{{ $type }}">
                                                    Per/person
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>Regular</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['regular_pf'] }}" id="regular-pf-{{ $type }}" name="regular_pf_{{ $type }}">
                                                        <label for="regular-pf-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>Child</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['child_pf'] }}" id="child-pf-{{ $type }}" name="child_pf_{{ $type }}">
                                                        <label for="child-pf-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>infant</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['infant_pf'] }}" id="infant-pf-{{ $type }}" name="infant_pf_{{ $type }}">
                                                        <label for="infant-pf-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 border-start border-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-primary is-pf-perperson-{{ $type }}"
                                            type="checkbox" name="is_pf_perperson_{{ $type }}"
                                            value="N" id="allperson-pf-check-{{ $type }}"
                                            @checked($fee['is_pf_perperson'] == 'N')
                                        >
                                        <label class="form-check-label" for="allperson-pf-check-{{ $type }}">
                                            % All person/ ticket
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <input type="number" class="form-control form-control-sm text-center w-50" name="percent_pf_{{ $type }}" value="{{ $fee['percent_pf'] }}">
                                        <label class="mb-0 ms-1 form-label smaller">%</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <h6 class="text-center mb-3 fw-bold">Service charge (เลือกได้เพียงอย่างเดียว)</h6>
                        <div class="checkgroup" data-checkgroup-checkbox-single="true">
                            <div class="row">
                                <div class="col-6">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-check mb-2 float-end">
                                                <input class="form-check-input form-check-input-primary is-sc-perperson-{{ $type }}"
                                                    type="checkbox" name="is_sc_perperson_{{ $type }}"
                                                    value="Y" id="perperson-sc-check-{{ $type }}"
                                                    @checked($fee['is_sc_perperson'] == 'Y')
                                                >
                                                <label class="form-check-label" for="perperson-sc-check-{{ $type }}">
                                                    Per/person
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>Regular</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['regular_sc'] }}" id="regular-sc-{{ $type }}" name="regular_sc_{{ $type }}">
                                                        <label for="regular-sc-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>Child</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['child_sc'] }}" id="child-sc-{{ $type }}" name="child_sc_{{ $type }}">
                                                        <label for="child-sc-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-2">
                                            <div class="row">
                                                <div class="col-5 d-flex align-items-center">
                                                    <small>infant</small>
                                                </div>
                                                <div class="col-7 ps-0 text-end">
                                                    <div class="d-flex align-items-center justify-content-end">
                                                        <input type="number" class="form-control form-control-sm px-2 w--60 text-center"
                                                            value="{{ $fee['infant_sc'] }}" id="infant-sc-{{ $type }}" name="infant_sc_{{ $type }}">
                                                        <label for="infant-sc-{{ $type }}" class="mb-0 ms-1 form-label smaller">Bath</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 border-start border-2">
                                    <div class="form-check mb-2">
                                        <input class="form-check-input form-check-input-primary is-sc-perperson-{{ $type }}"
                                            type="checkbox" value="N" name="is_sc_perperson_{{ $type }}"
                                            value="N" id="allperson-sc-check-{{ $type }}"
                                            @checked($fee['is_sc_perperson'] == 'N')
                                        >
                                        <label class="form-check-label" for="allperson-sc-check-{{ $type }}">
                                            % All person/ ticket
                                        </label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <input type="number" class="form-control form-control-sm text-center w-50" name="percent_sc_{{ $type }}" value="{{ $fee['percent_sc'] }}">
                                        <label class="mb-0 ms-1 form-label smaller">%</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-2 border-lg-start border-2 border-color-main order-1 order-lg-2 border-bottom border-lg-bottom-0 mb-3 mb-lg-0">
                <p class="text-main-color-2 text-center text-lg-start">
                    สูตรการใช้ <br/>
                    <small>(เลือกใช้ได้อย่างเดียว)</small>
                </p>
                <div class="checkgroup" data-checkgroup-checkbox-single="true">
                    <div class="row">
                        <div class="col-6 col-lg-12 border-sm-end border-2">
                            <div class="form-check mb-3 text-center text-lg-start">
                                <input class="form-check-input form-check-input-primary"
                                    type="checkbox" value="Y" id="isuse-pf-{{ $type }}"
                                    name="isuse_pf_{{ $type }}" @checked($fee['isuse_pf'] == 'Y')>
                                <label class="form-check-label" for="isuse-pf-{{ $type }}">
                                    Processing fee
                                </label>
                            </div>
                        </div>
                        <div class="col-6 col-lg-12 text-center text-lg-start">
                            <div class="form-check mb-3">
                                <input class="form-check-input form-check-input-primary"
                                    type="checkbox" value="Y" id="isuse-sc-{{ $type }}"
                                    name="isuse_sc_{{ $type }}" @checked($fee['isuse_sc'] == 'Y')>
                                <label class="form-check-label" for="isuse-sc-{{ $type }}">
                                    Service chage
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="is_fee[]" value="{{ $fee['id'] }}">
    </div>
</div>
