const btn_create = document.querySelector('#btn-activity-create')

if(btn_create) {
    btn_create.addEventListener('click', () => {
        setClassListAdd('to-activity-list')
        setClassListAdd('btn-activity-create')

        setClassListRemove('to-activity-create')
    })
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}

function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function deleteCurrentImage(element_id, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    let current_image = document.querySelector('#is-current-image')

    element.classList.add('hidden-element')
    setTimeout(() => {
        element.classList.add('d-none')
        document.querySelector(`#${element_restore}`).classList.remove('d-none')
    }, 500);
    current_image.value = ''
}

function restoreCurrentImage(element_id, element_restore, image_id) {
    let element = document.querySelector(`#${element_id}`)
    let current_image = document.querySelector('#is-current-image')
    element.classList.remove('d-none')

    setTimeout(() => {
        element.classList.remove('hidden-element')
        element.classList.add('visible-element')
    }, 500)
    document.querySelector(`#${element_restore}`).classList.add('d-none')
    current_image.value = image_id
}

function selectActivityIcon(index) {
    const icon_selected = document.querySelector('#icon-selected')
    const icon_id = document.querySelector('#icon-id')
    let icon = icons.find((item, key) => { return key === index })
    
    icon_selected.src = icon.path
    icon_id.value = icon.id
}