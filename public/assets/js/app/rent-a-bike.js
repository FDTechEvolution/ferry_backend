function deleteCurrentImage(element_id, element_restore) {
    let element = document.querySelector(`#${element_id}`)
    let current_image = document.querySelector('#is-current-image')

    element.classList.add('hidden-element')
    setTimeout(() => {
        element.classList.add('d-none')
        document.querySelector(`#${element_restore}`).classList.remove('d-none')
    }, 500)
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

function getImageUpload(current_id) {
    let _current = document.querySelector(`#${current_id}`)
    if (!_current) return
    _current.classList.add('hidden-element')
    setTimeout(() => {
        _current.classList.add('d-none')
    }, 500)
}

function restoreCurrentImageByUpload(current_id) {
    let _current = document.querySelector(`#${current_id}`)
    if (!_current) return
    _current.classList.remove('d-none')
    _current.classList.add('visible-element')
    setTimeout(() => {
        _current.classList.remove('hidden-element')
    }, 200)
}
