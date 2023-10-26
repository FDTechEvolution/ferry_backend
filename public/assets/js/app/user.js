let btn_user_list = document.querySelector('#btn-user-list')
let btn_user_create = document.querySelector('#btn-user-create')
let btn_cancel_create = document.querySelector('#btn-cancel-create')
let btn_cancel_edit = document.querySelector('#btn-cancel-edit')
let btn_user_edit = document.querySelector('#btn-user-edit')
let account_title = document.querySelector('#account-page-title')

if(btn_user_create) {
    btn_user_create.addEventListener('click', () => {
        setClassListRemove('to-user-create')

        setClassListAdd('btn-user-create')
        setClassListAdd('btn-user-edit')
        setClassListAdd('to-user-list')
        setClassListAdd('to-user-edit')
        account_title.innerHTML = `<span class="text-main-color-2">Add</span> new account`
    })
}

if(btn_cancel_create) {
    btn_cancel_create.addEventListener('click', () => {
        backToUserList()
    })
}

if(btn_cancel_edit) {
    btn_cancel_edit.addEventListener('click', () => {
        backToUserList()
    })
}

if(btn_user_edit) {
    btn_user_edit.addEventListener('click', () => {
        setClassListRemove('to-user-edit')

        setClassListAdd('to-user-list')
        setClassListAdd('btn-user-create')
        account_title.innerHTML = `<span class="text-main-color-2">Edit</span> account`
    })
}

if(btn_user_list) {
    btn_user_list.addEventListener('click', () => {
        setClassListRemove('to-user-list')
        setClassListAdd('to-user-edit')
    })
}

function backToUserList() {
    setClassListAdd('to-user-create')
    setClassListAdd('to-user-edit')

    setClassListRemove('btn-user-create')
    setClassListRemove('to-user-list')
    account_title.innerHTML = `<span class="text-main-color-2">Account</span>`
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}

function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function updateEditData(index) {
    let data = document.querySelectorAll(`.user-data-${index}`)
    let user_id = document.querySelector(`#id-${index}`)
    let role_id = document.querySelector(`#role-${index}`)
    //let username = document.querySelector(`#user-data-username-${index}`)
    //let image = document.querySelector(`#image-${index}`)
    let element_ids = ['edit-username','edit-firstname', 'edit-lastname', 'edit-office', 'edit-email']
    let role_select = document.querySelector('#edit-role')
    let options = role_select.getElementsByTagName('option')

    element_ids.forEach((element, index) => {
        document.querySelector(`#${element}`).value = data[index].innerText
    })

    Array.from(options).forEach((option, index) => {
        if(option.value === role_id.value) options[index].selected = true
    })

    //document.querySelector('#edit-username-data').innerHTML = username.innerText
    document.querySelector('#user-edit-id').value = user_id.value
    //document.querySelector('#edit-user-avatar').src = `../assets/images/avatar/${image.value !== '' ? image.value : 'blank-profile-picture.png'}`

    setClassListRemove('to-user-edit')
    setClassListAdd('to-user-create')
    setClassListAdd('to-user-list')
    setClassListAdd('btn-user-create')
    account_title.innerHTML = `<span class="text-main-color-2">Edit</span> account`
}

function checkValidate() {
    const password = document.querySelector('#password')
    if(password.value.length < 6) {
        document.querySelector('#user-create-error-notice').innerHTML = 'รหัสผ่านต้องไม่น้อยกว่า 6 ตัว'
    }
}