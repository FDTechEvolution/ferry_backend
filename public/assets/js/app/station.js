const btn_station_create = document.querySelector('#btn-station-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')
const btn_station_edit = document.querySelector('#btn-station-edit')
const btn_section_create = document.querySelector('#btn-section-create')
const btn_section_calcel_create = document.querySelector('#btn-section-cancel-create')
const btn_station_cancel_edit = document.querySelector('#btn-cancel-edit')
const btn_station_manage = document.querySelector('#btn-section-manage')
const btn_section_cancel_manage = document.querySelector('#btn-section-cancel-manage')
const btn_section_cancel_edit = document.querySelector('#btn-section-cancel-edit')

const station_list = document.querySelector('#to-station-list')
const station_create = document.querySelector('#to-station-create')
const section_create = document.querySelector('#to-section-create')

const station_title = document.querySelector('#station-page-title')
let edit_data = []

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

if(btn_station_manage) {
    btn_station_manage.addEventListener('click', () => {
        toSectionManage()
    })
}

if(btn_section_cancel_edit) {
    btn_section_cancel_edit.addEventListener('click', () => {
        toSectionManage()
    })
}

if(btn_cancel_create) {
    btn_cancel_create.addEventListener('click', () => {
        toMainMenu()
    })
}

if(btn_section_calcel_create) {
    btn_section_calcel_create.addEventListener('click', () => {
        toMainMenu()
    })
}

if(btn_section_cancel_manage) {
    btn_section_cancel_manage.addEventListener('click', () => {
        toMainMenu()
    })
}

if(btn_station_cancel_edit) {
    btn_station_cancel_edit.addEventListener('click', () => {
        clearSection()
        document.querySelector('#edit-station-pier').value = ''

        setClassListRemove('to-station-list')
        setClassListRemove('btn-station-create')
        setClassListRemove('btn-station-edit')
        setClassListRemove('btn-section-create')
        setClassListRemove('btn-section-manage')
        station_title.innerHTML = `<span class="text-main-color-2">Station</span> manage`
    })
}

function clearSection() {
    setClassListAdd('to-section-create')
    setClassListAdd('to-section-manage')
    setClassListAdd('to-station-create')
    setClassListAdd('to-station-edit')
    setClassListAdd('to-station-list')
    setClassListAdd('btn-station-create')
    setClassListAdd('btn-station-edit')
    setClassListAdd('btn-section-create')
    setClassListAdd('btn-section-manage')
}

function toMainMenu() {
    setClassListAdd('to-section-create')
    setClassListAdd('to-section-manage')
    setClassListAdd('to-station-create')

    setClassListRemove('to-station-list')
    setClassListRemove('btn-station-create')
    setClassListRemove('btn-station-edit')
    setClassListRemove('btn-section-create')
    setClassListRemove('btn-section-manage')
    station_title.innerHTML = `<span class="text-main-color-2">Station</span> manage`
}

function toSectionManage() {
    setClassListAdd('to-station-list')
    setClassListAdd('to-section-create')
    setClassListAdd('to-section-edit')
    setClassListAdd('btn-station-create')
    setClassListAdd('btn-station-edit')
    setClassListAdd('btn-section-create')
    setClassListAdd('btn-section-manage')
    
    setClassListRemove('to-section-manage')
    setClassListRemove('to-section-list')
    setClassListRemove('btn-section-cancel-manage')
    station_title.innerHTML = `<span class="text-main-color-2">Manage</span> section`
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}
function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function updateSectionEditData(index) {
    let id = document.querySelector(`#section-id-${index}`)
    let name = document.querySelector(`#section-name-${index}`)
    
    setClassListAdd('to-section-list')
    setClassListAdd('btn-section-cancel-manage')
    setClassListRemove('to-section-edit')

    document.querySelector('#section-name-edit').value = name.innerText
    document.querySelector('#section-id-edit').value = id.value
}

function updateStationEditData(index) {
    clearSection()
    setClassListRemove('to-station-edit')
    station_title.innerHTML = `<span class="text-main-color-2">Edit</span> section`
    
    let station = stations.find((item, key) => { return key === index })
    document.querySelector('#edit-station-id').value = station.id
    document.querySelector('#edit-station-name').value = station.name
    document.querySelector('#edit-station-pier').value = station.piername
    document.querySelector('#edit-station-nickname').value = station.nickname
    document.querySelector('#edit-station-status').checked = station.isactive === 'Y' ? true : false
    let section = document.querySelector('#edit-station-section')
    section.value = station.section.id
    section.options[section.selectedIndex].defaultSelected = true
    let sort = document.querySelector('#edit-station-sort')
    sort.value = station.sort
    sort.options[sort.selectedIndex].defaultSelected = true
}