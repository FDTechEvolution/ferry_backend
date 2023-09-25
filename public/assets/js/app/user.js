let btn_user_list = document.querySelector('#btn-user-list')
let btn_user_create = document.querySelector('#btn-user-create')
let btn_cancel_create = document.querySelector('#btn-cancel-create')
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
        setClassListAdd('to-user-create')
        setClassListAdd('to-user-edit')

        setClassListRemove('btn-user-create')
        setClassListRemove('btn-user-edit')
        setClassListRemove('to-user-list')
        account_title.innerHTML = `<span class="text-main-color-2">Account</span>`
    })
}

if(btn_user_edit) {
    btn_user_edit.addEventListener('click', () => {
        setClassListRemove('to-user-edit')

        setClassListAdd('to-user-list')
        account_title.innerHTML = `<span class="text-main-color-2">Edit</span> account`
    })
}

if(btn_user_list) {
    btn_user_list.addEventListener('click', () => {
        setClassListRemove('to-user-list')
        setClassListAdd('to-user-edit')
    })
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}

function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function updateEditData(index) {
    let data = document.querySelectorAll(`.user-data-${index}`)
    let user_id = document.querySelector(`#user-id-${index}`)
    let role_id = document.querySelector(`#user-role-${index}`)
    let isactive = document.querySelector(`#user-isactive-${index}`)
    let element_ids = ['edit_first_name', 'edit_last_name', 'edit_email']
    let role_select = document.querySelector('#edit-role')
    let options = role_select.getElementsByTagName('option')

    element_ids.forEach((element, index) => {
        document.querySelector(`#${element}`).value = data[index].innerText
    })

    Array.from(options).forEach((option, index) => {
        if(option.value === role_id.value) options[index].selected = true
    })

    document.querySelector('#user-edit-id').value = user_id.value
    document.querySelector('#edit-user-isactive').checked = isactive.value === '1' ? true : false

    document.querySelector('#to-user-list').classList.add('d-none')
    document.querySelector('#to-user-edit').classList.remove('d-none')
}

function checkValidate() {
    const password = document.querySelector('#password')
    if(password.value.length < 6) {
        document.querySelector('#user-create-error-notice').innerHTML = 'รหัสผ่านต้องไม่น้อยกว่า 6 ตัว'
    }
}