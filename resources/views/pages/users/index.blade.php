@extends('layouts.default')

@section('content')
<x-page-header :header="_('ผู้ใช้งาน')" :sub_header="_('')" />

<div class="row">
    <div class="col-lg-3">
        <x-user-overview-section :header="_('All users')" :main_content="$all_user" />
    </div>

    <div class="col-lg-3">
        <x-user-overview-section :header="_('Admin')" :main_content="$user_count['admin_user']" :sub_content="$all_user"/>
    </div>

    <div class="col-lg-3">
        <x-user-overview-section :header="_('Agent')" :main_content="$user_count['agent_user']" :sub_content="$all_user" />
    </div>

    <div class="col-lg-3">
        <x-user-overview-section :header="_('Normal')" :main_content="$user_count['normal_user']" :sub_content="$all_user" />
    </div>

    <div class="col-12">
        <div id="to-user-list" class="section">
            <div class="card-body">
                <button type="button" class="btn btn-sm btn-primary mb-3 ms-2" data-bs-toggle="modal" data-bs-target="#add-user">
                    + เพิ่มผู้ใช้งาน
                </button>
                <table class="table-datatable table table-hover"
                    id="users-datatable" 
                    data-lng-empty="No data available in table"
                    data-lng-page-info="แสดงผล _START_ ถึง _END_ จากจำนวน _TOTAL_ รายการ"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="ค้นหาข้อมูล..."
                    data-lng-norecords="ไม่เจอข้อมูลที่ค้นหา"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-main-search="true"
                    data-column-search="false"
                    data-row-reorder="false"
                    data-col-reorder="true"
                    data-responsive="true"
                    data-header-fixed="true"
                    data-select-onclick="false"
                    data-enable-paging="true"
                    data-enable-col-sorting="false"
                    data-autofill="false"
                    data-group="false"
                    data-items-per-page="30"

                    data-enable-column-visibility="false"
                    data-lng-column-visibility="Column Visibility"

                    data-enable-export="true"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-export-pdf-disable-mobile="true"
                    data-export='["pdf", "xls"]'

                    data-custom-config='{}'>
                    <thead>
                        <tr>
                            <th style="width: 40px;">#</th>
                            <th style="width: 120px;">รหัส</th>
                            <th>ผู้ใช้งาน</th>
                            <th class="text-center">ระดับ</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">จัดการ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td class="user-index">{{ $index+1 }}</td>
                                <td class="user-code"><small>{{ $user['code'] }}</small></td>
                                <td class="user-name">
                                    <p class="mb-0">
                                        <span class="user-data-{{$index}}">{{ $user['firstname'] }}</span> 
                                        <span class="user-data-{{$index}}">{{ $user['lastname'] }}</span>
                                    </p>
                                    <small class="user-data-{{$index}}">{{ $user['email'] }}</small>
                                </td>
                                <td class="text-center user-role">
                                    <span class="@if($user['role']['name'] === 'Admin') bg-primary 
                                                @elseif($user['role']['name'] === 'Agent') bg-info 
                                                @else bg-secondary @endif badge">{{ $user['role']['name'] }}</span>
                                </td>
                                <td class="text-center">
                                    @if($user['isactive'])
                                        <i class="switch-icon switch-icon-primary disabled_hover active"></i>
                                    @else
                                        <i class="switch-icon switch-icon-primary disabled_hover"></i>
                                    @endif
                                    <input type="hidden" id="user-isactive-{{$index}}" value="{{ $user['isactive'] }}">
                                </td>
                                <td class="text-center">
                                    <input type="hidden" id="user-id-{{$index}}" value="{{ $user['id'] }}">
                                    <input type="hidden" id="user-role-{{$index}}" value="{{ $user['role_id'] }}">
                                    <i class="fi fi-cog-full text-secondary cursor-pointer" title="แก้ไขข้อมูล" onClick="updateEditData({{ $index }})"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-user-edit" class="section w-75 m-auto d-none">
            @include('pages.users.modal.edit2')
        </div>
    </div>
</div>

<style>
    .fi-cog-full:hover {
        color: #574fec !important;
    }
    div.dt-button-collection {
        width: 100px;
    }
    div.dt-button-collection .dt-button:not(.dt-btn-split-drop) {
        min-width: 80px;
    }
    a.dt-button.dropdown-item.buttons-csv.buttons-html5,
    a.dt-button.dropdown-item.buttons-copy.buttons-html5, 
    a.dt-button.dropdown-item.buttons-print {
        display: none;
    }
    .border-bottom-only {
        border-top: none;
        border-right: none;
        border-left: none;
        border-radius: 0;
    }
    i.disabled_hover {
        pointer-events: none;
        cursor: default;
    }
</style>
@stop

@section('modal')
    @include('pages.users.modal.create')
@stop

@section('script')
<script src="{{ asset('assets/js/app/user.js') }}"></script>
@stop
