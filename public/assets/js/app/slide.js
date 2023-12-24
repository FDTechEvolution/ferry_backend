const create_form = document.querySelector('#create-slide')
const edit_form = document.querySelector('#edit-slide')
const cancel_edit = document.querySelector('#btn-cancel-slide-edit')

function updateEditData(index) {
    const slide = slides.find((item, key) => { return key === index })

    create_form.classList.add('d-none')
    edit_form.classList.remove('d-none')
    window.scrollTo({ top: 0, behavior: 'smooth' });

    setDataToEditForm(slide)
}

if(cancel_edit) {
    cancel_edit.addEventListener('click', () => {
        create_form.classList.remove('d-none')
        edit_form.classList.add('d-none')
    })
}

function setDataToEditForm(slide) {
    // console.log(table)
    document.querySelector('#slide-link-edit').innerText = slide.link
    document.querySelector('#slide-sort-edit').value = slide.sort
    document.querySelector('#slide-id-edit').value = slide.id
    document.querySelector('#slide-description-edit').innerText = slide.description

    document.querySelector('#current-image').classList.remove('d-none')
    document.querySelector('#edit-image-cover').style = `background-image: url('..${slide.image.path}/${slide.image.name}'); width: 220px; height: 80px; min-width: 80px;`
    document.querySelector('#has-image').value = 1
}

async function showInHomepage(e) {
    let response = await fetch(`/ajax/slide/show-in-homepage/${e.value}`)
    let res = await response.json()

    if(res.status === 'success') $.SOW.core.toast.show('success', '', res.msg, 'top-end', 0, true);
    else $.SOW.core.toast.show('danger', '', res.msg, 'top-end', 0, true);
}

function resetImage() {
    const remove = document.querySelector('#remove-picture')
    if(remove) remove.click()
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