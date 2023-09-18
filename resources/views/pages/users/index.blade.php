@extends('layouts.default')

@section('content')
<header>
    <h1 class="h4">Users</h1>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb small">
            <li class="breadcrumb-item text-muted active" aria-current="page">
                <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#add-user">
                    + ADD USER
                </button>
            </li>
        </ol>
    </nav>
</header>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <table class="table-datatable table table-bordered table-hover table-striped"
                    data-lng-empty="No data available in table"
                    data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                    data-lng-filtered="(filtered from _MAX_ total entries)"
                    data-lng-loading="Loading..."
                    data-lng-processing="Processing..."
                    data-lng-search="Search..."
                    data-lng-norecords="No matching records found"
                    data-lng-sort-ascending=": activate to sort column ascending"
                    data-lng-sort-descending=": activate to sort column descending"

                    data-main-search="true"
                    data-column-search="false"
                    data-row-reorder="false"
                    data-col-reorder="true"
                    data-responsive="true"
                    data-header-fixed="true"
                    data-select-onclick="true"
                    data-enable-paging="true"
                    data-enable-col-sorting="true"
                    data-autofill="false"
                    data-group="false"
                    data-items-per-page="30"

                    data-enable-column-visibility="true"
                    data-lng-column-visibility="Column Visibility"

                    data-enable-export="true"
                    data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                    data-lng-csv="CSV"
                    data-lng-pdf="PDF"
                    data-lng-xls="XLS"
                    data-lng-copy="Copy"
                    data-lng-print="Print"
                    data-lng-all="All"
                    data-export-pdf-disable-mobile="true"
                    data-export='["csv", "pdf", "xls"]'
                    data-options='["copy", "print"]'

                    data-custom-config='{}'>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>รหัส</th>
                            <th>ชื่อ-สกุล</th>
                            <th class="text-center">ตำแหน่ง</th>
                            <th>อีเมล์</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr>
                                <td class="user-index">{{ $index+1 }}</td>
                                <td class="user-code">{{ $user['code'] }}</td>
                                <td class="user-name">
                                    <span class="user-data-{{$index}}">{{ $user['firstname'] }}</span> 
                                    <span class="user-data-{{$index}}">{{ $user['lastname'] }}</span>
                                </td>
                                <td class="text-center user-role">{{ $user['role']['name'] }}</td>
                                <td class="user-data-{{$index}}">{{ $user['email'] }}</td>
                                <td class="text-center">
                                    @if($user['isactive'])
                                        <input class="d-none-cloaked" id="user-isactive-{{$index}}" type="checkbox" name="switch-checkbox" value="1" checked readonly>
                                    @else
                                        <input class="d-none-cloaked" id="user-isactive-{{$index}}" type="checkbox" name="switch-checkbox" value="0" readonly>
                                    @endif
                                    <i class="switch-icon switch-icon-primary switch-icon-sm"></i>
                                </td>
                                <td class="text-center">
                                    <input type="hidden" id="user-id-{{$index}}" value="{{ $user['id'] }}">
                                    <input type="hidden" id="user-role-{{$index}}" value="{{ $user['role_id'] }}">
                                    <i class="fi fi-pencil text-secondary cursor-pointer" data-bs-toggle="modal" data-bs-target="#edit-user" onClick="updateEditData({{ $index }})"></i>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>รหัส</th>
                            <th>ชื่อ-สกุล</th>
                            <th class="text-center">ตำแหน่ง</th>
                            <th>อีเมล์</th>
                            <th class="text-center">สถานะ</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    .cursor-pointer:hover {
        color: #574fec !important;
    }
</style>
@stop


@section('modal')
    @include('pages.users.modal.create')
    @include('pages.users.modal.edit')
@stop

@section('script')
<script src="{{ asset('assets/js/app/user.js') }}"></script>
@stop
