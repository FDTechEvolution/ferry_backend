<form novalidate class="bs-validate" id="user-edit-form" method="POST" onSubmit="return checkValidate()" action="{{ route('user-create') }}" enctype="multipart/form-data">
    @csrf
    <div class="row bg-transparent">
        <div class="col-12 px-lg-5">
            <h1 class="fw-bold text-second-color mb-4">Edit account</h1>

            <table class="table-datatable table table-custom-style" id="users-datatable-edit" 
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
                data-enable-export="false"
                data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                data-lng-pdf="PDF"
                data-lng-xls="XLS"
                data-lng-all="All"
                data-export-pdf-disable-mobile="true"
                data-export='["pdf", "xls"]'
            >
                <thead>
                    <tr>
                        <th class="text-center">Choose</th>
                        <th class="text-center">Username</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Lastname</th>
                        <th class="text-center">Office</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Role</th>
                        <th class="text-center">Last login</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $index => $user)
                        <tr class="text-center">
                            <td><input class="form-check-input form-check-input-default" type="checkbox" name="user_edit[]" value="" id="user-check-{{$index}}"></td>
                            <td class="user-username">{{ $user['username'] }}</td>
                            <td class="user-firstname">{{ $user['firstname'] }}</td>
                            <td class="user-lastname">{{ $user['lastname'] }}</td>
                            <td class="user-office">{{ $user['office'] }}</td>
                            <td class="user-email">{{ $user['email'] }}</td>
                            <td class="text-center user-role">
                                <span class="@if($user['role']['name'] === 'Admin') text-success 
                                            @elseif($user['role']['name'] === 'Agent') text-info 
                                            @else text-secondary @endif">{{ $user['role']['name'] }}</span>
                            </td>
                            <td class="text-center text-danger"></td>
                            <td class="text-center">
                                <input type="hidden" id="user-id-{{$index}}" value="{{ $user['id'] }}">
                                <input type="hidden" id="user-role-{{$index}}" value="{{ $user['role_id'] }}">
                                <!-- pdf -->
                                <a href="#" class="me-1 text-dark">
                                    <svg width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">  
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"></path>  
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"></path>
                                    </svg>
                                </a>

                                <!-- edit -->
                                <x-action-edit 
                                    class="me-1"
                                    :url="_('#')"
                                />

                                <!-- delete -->
                                <x-action-delete 
                                    :url="route('user-delete', ['id' => $user['id']])"
                                    :message="_('ยืนยันการลบผู้ใช้งาน '.$user['username'].'?')"
                                />
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</form>