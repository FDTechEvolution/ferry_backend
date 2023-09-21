let btn_user_list = document.querySelector('#btn-user-list')

if(btn_user_list) {
    btn_user_list.addEventListener('click', () => {
        document.querySelector('#to-user-list').classList.remove('d-none')
        document.querySelector('#to-user-edit').classList.add('d-none')
    })
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