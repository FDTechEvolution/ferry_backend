const btn_station_create = document.querySelector('#btn-station-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')
const btn_station_edit = document.querySelector('#btn-station-edit')
const btn_section_create = document.querySelector('#btn-section-create')
const btn_section_calcel_create = document.querySelector('#btn-section-cancel-create')
const btn_station_cancel_edit = document.querySelector('#btn-cancel-edit')
const btn_station_manage = document.querySelector('#btn-section-manage')
const btn_section_cancel_manage = document.querySelector('#btn-section-cancel-manage')
const btn_section_cancel_edit = document.querySelector('#btn-section-cancel-edit')
const master_info_from = document.querySelector('#station-info-from')
const master_info_to = document.querySelector('#station-info-to')
const master_info_from_edit = document.querySelector('#edit-station-info-from')
const master_info_to_edit = document.querySelector('#edit-station-info-to')
const edit_active_status = document.querySelector('#edit-station-status')
const create_active_status = document.querySelector('#station-status')

const station_list = document.querySelector('#to-station-list')
const station_create = document.querySelector('#to-station-create')
const section_create = document.querySelector('#to-section-create')

const info_icon = 'fi fi-squared-info'
const remove_icon = 'fi fi-round-close'

const station_title = document.querySelector('#station-page-title')
let edit_data = []
let info_from_id = ''
let info_to_id = ''

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
    // btn_section_cancel_manage.addEventListener('click', () => {
    //     toMainMenu()
    // })
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

if(master_info_to) {
    master_info_to.addEventListener('change', (e) => {
        info_to_id = e.target.value
        setMasterInfo(info_to_id, 'to-info-text', 'to')
    })
}

if(master_info_from_edit) {
    master_info_from_edit.addEventListener('change', (e) => {
        info_from_id = e.target.value
        setMasterInfo(info_from_id, 'edit-from-info-text', 'from')
    })
}

if(master_info_to_edit) {
    master_info_to_edit.addEventListener('change', (e) => {
        info_to_id = e.target.value
        setMasterInfo(info_to_id, 'edit-to-info-text', 'to')
    })
}

if(create_active_status) {
    create_active_status.addEventListener('click', (e) => {
        setSwitchText(e.target.checked, 'station-status-checked')
    })
}

if(edit_active_status) {
    edit_active_status.addEventListener('click', (e) => {
        setSwitchText(e.target.checked, 'edit-station-status-checked')
    })
}

function setSwitchText(status, element_id) {
    document.querySelector(`#${element_id}`).innerHTML = status ? 'On' : 'Off'
}

function setMasterInfo(info_id, element_id, type) {
    let _icon = document.querySelector(`#${element_id}`)
    if(info_id !== '') {
        _icon.classList.add('cursor-pointer')
        _icon.classList.add('text-primary')
        _icon.classList.remove('text-secondary')
        _icon.setAttribute('data-bs-toggle', 'modal')
        _icon.setAttribute('data-bs-target', '#modal-station-info')
        _icon.setAttribute('onClick', `setDataInfo('${type}')`)
    }
    else {
        _icon.classList.remove('cursor-pointer')
        _icon.classList.remove('text-primary')
        _icon.classList.add('text-secondary')
        _icon.removeAttribute('data-bs-toggle')
        _icon.removeAttribute('data-bs-target')
        _icon.removeAttribute('onClick')
    }
}

