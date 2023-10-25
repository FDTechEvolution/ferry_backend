const create_form = document.querySelector('#create-route-map')
const edit_form = document.querySelector('#edit-route-map')
const edit_cancel = document.querySelector('#btn-cancel-route-map-edit')

if(edit_cancel) {
    edit_cancel.addEventListener('click', () => {
        create_form.classList.remove('d-none')
        edit_form.classList.add('d-none')
    })
}

function updateEditData(index) {
    let route_map = route_maps.find((item, key) => { return key === index })
    
    create_form.classList.add('d-none')
    edit_form.classList.remove('d-none')
    window.scrollTo({ top: 0, behavior: 'smooth' });

    setDataToEditForm(route_map)
}

function setDataToEditForm(route_map) {
    document.querySelector('#route-map-detail-edit').innerText = route_map.detail
    document.querySelector('#route-map-sort-edit').value = route_map.sort
    document.querySelector('#route-map-id-edit').value = route_map.id

    setImageForm(route_map.image, '#current-image', '#edit-image-cover')
    setImageForm(route_map.banner, '#current-banner', '#edit-banner-cover', '#has-banner')
    setImageForm(route_map.thumb, '#current-thumb', '#edit-thumb-cover', '#has-thumb')
}

function setImageForm(image, current_id, cover_id, has_id = null) {
    if(image) {
        document.querySelector(current_id).classList.remove('d-none')
        document.querySelector(cover_id).style = `background-image: url('..${image.path}/${image.name}'); width: 80px; height: 80px; min-width: 80px;`
        if(has_id != null) document.querySelector(has_id).value = 1
    }
    else {
        document.querySelector(current_id).classList.add('d-none')
        if(has_id != null) document.querySelector(has_id).value = 0
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

function resetImage() {
    const picture = document.querySelector('#remove-picture')
    const banner = document.querySelector('#remove-banner')
    const thumb = document.querySelector('#remove-thumb')
    picture.click()
    banner.click()
    thumb.click()
}

async function showInHomepage(e) {
    let response = await fetch(`/ajax/route-map/show-in-homepage/${e.value}`)
    let res = await response.json()

    if(res.status === 'success') $.SOW.core.toast.show('success', '', res.msg, 'top-end', 0, true);
    else $.SOW.core.toast.show('danger', '', res.msg, 'top-end', 0, true);
}

function getImageUpload(current_id) {
    let _currect_id = document.querySelector(`#${current_id}`)
    _currect_id.classList.add('hidden-element')
    setTimeout(() => {
        _currect_id.classList.add('d-none')
    }, 500);
}

function restoreCurrentImageByUpload(current_id) {
    let _currect_id = document.querySelector(`#${current_id}`)
    _currect_id.classList.remove('d-none')
    _currect_id.classList.add('visible-element')
    setTimeout(() => {
        _currect_id.classList.remove('hidden-element')
    }, 200);
}