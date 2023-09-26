let btn_station_create = document.querySelector('#btn-station-create')
let btn_cancel_create = document.querySelector('#btn-cancel-create')
let btn_station_edit = document.querySelector('#btn-station-edit')
let btn_station_add = document.querySelector('#btn-station-add')
let btn_station_manage = document.querySelector('#btn-station-manage')

let station_list = document.querySelector('#to-station-list')
let station_create = document.querySelector('#to-station-create')

let station_title = document.querySelector('#station-page-title')

if(btn_station_create) {
    btn_station_create.addEventListener('click', () => {
        setClassListAdd('to-station-list')
        setClassListAdd('btn-station-create')
        setClassListAdd('btn-station-edit')
        setClassListAdd('btn-station-add')
        setClassListAdd('btn-station-manage')

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
        setClassListRemove('btn-station-add')
        setClassListRemove('btn-station-manage')
        station_title.innerHTML = `<span class="text-main-color-2">Station</span> manager`
    })
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}
function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}