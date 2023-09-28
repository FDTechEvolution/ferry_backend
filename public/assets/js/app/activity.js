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