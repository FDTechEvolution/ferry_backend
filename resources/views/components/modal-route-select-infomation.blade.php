@props(['header' => '', 'select_id' => '', 'type' => '', 'input_id' => ''])

@php
    $modal_id = uniqid();
    $list_id = uniqid();
    $button_id = uniqid();
    $ul_id = uniqid();
    $btn_create = uniqid();
@endphp

<button type="button" class="btn btn-outline-dark btn-sm w-100 btn-infomation-select" id="btn-{{ $button_id }}" data-bs-toggle="modal" data-bs-target="#modal-{{ $modal_id }}" disabled>Select/Add Information</button>
<ul class="list-group" id="master-{{ $ul_id }}"></ul>

<div class="modal fade" id="modal-{{ $modal_id }}" style="z-index: 1059;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-75">{{ $header }}
                    <button type="button" class="btn btn-sm button-orange-bg w-25 ms-3" data-bs-toggle="modal" data-bs-target="#create-infomation" id="btn-{{ $btn_create }}">Add</button>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="list-{{ $list_id }}">
                    <li class="list-group-item border-0 border-bottom rounded-0">
                        No infomation list.
                    </li>
                </ul>
                <i class="fi fi-loading-dots fi-spin mt-2 ms-6 d-none" id="icon-update-info-loading"></i>
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<script>
if(document.querySelector(`#{{ $select_id }}`)) {
    document.querySelector(`#{{ $select_id }}`).addEventListener('change', (e) => {
        const list_id = `{{ $list_id }}`
        const button_id = `{{ $button_id }}`
        const type = `{{ $type }}`
        const ul_id = `{{ $ul_id }}`
        const input_id = `{{ $input_id }}`
        const button_create = `{{ $btn_create }}`

        document.querySelector(`#btn-${button_create}`).setAttribute('onClick', `setModalCreateId('${button_id}', '${e.target.value}', '${type}', '${list_id}', '${ul_id}', '${input_id}')`)
        document.querySelector(`#btn-${button_id}`).disabled = false
        let res = stations.find((item) => { return item.id === e.target.value })
        let infos = res.info_line.filter((item) => { return item.pivot.type === type })
        clearInfomationList(list_id)
        clearInfomationSelected(ul_id)
        clearInfomationInput(input_id)
        if(infos.length > 0) {
            setInfomationListSelect(infos, type, e.target.value, list_id, ul_id, input_id)
        }
        else {
            let ul = document.querySelector(`#list-${list_id}`)

            let _li = document.createElement('li')
            let _label = document.createElement('label')

            _li.setAttribute('class', 'list-group-item border-0 border-bottom rounded-0')

            _label.classList.add('ms-2')
            _label.innerHTML = 'No infomation list...'

            _li.appendChild(_label)
            ul.appendChild(_li)
        }
    })
}

function setInfomationListSelect(infos, type, station_id, list_id, ul_id, input_id) {
    saveAllListId(type, list_id, ul_id, input_id)
    let li_name = type === 'from' ? 'master_from[]' : 'master_to[]'
    let ul = document.querySelector(`#list-${list_id}`)
    infos.forEach((info, index) => {
        // console.log(info)
        let _li = document.createElement('li')
        let _input = document.createElement('input')
        let _label = document.createElement('label')
        let _icon = document.createElement('i')
        let rand = generateString(8)

        _li.setAttribute('class', 'list-group-item border-0 border-bottom rounded-0')

        // _input.setAttribute('name', li_name)
        _input.setAttribute('type', 'checkbox')
        _input.setAttribute('class', 'form-check-input me-1')
        _input.value = info.id
        _input.id = `input-${rand}`
        _input.setAttribute('onClick', `addMasterInfoList(this, ${index}, '${station_id}', '${type}', '${ul_id}', '${input_id}')`)

        _label.classList.add('ms-2')
        _label.setAttribute('for', `input-${rand}`)
        _label.innerHTML = info.name

        _icon.setAttribute('class', 'fi fi-squared-info ms-2 text-primary cursor-pointer')
        _icon.setAttribute('onClick', `showStationInfo('${info.id}', '${station_id}', '${type}')`)

        _li.appendChild(_input)
        _li.appendChild(_label)
        _li.appendChild(_icon)
        ul.appendChild(_li)
    })
}

function addMasterInfoList(e, index, station_id, type, ul_id, input_id) {
    const _input = document.querySelector(`#${input_id}`)
    if(e.checked) {
        const _ul = document.querySelector(`#master-${ul_id}`)
        let res = stations.find((item) => { return item.id === station_id })
        // let res = await getInfoStation(e.target.value, type)
        let _info = res.info_line.find((item) => { return item.id === e.value })

        let rand = generateString(8)
        let li = document.createElement('li')
        li.setAttribute('class', 'list-group-item info-from-active-on')
        li.setAttribute('data-id', _info.id)
        li.id = rand
        li.innerHTML = `${_info.name} 
                        <i class="${info_icon} ms-2 text-primary cursor-pointer" title="View" onClick="showStationInfo('${_info.id}', '${station_id}', '${type}')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', ${index}, '${_info.id}', '${ul_id}', '${input_id}', '${type}')"></i>`
        _ul.appendChild(li)

        e.setAttribute('data-rand', rand)
        _input.value = _input.value === '' ? _info.id : `${_input.value},${_info.id}`
    }
    else {
        let get_rand = e.getAttribute('data-rand')
        removeInfoFrom(get_rand, index, e.value, ul_id, input_id, type)
    }
}

function removeInfoFrom(rand, index, info_id, ul_id, input_id, type) {
    const _input = document.querySelector(`#${input_id}`)
    const _checked = document.querySelector(`[data-rand="${rand}"]`)
    const _ul = document.querySelector(`#master-${ul_id}`)
    const _li = document.querySelectorAll('li')
    _li.forEach((item) => { if(item.id === rand) item.remove() })

    let new_value = []
    let input_value = _input.value.split(',')
    let input_index = input_value.findIndex(item => item === info_id)
    input_value.splice(input_index, 1)
    _input.value = input_value

    _checked.checked = false
}

async function loadNewInfomation(station_id, type, list_id, ul_id, input_id) {
    await getInfoStation()
    let res = await stations.find((item) => { return item.id === station_id })
    let infos = await res.info_line.filter((item) => { return item.pivot.type === type })

    let is_type = type === 'from' ? from_list_id : to_list_id
    let unique_list = [
        ...new Map(is_type.map((item) => [item["input"], item])).values(),
    ];
    unique_list.forEach(async (item) => {
        await clearInfomationList(item.list)
        await setInfomationListSelect(infos, type, station_id, item.list, item.ul, item.input)
        await setPreviousCheckedList(infos, item.ul, item.list)
    })
}

function setPreviousCheckedList(infos, ul_id, list_id) {
    const _ul = document.querySelector(`#master-${ul_id}`)
    const _li = _ul.querySelectorAll('li')
    const _ul_list = document.querySelector(`#list-${list_id}`)
    const _li_list = _ul_list.querySelectorAll('li input')

    _li.forEach((li) => {
        let get_id = li.getAttribute('data-id')
        let get_rand = li.id
        _li_list.forEach((item) => {
            if(item.value === get_id) {
                item.checked = true
                item.setAttribute('data-rand', get_rand)
            }
        })
    })
}
</script>