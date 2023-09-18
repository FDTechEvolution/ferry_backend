document.querySelector('#btn-submit-form').addEventListener('click', () => {
    document.querySelector('#user-create-form').submit()
})

document.querySelector('#btn-update-form').addEventListener('click', () => {
    document.querySelector('#user-update-form').submit()
})

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
}