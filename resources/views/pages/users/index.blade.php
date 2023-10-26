@extends('layouts.default')

@section('page-title')
    <h1 class="ms-2 me-2 mb-0" id="account-page-title"><span class="text-main-color-2">Account</span></h1>
    <x-button-green :type="_('button')" :text="_('Add')" class="ms-2 btn-sm w--15" id="btn-user-create" />
    <x-button-orange :type="_('button')" :text="_('Edit')" class="ms-2 btn-sm w--15 d-none" id="btn-user-edit"/>
@stop

@section('content')
<div class="row mt-4">
    <div class="col-12">
        <div id="to-user-list">
            <div class="card-body">
                <table class="table-datatable table table-datatable-custom" id="users-datatable" 
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
                    data-export='["pdf", "xls"]'
                >
                    <thead>
                        <tr>
                            <th class="">Username</th>
                            <th class="">Name</th>
                            <th class="">Lastname</th>
                            <th class="">Office</th>
                            <th class="">Email</th>
                            <th class="">Role</th>
                            <th class="">Last login</th>
                            <th class="">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $user)
                            <tr class="">
                                <td class="user-data-{{ $index }}">{{ $user['username'] }}</td>
                                <td class="user-data-{{ $index }}">{{ $user['firstname'] }}</td>
                                <td class="user-data-{{ $index }}">{{ $user['lastname'] }}</td>
                                <td class="user-data-{{ $index }}">{{ $user['office'] }}</td>
                                <td class="user-data-{{ $index }}">{{ $user['email'] }}</td>
                                <td class="role-{{ $index }}">
                                    <span class="@if($user['role']['name'] === 'Admin') text-success 
                                                @elseif($user['role']['name'] === 'Agent') text-info 
                                                @else text-secondary @endif">{{ $user['role']['name'] }}</span>
                                </td>
                                <td class=" text-danger"></td>
                                <td class="">
                                    <input type="hidden" id="id-{{$index}}" value="{{ $user['id'] }}">
                                    <input type="hidden" id="role-{{$index}}" value="{{ $user['role_id'] }}">
                                    <input type="hidden" id="image-{{$index}}" value="{{ $user['image'] }}">
                                    
                                    <!-- edit -->
                                    <x-action-edit 
                                        class="me-2"
                                        :url="_('javascript:void(0)')"
                                        id="btn-user-edit"
                                        onClick="updateEditData({{ $index }})"
                                    />

                                    <!-- delete -->
                                    <x-action-delete 
                                        :url="route('user-delete', ['id' => $user['id']])"
                                        :message="_('Are you sure? Delete this account : '.$user['username'].'?')"
                                    />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div id="to-user-create" class="m-auto d-none">
            @include('pages.users.create')
        </div>
        <div id="to-user-edit" class="m-auto d-none">
            @include('pages.users.edit2')
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

@section('script')
<script src="{{ asset('assets/js/app/user.js') }}"></script>
@stop