const btn_station_create = document.querySelector('#btn-station-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')
const btn_station_edit = document.querySelector('#btn-station-edit')
const btn_section_create = document.querySelector('#btn-section-create')
const btn_section_calcel_create = document.querySelector('#btn-section-cancel-create')
const btn_station_manage = document.querySelector('#btn-section-manage')

const station_list = document.querySelector('#to-station-list')
const station_create = document.querySelector('#to-station-create')
const section_create = document.querySelector('#to-section-create')

const station_title = document.querySelector('#station-page-title')

if(btn_station_create) {
    btn_station_create.addEventListener('click', () => {
        setClassListAdd('to-station-list')
        setClassListAdd('btn-station-create')
        setClassListAdd('btn-station-edit')
        setClassListAdd('btn-section-create')
        setClassListAdd('btn-section-manage')

        setClassListRemove('to-station-create')
        station_title.innerHTML = `<span class="text-main-color-2">Add</span> new station`
    })
}

if(btn_cancel_create) {
    btn_cancel_create.addEventListener('click', () => {
        setClassListAdd('to-station-create')

        setClassListRemove('to-station-list')
        setClassListRemove('btn-station-create')
        setClassListRemove('btn-station-edit')
        setClassListRemove('btn-section-create')
        setClassListRemove('btn-section-manage')
        station_title.innerHTML = `<span class="text-main-color-2">Station</span> manager`
    })
}

if(btn_section_create) {
    btn_section_create.addEventListener('click', () => {
        setClassListAdd('to-station-list')
        setClassListAdd('btn-station-create')
        setClassListAdd('btn-station-edit')
        setClassListAdd('btn-section-create')
        setClassListAdd('btn-section-manage')

        setClassListRemove('to-section-create')
        station_title.innerHTML = `<span class="text-main-color-2">Add</span> new section`
    })
}

if(btn_section_calcel_create) {
    btn_section_calcel_create.addEventListener('click', () => {
        setClassListAdd('to-section-create')

        setClassListRemove('to-station-list')
        setClassListRemove('btn-station-create')
        setClassListRemove('btn-station-edit')
        setClassListRemove('btn-section-create')
        setClassListRemove('btn-section-manage')
        station_title.innerHTML = `<span class="text-main-color-2">Station</span> manager`
    })
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}
function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}