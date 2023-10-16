const page_title = document.querySelector('#route-page-title')
const btn_create = document.querySelector('#btn-route-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')
const master_from_switch = document.querySelector('#master-from-switch')
const master_to_switch = document.querySelector('#master-to-switch')
const route_status_switch = document.querySelector('#route-status-switch')

const station_to_selected = document.querySelector('#station-to-selected')

const info_icon = 'fi fi-squared-info'
const remove_icon = 'fi fi-round-close'

if(btn_create) {
    btn_create.addEventListener('click', () => {
        clearAllSection()

        setClassListRemove('to-route-create')
        page_title.innerHTML = `<span class="text-main-color-2">Add</span> new Route`
    })
}

if(btn_cancel_create) {
    btn_cancel_create.addEventListener('click', () => {
        clearAllSection()

        setClassListRemove('to-route-list')
        setClassListRemove('btn-route-create')
        page_title.innerHTML = `<span class="text-main-color-2">Route</span> control`
    })
}

if(master_from_switch) {
    let text = document.querySelector('#master-from-text')
    master_from_switch.addEventListener('change', (e) => {
        text.innerHTML = e.target.checked ? 'On' : 'Off'
    })
}

if(master_to_switch) {
    let text = document.querySelector('#master-to-text')
    master_to_switch.addEventListener('change', (e) => {
        text.innerHTML = e.target.checked ? 'On' : 'Off'
    })
}

if(route_status_switch) {
    let text = document.querySelector('#route-status-text')
    route_status_switch.addEventListener('change', (e) => {
        text.innerHTML = e.target.checked ? 'On' : 'Off'
    })
}

// Create Master From


// Create Master To
// if(station_to_selected) {
//     station_to_selected.addEventListener('change', (e) => {
//         document.querySelector('#btn-master-to-select').disabled = false
//         let res = stations.find((item) => { return item.id === e.target.value })
//         let infos = res.info_line.filter((item) => { return item.pivot.type === 'to' })
//         if(infos.length > 0) {
//             setInfomationListSelect(infos, 'to', e.target.value)
//         }
//         else {
//             let ul = clearInfomationList('station-infomation-list')

//             let _li = document.createElement('li')
//             let _label = document.createElement('label')

//             _li.setAttribute('class', 'list-group-item border-0 border-bottom rounded-0')

//             _label.classList.add('ms-2')
//             _label.innerHTML = 'No infomation list.'

//             _li.appendChild(_label)
//             ul.appendChild(_li)
//         }
//         // setMasterStationList(infos, '#master-to-choose', 'to', e.target.value)
//     })
// }





function addMasterInfoFrom(e, index, station_id) {
    if(e.checked) {
        const choosed = document.querySelector('#master-from-selected')
        let _station = stations.find((item) => { return item.id === station_id })
        let _info = _station.info_line.find((item) => { return item.id === e.value })
        let rand = generateString(8)
        let li = document.createElement('li')
        li.setAttribute('class', 'info-from-active-on list-group-item')
        li.id = rand
        li.innerHTML = `${_info.name} 
                        <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="viewInfo('${_info.id}', 'from')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', ${index}, '${_info.id}')"></i>`
        choosed.appendChild(li)
    }
    else {
        console.log('uncheck')
    }
}

function setMasterStationList(infos, element_id, type, station_id) {
    const master_list = document.querySelector(element_id)
    let li_list = master_list.querySelectorAll('li')
    li_list.forEach((li) => { li.remove() })

    let li_name = type === 'from' ? 'master_from[]' : 'master_to[]'

    if(infos.length <= 0) setNoDataList(element_id)
    infos.forEach((info, index) => {
        let _li = document.createElement('li')
        let _input = document.createElement('input')
        let _label = document.createElement('label')
        let _icon = document.createElement('i')

        _li.classList.add('list-group-item')

        _input.setAttribute('name', li_name)
        _input.setAttribute('type', 'checkbox')
        _input.classList.add('form-check-input')
        _input.classList.add('me-1')
        _input.value = info.id
        _input.id = `input-${type}-${index}`

        _label.classList.add('ms-2')
        _label.setAttribute('for', `input-${type}-${index}`)
        _label.innerHTML = info.name

        _icon.classList.add('fi')
        _icon.classList.add('fi-squared-info')
        _icon.classList.add('ms-2')
        _icon.classList.add('text-primary')
        _icon.classList.add('cursor-pointer')
        _icon.setAttribute('onClick', `showStationInfo('${info.id}', '${station_id}', '${type}')`)

        _li.appendChild(_input)
        _li.appendChild(_label)
        _li.appendChild(_icon)
        master_list.appendChild(_li)
    })

    if(typeof route !== 'undefined') {
        masterInfoListChecked('#master-from-choose', 'from', station_id)
        masterInfoListChecked('#master-to-choose', 'to', station_id)
    }
}

function setNoDataList(element_id) {
    const ul = document.querySelector(element_id)
    let _li = document.createElement('li')
    let _span = document.createElement('span')

    _li.classList.add('list-group-item')
    _span.classList.add('ms-2')
    _span.innerHTML = 'No Data List.'

    _li.appendChild(_span)
    ul.appendChild(_li)
}

function setMasterInfoListData() {
    let info_from = getStationInfoByType(route.station_from_id, 'from')
    let info_to = getStationInfoByType(route.station_to_id, 'to')
    setMasterStationList(info_from, '#master-from-choose', 'from', route.station_from_id)
    setMasterStationList(info_to, '#master-to-choose', 'to', route.station_to_id)
}

