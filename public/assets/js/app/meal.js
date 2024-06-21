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
        loadFileIcon('#meal-icon')
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

function addSelectOption(select_id, icons, is_icon) {
    let _option = document.createElement('option')
    _option.value = ''
    _option.innerText = '-- No icon --'
    select_id.add(_option)

    icons.forEach((icon, index) => {
        let _option = document.createElement('option')
        _option.value = icon.icon
        _option.innerText = icon.name
        if(icon.icon === is_icon) {
            _option.selected = true
            document.querySelector('#icon-image-show-edit').src = icon.path + icon.icon
        }
        select_id.add(_option)
    })
}

let res = ''
async function loadFileIcon(is_select, is_icon) {
    let response = await fetch('../assets/images/meal/icon.json')
    res = await response.json()

    let _select = document.querySelector(is_select)
    _select.addEventListener('change', function() {
        if(is_icon) iconSelected(this, false)
        else iconSelected(this, true)
    }, false)
    clearSelectOption(_select)
    addSelectOption(_select, res, is_icon)
}

async function showIconList() {
    let showList = document.querySelector('#show-meal-icon-list')
    showList.innerHTML = ''

    let response = await fetch('../assets/images/meal/icon.json')
    let _res = await response.json()

    _res.forEach((icon, index) => {
        let _li = document.createElement('li')
        _li.innerHTML = `<img src="${icon.path}${icon.icon}" width="22" height=22> ${icon.name}
                            <i class="fi fi-round-close text-danger cursor-pointer meal-icon-delete" onClick="return confirmDeleteIcon(${index})" title="Delete this icon."></i>`
        showList.appendChild(_li)
    })
}

function iconSelected(e, status) {
    let _value = e.value
    if(_value === '') {
        document.querySelector('#icon-image-show').src = '../assets/images/no_image_icon.svg'
    }
    else {
        let element_id = status ? '#icon-image-show' : '#icon-image-show-edit'
        let icon = res.find((item, index) => { return item.icon === _value })
        document.querySelector(element_id).src = icon.path + icon.icon
    }
}

if(btn_cancel) {
    btn_cancel.addEventListener('click', () => {
        setClassListAdd('to-meal-create')

        setClassListRemove('to-meal-list')
        setClassListRemove('btn-meal-create')
        document.querySelector('#icon-image-show').src = '../assets/images/no_image_icon.svg'
        document.querySelector('#icon-image-show-edit').src = '../assets/images/no_image_icon.svg'
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
    document.querySelector('#edit-image-cover').style = ''
    document.querySelector('#has-icon').value = 0
    document.querySelector('#has-image').value = 0
    document.querySelector('#icon-image-show').src = '../assets/images/no_image_icon.svg'
    document.querySelector('#icon-image-show-edit').src = '../assets/images/no_image_icon.svg'
    current_icon_edit = ''
    setClassListAdd('current-image')
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}

function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function setUpdateIconMeal() {
    loadFileIcon('#meal-icon-edit', is_meal.image_icon)
    current_icon_edit = meal.image_icon
}

function updateEditData(index) {
    edit_data = []
    setClassListAdd('btn-meal-create')
    meal_header.innerHTML = `<span class="text-main-color-2">Edit</span> Meal`

    let meal = meals.find((item, key) => { return key === index })

    setClassListAdd('to-meal-list')
    setClassListRemove('to-meal-edit')
    loadFileIcon('#meal-icon-edit', meal.image_icon)
    current_icon_edit = meal.image_icon
    setDataToEditForm(meal)
}

function setDataToEditForm(meal) {
    document.querySelector('#edit-id').value = meal.id
    document.querySelector('#edit-meal-detail').value = meal.description
    document.querySelector('#edit-meal-name').value = meal.name
    document.querySelector('#edit-meal-price').value = parseInt(meal.amount)
    document.querySelector('#edit-route-station').checked = meal.is_route_station === 'Y' ? true : false
    document.querySelector('#edit-main-menu').checked = meal.is_main_menu === 'Y' ? true : false

    if(edit_data['image'] !== '') {
        document.querySelector('#current-image').classList.remove('d-none')
        document.querySelector('#edit-image-cover').style = `background-image: url('..${meal.image.path}/${meal.image.name}'); width: 80px; height: 80px; min-width: 80px;`
        document.querySelector('#has-image').value = 0
    }
}

function deleteCurrentImage(element_id, is_has, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    document.querySelector(`#${is_has}`).value = 1

    element.classList.add('hidden-element')
    setTimeout(() => {
        element.classList.add('d-none')
        document.querySelector(`#${element_restore}`).classList.remove('d-none')
    }, 500);
}

function restoreCurrentImage(element_id, is_has, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    document.querySelector(`#${is_has}`).value = 0
    element.classList.remove('d-none')

    setTimeout(() => {
        element.classList.remove('hidden-element')
        element.classList.add('visible-element')
    }, 500)
    document.querySelector(`#${element_restore}`).classList.add('d-none')
}
