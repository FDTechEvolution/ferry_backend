const btn_create = document.querySelector('#btn-meal-create')
const btn_cancel = document.querySelector('#btn-cancel-create')
const btn_cancel_edit = document.querySelector('#btn-cancel-edit')
const meal_header = document.querySelector('#meal-page-title')
const btn_upload_icon = document.querySelector('#btn-upload-icon')
let edit_data = []

if(btn_create) {
    btn_create.addEventListener('click', () => {
        setClassListAdd('to-meal-list')
        setClassListAdd('btn-meal-create')

        setClassListRemove('to-meal-create')
        meal_header.innerHTML = `<span class="text-main-color-2">Add</span> new Meal`
        loadFileIcon()
    })
}

// if(btn_upload_icon) {
//     btn_upload_icon.addEventListener('click', (e) => {
//         e.preventDefault();
//         ajaxUploadIcon()
//     })
// }

function clearSelectOption(select_id) {
    while (select_id.options.length > 0) {
        select_id.remove(0)
    }
}

function addSelectOption(select_id, icons) {
    let _option = document.createElement('option')
    _option.value = ''
    _option.innerText = '-- No icon --'
    select_id.add(_option)

    icons.forEach((icon, index) => {
        let _option = document.createElement('option')
        _option.value = icon.name
        _option.innerText = icon.name
        select_id.add(_option)
    })
}

let res = ''
async function loadFileIcon() {
    let response = await fetch('../assets/images/meal/icon.json')
    res = await response.json()

    let _select = document.querySelector('#meal-icon')
    _select.addEventListener('change', function() { iconSelected(this) }, false)
    clearSelectOption(_select)
    addSelectOption(_select, res)
}

function iconSelected(e) {
    if(e.value == '') {
        document.querySelector('#icon-image-show').src = '../assets/images/no_image_icon.svg'
    }
    else {
        let icon = res.find((item, index) => { return item.name === e.value })
        document.querySelector('#icon-image-show').src = icon.path
    }
}

if(btn_cancel) {
    btn_cancel.addEventListener('click', () => {
        setClassListAdd('to-meal-create')

        setClassListRemove('to-meal-list')
        setClassListRemove('btn-meal-create')
        meal_header.innerHTML = `<span>Meal manager</span>`
    })
}

if(btn_cancel_edit) {
    btn_cancel_edit.addEventListener('click', () => {
        setClassListAdd('to-meal-edit')

        setClassListRemove('to-meal-list')
        setClassListRemove('btn-meal-create')
        clearEditData()

        meal_header.innerHTML = `<span>Meal manager</span>`
    })
}

function clearEditData() {
    document.querySelector('#edit-id').value = ''
    document.querySelector('#edit-meal-detail').value = ''
    document.querySelector('#edit-meal-name').value = ''
    document.querySelector('#edit-meal-price').value = ''
    document.querySelector('#edit-icon-cover').style = ''
    document.querySelector('#edit-image-cover').style = ''
    document.querySelector('#has-icon').value = 0
    document.querySelector('#has-image').value = 0
    setClassListAdd('current-icon')
    setClassListAdd('current-image')
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}

function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function updateEditData(index) {
    edit_data = []
    setClassListAdd('btn-meal-create')
    meal_header.innerHTML = `<span class="text-main-color-2">Edit</span> Meal`

    let meal = meals.find((item, key) => { return key === index })

    setClassListAdd('to-meal-list')
    setClassListRemove('to-meal-edit')
    setDataToEditForm(meal)
}

function setDataToEditForm(meal) {
    document.querySelector('#edit-id').value = meal.id
    document.querySelector('#edit-meal-detail').value = meal.description
    document.querySelector('#edit-meal-name').value = meal.name
    document.querySelector('#edit-meal-price').value = parseInt(meal.amount)
    if(edit_data['icon'] !== '') {
        document.querySelector('#current-icon').classList.remove('d-none')
        document.querySelector('#edit-icon-cover').style = `background-image: url('..${meal.icon.path}/${meal.icon.name}'); width: 80px; height: 80px; min-width: 80px;`
        document.querySelector('#has-icon').value = 1
    }
    if(edit_data['image'] !== '') {
        document.querySelector('#current-image').classList.remove('d-none')
        document.querySelector('#edit-image-cover').style = `background-image: url('..${meal.image.path}/${meal.image.name}'); width: 80px; height: 80px; min-width: 80px;`
        document.querySelector('#has-image').value = 1
    }
}

function deleteCurrentImage(element_id, is_has, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    document.querySelector(`#${is_has}`).value = 0

    element.classList.add('hidden-element')
    setTimeout(() => {
        element.classList.add('d-none')
        document.querySelector(`#${element_restore}`).classList.remove('d-none')
    }, 500);
}

function restoreCurrentImage(element_id, is_has, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    document.querySelector(`#${is_has}`).value = 1
    element.classList.remove('d-none')

    setTimeout(() => {
        element.classList.remove('hidden-element')
        element.classList.add('visible-element')
    }, 500)
    document.querySelector(`#${element_restore}`).classList.add('d-none')
}