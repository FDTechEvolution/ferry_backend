const create_form = document.querySelector('#create-time-table-detail')
const edit_form = document.querySelector('#edit-time-table-detail')
const edit_cancel = document.querySelector('#btn-cancel-time-table-edit')

if(edit_cancel) {
    edit_cancel.addEventListener('click', () => {
        create_form.classList.remove('d-none')
        edit_form.classList.add('d-none')
    })
}

function updateEditData(index) {
    const table = time_tables.find((table, key) => { return key === index })

    create_form.classList.add('d-none')
    edit_form.classList.remove('d-none')
    window.scrollTo({ top: 0, behavior: 'smooth' });

    setDataToEditForm(table)
}

function setDataToEditForm(table) {
    // console.log(table)
    document.querySelector('#time-table-detail-edit').innerText = table.detail
    document.querySelector('#time-table-sort-edit').value = table.sort
    document.querySelector('#time-table-id-edit').value = table.id

    document.querySelector('#current-image').classList.remove('d-none')
    document.querySelector('#edit-image-cover').style = `background-image: url('..${table.image.path}/${table.image.name}'); width: 80px; height: 80px; min-width: 80px;`
    document.querySelector('#has-image').value = 1
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
    const remove = document.querySelector('#remove-picture')
    remove.click()
}

async function showInHomepage(e) {
    let isactive = e.checked ? 'Y' : 'N'
    let response = await fetch(`/ajax/time-table/show-in-homepage/${e.value}/${isactive}`)
    let res = await response.json()

    if(res.status === 'success') $.SOW.core.toast.show('success', '', res.msg, 'top-end', 0, true);
    else $.SOW.core.toast.show('danger', '', res.msg, 'top-end', 0, true);
}