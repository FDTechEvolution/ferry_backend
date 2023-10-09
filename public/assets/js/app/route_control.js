const page_title = document.querySelector('#route-page-title')
const btn_create = document.querySelector('#btn-route-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')
const master_from_switch = document.querySelector('#master-from-switch')
const master_to_switch = document.querySelector('#master-to-switch')
const route_status_switch = document.querySelector('#route-status-switch')

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
    let result = ' ';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}