function masterInfoListChecked(element_id, type, station_id) {
    const master_list = document.querySelector(element_id)
    let _station_id = type === 'from' ? route.station_from_id : route.station_to_id
    let input_list = master_list.querySelectorAll('li input')
    input_list.forEach((_input) => {
        route.station_lines.find((item) => {
            if(station_id === _station_id) {
                if(item.pivot.type === type && _input.value === item.id) _input.checked = true
            }
        })
    })
}

function getStationInfoByType(station_id, type) {
    let res = stations.find((item) => { return item.id === station_id })
    return res.info_line.filter((item) => { return item.pivot.type === type })
}

function showStationInfo(info_id, station_id, type) {
    let info_type = type === 'to' ? 'Master To : ' : 'Master From : '
    let res = stations.find((item) => { return item.id === station_id })
    let info = res.info_line.find((item) => { return item.id === info_id })
        
    document.querySelector('#station-info-modal-title').innerHTML = `<strong>${info_type}</strong> ${info.name}`
    document.querySelector('#station-info-modal-content').innerHTML = info.text
    $('#modal-station-info').modal('show')
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}
function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function clearAllSection() {
    setClassListAdd('to-route-list')
    setClassListAdd('to-route-create')

    setClassListAdd('btn-route-create')
}

function updateEditData(index) {

}

let icon_position = []
let icon_input = []
function addRouteIcon(index) {
    if(icon_input.length < 6) {
        setClassListAdd('icon-notice')
        document.querySelector('#dropdownIcons').disabled = false
        const ul = document.querySelector('.list-group-horizontal')
        const icon_list = document.querySelector('#route-add-icon')
        let icon = icons.find((item, key) => { return key === index })

        let rand = generateString(8)
        icon_position.push(rand)
        let li = document.createElement('li')
        li.classList.add('list-group-item')
        li.classList.add('bg-transparent')
        li.classList.add('border-0')
        li.classList.add('icon-active-on')
        li.id = rand
        li.setAttribute('style', 'max-width: 100px;')

        li.innerHTML = `<img src="${icon.path}" class="w-100">`
        ul.appendChild(li)

        let del = document.createElement('i')
        del.classList.add('fi')
        del.classList.add('fi-round-close')
        del.classList.add('text-danger')
        del.classList.add('cursor-pointer')
        del.classList.add('icon-del-style')

        del.setAttribute('onClick', `deleteIconSelected('${rand}', '${icon.id}')`)
        li.appendChild(del)

        icon_input.push(icon.id)
        icon_list.value = icon_input
    }
    
    if(icon_input.length >= 6) {
        setClassListRemove('icon-notice')
        document.querySelector('#dropdownIcons').disabled = true
    }
}

function deleteIconSelected(rand, id) {
    const icon_list = document.querySelector('#route-add-icon')
    const icon_active = document.querySelectorAll('.icon-active-on')

    icon_active.forEach((item, index) => {
        if(item.id === rand) item.remove()
    })

    let _index = icon_input.findIndex(item => item === id)
    icon_input.splice(_index, 1)
    icon_list.value = icon_input
    setClassListAdd('icon-notice')
    document.querySelector('#dropdownIcons').disabled = false
}

function setRouteIcon() {
    if(icon_input.length < 6) {
        setClassListAdd('icon-notice')
        document.querySelector('#dropdownIcons').disabled = false
        const ul = document.querySelector('.list-group-horizontal')
        const icon_list = document.querySelector('#route-add-icon')

        route_icons.forEach((icon, index) => {
            let rand = generateString(8)
            icon_position.push(rand)
            let li = document.createElement('li')
            li.classList.add('list-group-item')
            li.classList.add('bg-transparent')
            li.classList.add('border-0')
            li.classList.add('icon-active-on')
            li.id = rand
            li.setAttribute('style', 'max-width: 100px;')

            li.innerHTML = `<img src="${icon.path}" class="w-100">`
            ul.appendChild(li)

            let del = document.createElement('i')
            del.classList.add('fi')
            del.classList.add('fi-round-close')
            del.classList.add('text-danger')
            del.classList.add('cursor-pointer')
            del.classList.add('icon-del-style')

            del.setAttribute('onClick', `deleteIconSelected('${rand}', '${icon.id}')`)
            li.appendChild(del)

            icon_input.push(icon.id)
            icon_list.value = icon_input
        })
    }

    if(icon_input.length >= 6) {
        setClassListRemove('icon-notice')
        document.querySelector('#dropdownIcons').disabled = true
    }
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

let _button_id = ''
let _station_id = ''
let _type = ''
let _list_id = ''
let _ul_id = ''
let _input_id = ''
function setModalCreateId(button_id, station_id, type, list_id, ul_id, input_id) {
    _button_id = button_id
    _station_id = station_id
    _type = type
    _list_id = list_id
    _ul_id = ul_id
    _input_id = input_id
    document.querySelector('#station-id-info').value = station_id
    document.querySelector('#station-type-info').value = type
}

function cancelModalCreateInfomation() {
    document.querySelector(`#btn-${_button_id}`).click()
}

// loading station with ajax
getInfoStation()
async function getInfoStation() {
    document.querySelector('#icon-update-info-loading').classList.remove('d-none')
    let response = await fetch(`/ajax/get-station-info`)
    let res = await response.json()

    if(res.status === 'success') {
        stations = res.data
        document.querySelector('#icon-update-info-loading').classList.add('d-none')
    }
}
let from_list_id = []
let to_list_id = []
function saveAllListId(type, list_id, ul_id, input_id) {
    if(type === 'from') {
        let _from = {
            'list': list_id,
            'ul': ul_id,
            'input': input_id
        }
        from_list_id.push(_from)
    }
    if(type === 'to') {
        let _to = {
            'list': list_id,
            'ul': ul_id,
            'input': input_id
        }
        to_list_id.push(_to)
    }
}