@props(['header' => '', 'select_id' => '', 'type' => ''])

@php
    $modal_id = uniqid();
    $list_id = uniqid();
    $button_id = uniqid();
    $ul_id = uniqid();
@endphp

<button type="button" class="btn btn-outline-dark btn-sm w-100" id="btn-{{ $button_id }}" data-bs-toggle="modal" data-bs-target="#modal-{{ $modal_id }}" disabled>Select/Add Information</button>
<ul class="list-group" id="master-{{ $ul_id }}"></ul>

<div class="modal fade" id="modal-{{ $modal_id }}" style="z-index: 1059;" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel3" aria-hidden="true">
	<div class="modal-dialog modal-dialog-scrollable modal-lg">
		<div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title w-75">{{ $header }}
                    <button type="button" class="btn btn-sm button-orange-bg w-25 ms-3" data-bs-toggle="modal" data-bs-target="#create-infomation">Add</button>
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


<script>
if(document.querySelector(`#{{ $select_id }}`)) {
    document.querySelector(`#{{ $select_id }}`).addEventListener('change', (e) => {
        const list_id = `{{ $list_id }}`
        const button_id = `{{ $button_id }}`
        const type = `{{ $type }}`

        document.querySelector(`#btn-${button_id}`).disabled = false
        let res = stations.find((item) => { return item.id === e.target.value })
        let infos = res.info_line.filter((item) => { return item.pivot.type === type })
        clearInfomationList(list_id)
        if(infos.length > 0) {
            setInfomationListSelect(infos, type, e.target.value, list_id)
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

function setInfomationListSelect(infos, type, station_id, list_id) {
    let li_name = type === 'from' ? 'master_from[]' : 'master_to[]'
    let ul = document.querySelector(`#list-${list_id}`)
    infos.forEach((info, index) => {
        let _li = document.createElement('li')
        let _input = document.createElement('input')
        let _label = document.createElement('label')
        let _icon = document.createElement('i')

        _li.setAttribute('class', 'list-group-item border-0 border-bottom rounded-0')

        _input.setAttribute('name', li_name)
        _input.setAttribute('type', 'checkbox')
        _input.setAttribute('class', 'form-check-input me-1')
        _input.value = info.id
        _input.id = `input-${type}-${index}`
        _input.setAttribute('onClick', `addMasterInfoFrom(this, ${index}, '${station_id}')`)

        _label.classList.add('ms-2')
        _label.setAttribute('for', `input-${type}-${index}`)
        _label.innerHTML = info.name

        _icon.setAttribute('class', 'fi fi-squared-info ms-2 text-primary cursor-pointer')
        _icon.setAttribute('onClick', `showStationInfo('${info.id}', '${station_id}', '${type}')`)

        _li.appendChild(_input)
        _li.appendChild(_label)
        _li.appendChild(_icon)
        ul.appendChild(_li)
    })
}

function clearInfomationList(list_id) {
    const ul = document.querySelector(`#list-${list_id}`)
    const lis = ul.querySelectorAll('li')
    lis.forEach((li) => { li.remove() })
}
</script>