const page_title = document.querySelector('#route-page-title')
const btn_create = document.querySelector('#btn-route-create')
const btn_cancel_create = document.querySelector('#btn-cancel-create')

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

function addRouteIcon(index) {
    const ul = document.querySelector('.list-group-horizontal')
    const active = document.querySelector(`#icon-active-${index}`)
    let icon = icons.find((item, key) => { return key === index })

    let li = document.createElement('li')
    li.classList.add('list-group-item')
    li.classList.add('bg-transparent')
    li.classList.add('border-0')
    li.id = `icon-active-on-${index}`
    li.setAttribute('style', 'max-width: 100px;')

    li.innerHTML = `<img src="${icon.path}" class="w-100">`
    ul.appendChild(li)

    active.classList.add('d-none')

    let del = document.createElement('i')
    del.classList.add('fi')
    del.classList.add('fi-round-close')
    del.classList.add('text-danger')
    del.classList.add('icon-del-style')

    del.setAttribute('onClick', `deleteIconSelected(${index})`)
    li.appendChild(del)
}