function setDataInfo(type) {
    let info_id = type === 'to' ? info_to_id : info_from_id
    let info_type = type === 'to' ? 'Master Info To : ' : 'Master Info From : '
    let info = station_info.find((item, index) => { return item.id === info_id })

    document.querySelector('#station-info-modal-title').innerHTML = `<strong>${info_type}</strong> ${info.name}`
    document.querySelector('#station-info-modal-content').innerHTML = info.text
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
    info_to_id = ''
    info_from_id = ''
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
    // setClassListAdd('to-station-list')
    // setClassListAdd('to-section-create')
    setClassListAdd('to-section-edit')
    // setClassListAdd('btn-station-create')
    // setClassListAdd('btn-station-edit')
    // setClassListAdd('btn-section-create')
    // setClassListAdd('btn-section-manage')

    // setClassListRemove('to-section-manage')
    setClassListRemove('to-section-list')
    setClassListRemove('btn-section-cancel-manage')
    // station_title.innerHTML = `<span class="text-main-color-2">Manage</span> section`
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
    let sort = document.querySelector(`#section-sort-${index}`);

    setClassListAdd('to-section-list')
    setClassListAdd('btn-section-cancel-manage')
    setClassListRemove('to-section-edit')

    document.querySelector('#section-name-edit').value = name.innerText
    document.querySelector('#section-id-edit').value = id.value
    // document.querySelector('#section-sort-edit').value = sort.innerText
    document.querySelector(`#option_${sort.innerText}`).selected = true
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
    document.querySelector('#edit-station-status-checked').innerHTML = station.isactive === 'Y' ? 'On' : 'Off'

    let info_from = document.querySelector('#edit-station-info-from')
    info_from.value = station.station_infomation_from_id !== null ? station.station_infomation_from_id : ''
    info_from.options[info_from.selectedIndex].defaultSelected = true

    let info_to = document.querySelector('#edit-station-info-to')
    info_to.value = station.station_infomation_to_id !== null ? station.station_infomation_to_id : ''
    info_to.options[info_to.selectedIndex].defaultSelected = true

    let section = document.querySelector('#edit-station-section')
    section.value = station.section.id
    section.options[section.selectedIndex].defaultSelected = true

    let sort = document.querySelector('#edit-station-sort')
    sort.value = station.sort
    sort.options[sort.selectedIndex].defaultSelected = true
}

const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
function generateString(length) {
    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}

// Add / Remove Master Info From
const input_info_from_list = document.querySelector('#input-station-info-from-list')
let info_from_value = []
let rand_from = []
function addMasterInfoFrom(e, index) {
    if(e.checked) {
        const info_from_list = document.querySelector('#station-info-from-list')
        let _info = station_info.find((item, key) => { return key === index })
        let rand = generateString(8)
        let li = document.createElement('li')
        li.classList.add('info-from-active-on')
        li.id = rand
        li.innerHTML = `${_info.name}
                        <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="viewInfo('${_info.id}', 'from')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', ${index}, '${_info.id}')"></i>`
        info_from_list.appendChild(li)

        info_from_value.push(_info.id)
        input_info_from_list.value = info_from_value
        // document.querySelector(`#info-from-active-${index}`).classList.add('d-none')
        if(info_from_value.length > 0) info_from_list.classList.remove('d-none')
        e.setAttribute('data-rand', rand)
        e.setAttribute('data-id', _info.id)
    }
    else{
        let get_rand = e.getAttribute('data-rand')
        let get_id = e.getAttribute('data-id')
        removeInfoFrom(get_rand, index, get_id)
    }
}
function removeInfoFrom(rand, index, id) {
    const info_from_list = document.querySelector('#station-info-from-list')
    const info_active = document.querySelectorAll('.info-from-active-on')

    let _index = info_from_value.findIndex(item => item === id)
    info_from_value.splice(_index, 1)
    input_info_from_list.value = info_from_value

    info_active.forEach((item, index) => {
        if(item.id === rand) item.remove()
    })
    // document.querySelector(`#info-from-active-${index}`).classList.remove('d-none')
    document.querySelector(`#input-from-checked-${index}`).checked = false
    if(info_from_value.length <= 0) info_from_list.classList.add('d-none')
}



// Add / Remove Master Info To
const input_info_to_list = document.querySelector('#input-station-info-to-list')
let info_to_value = []
function addMasterInfoTo(e, index) {
    if(e.checked) {
        const info_to_list = document.querySelector('#station-info-to-list')
        let _info = station_info.find((item, key) => { return key === index })
        let rand = generateString(8)
        let li = document.createElement('li')
        li.classList.add('info-to-active-on')
        li.id = rand
        li.innerHTML = `${_info.name}
                        <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="viewInfo('${_info.id}', 'to')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoTo('${rand}', ${index}, '${_info.id}')"></i>`
                        info_to_list.appendChild(li)

        info_to_value.push(_info.id)
        input_info_to_list.value = info_to_value
        // document.querySelector(`#info-to-active-${index}`).classList.add('d-none')
        if(info_to_value.length > 0) info_to_list.classList.remove('d-none')
        e.setAttribute('data-rand', rand)
        e.setAttribute('data-id', _info.name)
    }
    else{
        let get_rand = e.getAttribute('data-rand')
        let get_id = e.getAttribute('data-id')
        removeInfoTo(get_rand, index, get_id)
    }
}
function removeInfoTo(rand, index, id) {
    const info_to_list = document.querySelector('#station-info-to-list')
    const info_active = document.querySelectorAll('.info-to-active-on')

    let _index = info_to_value.findIndex(item => item === id)
    info_to_value.splice(_index, 1)
    input_info_to_list.value = info_to_value

    info_active.forEach((item, index) => {
        if(item.id === rand) item.remove()
    })
    // console.log(index)
    // document.querySelector(`#info-to-active-${index}`).classList.remove('d-none')
    document.querySelector(`#input-to-checked-${index}`).checked = false
    if(info_to_value.length <= 0) info_to_list.classList.add('d-none')
}


