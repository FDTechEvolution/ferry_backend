const btn_create = document.querySelector('#btn-meal-create')
const btn_cancel = document.querySelector('#btn-cancel-create')
const btn_cancel_edit = document.querySelector('#btn-cancel-edit')
const meal_header = document.querySelector('#meal-page-title')
let edit_data = []

if(btn_create) {
    btn_create.addEventListener('click', () => {
        setClassListAdd('to-meal-list')
        setClassListAdd('btn-meal-create')

        setClassListRemove('to-meal-create')
        meal_header.innerHTML = `<span class="text-main-color-2">Add</span> new Meal`
    })
}

if(btn_cancel) {
    btn_cancel.addEventListener('click', () => {
        setClassListAdd('to-meal-create')

        setClassListRemove('to-meal-list')
        setClassListRemove('btn-meal-create')
        meal_header.innerHTML = `<span class="text-main-color-2">Meal manager`
    })
}

if(btn_cancel_edit) {
    btn_cancel_edit.addEventListener('click', () => {
        setClassListAdd('to-meal-edit')

        setClassListRemove('to-meal-list')
        setClassListRemove('btn-meal-create')
        clearEditData()

        meal_header.innerHTML = `<span class="text-main-color-2">Meal manager`
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

    const tr = document.querySelector(`#meal-row-${index}`)
    const td = tr.getElementsByTagName('td')
    const input = tr.getElementsByTagName('input')
    
    setDataEdit(td, 'innerText')
    setDataEdit(input, 'value')

    setClassListAdd('to-meal-list')
    setClassListRemove('to-meal-edit')
    setDataToEdutForm()
}

function setDataToEdutForm() {
    document.querySelector('#edit-id').value = edit_data['id']
    document.querySelector('#edit-meal-detail').value = edit_data['description']
    document.querySelector('#edit-meal-name').value = edit_data['name']
    document.querySelector('#edit-meal-price').value = parseInt(edit_data['price'])
    if(edit_data['icon'] !== '') {
        document.querySelector('#current-icon').classList.remove('d-none')
        document.querySelector('#edit-icon-cover').style = `background-image: url('..${edit_data['icon']}'); width: 80px; height: 80px; min-width: 80px;`
        document.querySelector('#has-icon').value = 1
    }
    if(edit_data['image'] !== '') {
        document.querySelector('#current-image').classList.remove('d-none')
        document.querySelector('#edit-image-cover').style = `background-image: url('..${edit_data['image']}'); width: 80px; height: 80px; min-width: 80px;`
        document.querySelector('#has-image').value = 1
    }
}

function setDataEdit(items, datatype) {

    Array.from(items).forEach((item, index) => {
        if(item.attributes['data-id']) {
            edit_data[item.attributes['data-id'].value] = (datatype === 'value') ? item.value : item.innerText
        }
    })
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