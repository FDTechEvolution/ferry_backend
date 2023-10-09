let page_title = document.querySelector('#station-info-page-title')
let btn_create = document.querySelector('#btn-station-info-create')
let btn_calcel_create = document.querySelector('#btn-cancel-create')
let btn_cancel_edit = document.querySelector('#btn-cancel-edit')

if(btn_create) {
    btn_create.addEventListener('click', () => {
        clearAllSection()

        setClassListRemove('to-station-info-create')
        page_title.innerHTML = `<span class="text-main-color-2">Add</span> station infomation`
    })
}

if(btn_calcel_create) {
    btn_calcel_create.addEventListener('click', () => {
        clearAllSection()

        setClassListRemove('to-station-info-list')
        setClassListRemove('btn-station-info-create')
        page_title.innerHTML = `<span class="text-main-color-2">Station</span> infomation`
    })
}

if(btn_cancel_edit) {
    btn_cancel_edit.addEventListener('click', () => {
        clearAllSection()
        document.querySelector('#quill-editable .ql-snow').remove()
        document.querySelector('#station-info-edit-detail').remove()

        setClassListRemove('to-station-info-list')
        setClassListRemove('btn-station-info-create')
        page_title.innerHTML = `<span class="text-main-color-2">Station</span> infomation`
    })
}

function clearAllSection() {
    let element_id = ['to-station-info-list', 'to-station-info-create', 'to-station-info-edit']
    let btn_element_id = ['btn-station-info-create']

    element_id.forEach((item) => {
        setClassListAdd(item)
    })

    btn_element_id.forEach((item) => {
        setClassListAdd(item)
    })
}

function setClassListAdd(element_id) {
    document.querySelector(`#${element_id}`).classList.add('d-none')
}
function setClassListRemove(element_id) {
    document.querySelector(`#${element_id}`).classList.remove('d-none')
}

function setModalContent(index) {
    let info = s_info.find((item, key) => { return index === key })

    document.querySelector('#station-info-modal-title').innerHTML = info.name
    document.querySelector('#station-info-modal-content').innerHTML = info.text
}

function updateStationInfoEditData(index) {
    clearAllSection()
    const create_quill = document.createElement('div')
    create_quill.id = 'station-info-edit-detail'
    document.querySelector('#quill-editable').appendChild(create_quill)

    let info = s_info.find((item, key) => { return index === key })

    document.querySelector('#edit-station-info-name').value = info.name
    // let type = document.querySelector('#edit-station-info-type')
    // type.value = info.type
    // type.options[type.selectedIndex].defaultSelected = true
    // document.querySelector('#station-info-edit-detail').innerHTML = info.text
    document.querySelector('#station-info-edit-id').value = info.id

    var quill = new Quill("#station-info-edit-detail", {
        modules: {
            toolbar: [
                [{ "header": [2, 3, 4, 5, 6, false] }],
                ["bold", "italic", "underline", "strike"],
                [{ "color": [] }, { "background": [] }],
                [{ "script": "super" }, { "script": "sub" }],
                ["blockquote"],
                [{ "list": "ordered" }, { "list": "bullet"}, { "indent": "-1" }, { "indent": "+1" }],
                [{ "align": [] }],
                ["link", "image", "video"],
                ["clean", "code-block"]
            ]
        },
        theme: "snow"
    });
    quill.pasteHTML(info.text);
    quill.on('text-change', function(delta, oldDelta, source) {
        document.querySelector('#edit-detail-textarea').innerHTML = quill.container.firstChild.innerHTML
        // console.log(quill.container.firstChild.innerHTML)
    })

    setClassListRemove('to-station-info-edit')
    page_title.innerHTML = `<span class="text-main-color-2">Edit</span> Station infomation`
}