// View Info

function viewInfo(info_id, type) {
    let _info = station_info.find((item, index) => { return item.id === info_id })
    let info_type = type === 'to' ? 'Master Info To : ' : 'Master Info From : '

    document.querySelector('#station-info-modal-title').innerHTML = `<strong>${info_type}</strong> ${_info.name}`
    document.querySelector('#station-info-modal-content').innerHTML = _info.text
    $('#modal-station-info').modal('show')
}


function setMasterInfo() {
    const info_from_list = document.querySelector('#station-info-from-list')
    const info_to_list = document.querySelector('#station-info-to-list')

    info_lines.forEach((_info, index) => {
        let rand = generateString(8)
        let li = document.createElement('li')

        if(_info.pivot.type === 'from') {
            // let index_remove = clearInfoDropdown('ul-dropdown-info-from', _info.name)
            let index_checked = setDataInfoChecked(_info.name, rand, _info.id, 'from')
            info_from_list.classList.remove('d-none')
            li.classList.add('info-from-active-on')
            li.id = rand
            li.innerHTML = `${_info.name}
                            <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="viewInfo('${_info.id}', 'from')"></i>
                            <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', ${index_checked}, '${_info.id}')"></i>`
            info_from_list.appendChild(li)

            info_from_value.push(_info.id)
            input_info_from_list.value = info_from_value
        }
        if(_info.pivot.type === 'to') {
            // let index_remove = clearInfoDropdown('ul-dropdown-info-to', _info.name)
            let index_checked = setDataInfoChecked(_info.name, rand, _info.id, 'to')
            info_to_list.classList.remove('d-none')
            li.classList.add('info-to-active-on')
            li.id = rand
            li.innerHTML = `${_info.name}
                            <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="viewInfo('${_info.id}', 'to')"></i>
                            <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoTo('${rand}', ${index_checked}, '${_info.id}')"></i>`
            info_to_list.appendChild(li)

            info_to_value.push(_info.id)
            input_info_to_list.value = info_to_value
        }
    })
}

function clearInfoDropdown(element_id, _name) {
    const ul = document.querySelector(`#${element_id}`)
    let _li = ul.querySelectorAll('li')
    let _index = ''
    _li.forEach((item, index) => {
        let name = item.innerText.replace(/^\s+|\s+$/gm,'')
        if(name === _name) {
            item.classList.add('d-none')
            _index = index
        }
    })
    return _index
}

function setDataInfoChecked(name, rand, id, type) {
    const _tbody = document.querySelector('#modal-data-list-tbody')
    let _tr = _tbody.querySelectorAll('.tr-master-list')
    let _index = ''
    _tr.forEach((item, index) => {
        let input_checked = type === 'from' ? document.querySelector(`#input-from-checked-${index}`) : document.querySelector(`#input-to-checked-${index}`)
        let td = item.getElementsByTagName('td')
        if(td[1].innerText === name) {
            input_checked.checked = true
            input_checked.setAttribute('data-rand', rand)
            input_checked.setAttribute('data-id', id)
            _index = index
        }
    })

    return _index
}

const section_active = document.querySelectorAll('.section-isactive')
if(section_active) {
    section_active.forEach((item, index) => {
        item.addEventListener('change', async (e) => {
            let response = await fetch(`/ajax/section/update-status/${e.target.value}`)
            let res = await response.json()
            if(res['result']) $.SOW.core.toast.show('success', '', `${res['section']} section status updated.`, 'top-right', 0, true);
            else $.SOW.core.toast.show('danger', '', `Something wrong ${res['section']}.`, 'top-right', 0, true);
        })
    })
}

const station_active = document.querySelectorAll('.station-isactive')
if(station_active) {
    station_active.forEach((item, index) => {
        item.addEventListener('change', async (e) => {
            let response = await fetch(`/ajax/station/update-status/${e.target.value}`)
            let res = await response.json()
            if(res['result']) $.SOW.core.toast.show('success', '', `${res['station']} station status updated.`, 'top-right', 0, true);
            else $.SOW.core.toast.show('danger', '', `Something wrong ${res['station']}.`, 'top-right', 0, true);
        })
    })
}
