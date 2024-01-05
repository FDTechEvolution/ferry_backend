@props(['header' => '', 'select_id' => '', 'type' => '', 'ismaster' => '', 'input_id' => '', 'data' => [], 'stations' => [],'turnon'=>'Y'])

@php
    $modal_id = uniqid();
    $list_id = uniqid();
    $button_id = uniqid();
    $ul_id = uniqid();
    $btn_create = uniqid();
@endphp

<button type="button" class="btn btn-outline-dark btn-sm w-100 btn-infomation-select" id="btn-{{ $button_id }}" data-bs-toggle="modal" data-bs-target="#modal-{{ $modal_id }}">Select/Add Information</button>
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
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>


<style>
    span.info-content-text p {
        border: 1px solid #e1e1e1;
        padding: 5px;
        border-radius: 10px;
        font-size: 14px;
        background-color: #f9f9f9;
    }
</style>


<script>

setInfomationListData()

if(document.querySelector(`#{{ $select_id }}`)) {
    document.querySelector(`#{{ $select_id }}`).addEventListener('change', (e) => {
        const list_id = `{{ $list_id }}`
        const button_id = `{{ $button_id }}`
        const type = `{{ $type }}`
        const ul_id = `{{ $ul_id }}`
        const input_id = `{{ $input_id }}`
        const button_create = `{{ $btn_create }}`
        const ismaster = `{{ $ismaster }}`

        document.querySelector(`#btn-${button_create}`).setAttribute('onClick', `setModalCreateId('${button_id}', '${e.target.value}', '${type}', '${list_id}', '${ul_id}', '${input_id}')`)
        document.querySelector(`#btn-${button_id}`).disabled = false
        let res = stations.find((item) => { return item.id === e.target.value })
        let infos = res.info_line.filter((item) => { return item.pivot.type === type })
        clearInfomationList2(list_id)
        clearInfomationSelected2(ul_id)
        clearInfomationInput2(input_id)
        if(infos.length > 0) {
            setInfomationListSelect(infos, type, e.target.value, list_id, ul_id, input_id, false,ismaster)
            setInfomationOnChange(e.target.value, type, ismaster, list_id, ul_id, input_id)
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

function setInfomationListSelect(infos, type, station_id, list_id, ul_id, input_id, _new,_ismaster) {
    saveAllList(type, list_id, ul_id, input_id)
    let li_name = type === 'from' ? 'master_from[]' : 'master_to[]'
    let ul = document.querySelector(`#list-${list_id}`)
    infos.forEach((info, index) => {
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
        _input.setAttribute('onClick', `addMasterInfoList(this, '${station_id}', '${type}', '${ul_id}', '${input_id}', ${_new},'${_ismaster}','${type}')`)

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

function addMasterInfoList(e, station_id, type, ul_id, input_id, _new,ismaster,type) {
    const _input = document.querySelector(`#${input_id}`)
    
    let isturnon = `{{ $turnon }}`;
    if(e.checked) {
        let _stations = !_new ? {{ Js::from($stations) }} : stations
        const info_icon = 'fi fi-squared-info'
        const remove_icon = 'fi fi-round-close'
        const _ul = document.querySelector(`#master-${ul_id}`)
        let res = _stations.find((item) => { return item.id === station_id })
        let _info = res.info_line.find((item) => { return item.id === e.value })

        let rand = generateString(8)
        let li = document.createElement('li')
        li.setAttribute('class', 'list-group-item info-from-active-on')
        li.setAttribute('data-id', _info.id)
        li.id = rand
        
        if(isturnon =='Y'){
            li.innerHTML = `<span class="fw-bold">${_info.name}</span>
                        <i class="${info_icon} ms-2 text-primary cursor-pointer d-none" title="View" onClick="showStationInfo('${_info.id}', '${station_id}', '${type}')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', '${_info.id}', '${ul_id}', '${input_id}', '${type}')"></i>
                        <span class="info-content-text" id="box-${ismaster}-${type}">${_info.text}</span>`;
        }else{
            li.innerHTML = `<span class="fw-bold">${_info.name}</span>
                        <i class="${info_icon} ms-2 text-primary cursor-pointer d-none" title="View" onClick="showStationInfo('${_info.id}', '${station_id}', '${type}')"></i>
                        <i class="${remove_icon} ms-1 text-danger cursor-pointer" title="Remove" onClick="removeInfoFrom('${rand}', '${_info.id}', '${ul_id}', '${input_id}', '${type}')"></i>
                        <span class="info-content-text" id="box-${ismaster}-${type}" style="display:none;">${_info.text}</span>`;
        }
        
        
        _ul.appendChild(li)

        e.setAttribute('data-rand', rand)
        _input.value = _input.value === '' ? _info.id : `${_input.value},${_info.id}`
    }
    else {
        let get_rand = e.getAttribute('data-rand')
        removeInfoFrom(get_rand, e.value, ul_id, input_id, type)
    }
}

function removeInfoFrom(rand, info_id, ul_id, input_id, type) {
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

function setInfomationListData() {
    const stations = {{ Js::from($stations) }}
    const station_lines = {{ Js::from($data) }}
    const station_id = document.querySelector(`#{{ $select_id }}`).value
    const list_id = `{{ $list_id }}`
    const ul_id = `{{ $ul_id }}`
    const input_id = `{{ $input_id }}`
    const type = `{{ $type }}`
    const ismaster = `{{ $ismaster }}`
    const button_id = `{{ $button_id }}`
    const button_create = `{{ $btn_create }}`

    // console.log(document.querySelector(`#{{ $select_id }}`).value)

    const res = stations.find((item) => { return item.id === station_id })
    const infos = res.info_line.filter((item) => { return item.pivot.type === type })
    const info_selected = station_lines.filter((item) => { return item.pivot.type === type && item.pivot.ismaster === ismaster })
    clearInfomationList2(list_id)
    setInfomationListSelect(infos, type, station_id, list_id, ul_id, input_id, false,ismaster)
    setInfomationListSelected(info_selected, station_id, type, ul_id, input_id, list_id)
    document.querySelector(`#btn-${button_create}`).setAttribute('onClick', `setModalCreateId('${button_id}', '${station_id}', '${type}', '${list_id}', '${ul_id}', '${input_id}')`)
}

async function setInfomationOnChange(station_id, type, ismaster, list_id, ul_id, input_id) {
    let current_station_id = type === 'from' ? station_from_id : station_to_id
    if(current_station_id === station_id) {
        let response = await fetch(`/ajax/get-route-info/${route_id}/${station_id}/${type}`)
        let res = await response.json()

        if(res.data !== null) {
            let info_selected = res.data.station_lines.filter((item) => { return item.pivot.type === type && item.pivot.ismaster === ismaster })
            setInfomationListSelected(info_selected, station_id, type, ul_id, input_id, list_id)
        }
    }
}

function setInfomationListSelected(info_selected, station_id, type, ul_id, input_id, list_id) {
    const ul = document.querySelector(`#list-${list_id}`)
    const lis = ul.querySelectorAll('li input')

    lis.forEach((input) => {
        let input_checked = info_selected.find((info) => { return info.id === input.value })
        if(input_checked) input.click()
    })
}

function generateString(length) {
    const characters ='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    let result = '';
    const charactersLength = characters.length;
    for ( let i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() * charactersLength));
    }

    return result;
}

async function loadNewInfomation(station_id, type, list_id, ul_id, input_id) {
    await getInfoStation()
    let res = await stations.find((item) => { return item.id === station_id })
    let infos = await res.info_line.filter((item) => { return item.pivot.type === type })

    let is_type = type === 'from' ? from_list : to_list
    let unique_list = [
        ...new Map(is_type.map((item) => [item["input"], item])).values(),
    ];
    unique_list.forEach(async (item) => {
        await clearInfomationList2(item.list)
        await setInfomationListSelect(infos, type, station_id, item.list, item.ul, item.input, true)
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

function clearInfomationList2(list_id) {
    const ul = document.querySelector(`#list-${list_id}`)
    const lis = ul.querySelectorAll('li')
    lis.forEach((li) => {
        li.remove()
    })
}

function clearInfomationSelected2(ul_id) {
    const ul = document.querySelector(`#master-${ul_id}`)
    const lis = ul.querySelectorAll('li')
    lis.forEach((li) => { li.remove() })
}

function clearInfomationInput2(input_id) {
    const _input = document.querySelector(`#${input_id}`)
    _input.value = ''
}
</script>
