const regulars = document.querySelectorAll('.input-regular')
const discounts = document.querySelectorAll('.input-discount')
const isactives = document.querySelectorAll('.input-isactive')
regulars.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let price = e.target.value
        let index = e.target.dataset.index
        let discount = document.querySelector(`#discount-${index}`)
        let net_price = parseInt(price) - parseInt(discount.value)
        let commission = calCommission(net_price, index)
        let vat = calVat(commission, index)
        let amount = document.querySelector(`#amount-${index}`)

        document.querySelector(`#price-updating-${index}`).classList.remove('d-none')
        document.querySelector(`#price-updated-${index}`).classList.add('d-none')
        if(price === '') price = 0

        amount.innerHTML = net_price + parseFloat(commission) + parseFloat(vat)
    })
    beforeUpdate(item, 'price')
})

discounts.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let discount = e.target.value
        let index = e.target.dataset.index
        let price = document.querySelector(`#regular-${index}`)
        let amount = document.querySelector(`#amount-${index}`)
        let net_price = parseInt(price.value) - parseInt(discount)
        // let commission = calCommission(net_price, index)
        // let vat = calVat(commission, index)

        document.querySelector(`#discount-updating-${index}`).classList.remove('d-none')
        document.querySelector(`#discount-updated-${index}`).classList.add('d-none')
        if(discount === '') discount = 0

        // amount.innerHTML = net_price + parseFloat(commission) + parseFloat(vat)
        amount.innerHTML = net_price
    })
    beforeUpdate(item, 'discount')
})

function calCommission(price, index) {
    const is_commission = document.querySelector('.is-commission')
    const commission = document.querySelector(`#commission-${index}`)
    const _price = parseInt(price)

    const _commission = ((_price * (100 + parseInt(is_commission.innerText))) / 100) - _price
    const _commis = _commission > 50 ? _commission : 50
    commission.innerHTML = _commis.toFixed(2)
    return _commis.toFixed(2)
}

function calVat(commission, index) {
    const is_vat = document.querySelector('.is-vat')
    const vat = document.querySelector(`#vat-${index}`)

    const _vat = ((commission * (100 + parseInt(is_vat.innerText))) / 100) - commission
    vat.innerHTML = _vat.toFixed(2)
    return _vat.toFixed(2)
}

isactives.forEach((item) => {
    item.addEventListener('change', async (e) => {
        let response = await fetch(`/ajax/api-route/status/${e.target.value}`)
        let res = await response.json()
        if(res['result']) {
            updateRouteData(res['data'])
            $.SOW.core.toast.show('success', '', `Status updated.`, 'top-right', 0, true)
        }
        else $.SOW.core.toast.show('danger', '', `Something wrong.`, 'top-right', 0, true)
    })
})

function beforeUpdate(item, type) {
    item.addEventListener('keyup', delay((e) => {
        let index = e.target.dataset.index
        updateData(index, type)
    }, 2000))
}

function delay(fn, ms) {
    let timer = 0
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

async function updateData(index, type) {
    let id = document.querySelector(`#number-${index}`)
    let regular = document.querySelector(`#regular-${index}`)
    let discount = document.querySelector(`#discount-${index}`)

    let data = new FormData()
    data.append('id', id.value)
    data.append('regular', regular.value)
    data.append('discount', discount.value)

    let response = await fetch('/ajax/api-route/update', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: data
                    })
    let res = await response.json()
    if(res['result']) {
        updateRouteData(res['data'])
        document.querySelector(`#${type}-updating-${index}`).classList.add('d-none')
        document.querySelector(`#${type}-updated-${index}`).classList.remove('d-none')
    }
    else {
        document.querySelector(`#${type}-updating-${index}`).classList.add('d-none')
        document.querySelector(`#${type}-fail-${index}`).classList.remove('d-none')
    }
}

function updateRouteData(route) {
    let _route = routes.findIndex(item => { return item.id === route.id })
    routes[_route] = {...route}
}

const filter_from = document.querySelector('#filter-station-from')
const filter_to = document.querySelector('#filter-station-to')
let keyup_from = ''
let keyup_to = ''
let _routes = []

if(filter_from) {
    filter_from.addEventListener('keyup', (e) => {
        keyup_from = e.target.value
        $('#route-datatable').dataTable().fnClearTable()
        _routes = []

        searchRouteStation()
        updateDatatableData()
    })
}

if(filter_to) {
    filter_to.addEventListener('keyup', (e) => {
        keyup_to = e.target.value
        $('#route-datatable').dataTable().fnClearTable()
        _routes = []

        searchRouteStation()
        updateDatatableData()
    })
}

function setStation(station) {
    const nickname = station.nickname != '' ? `[${station.nickname}]` : ''
    const name = station.name
    const piername = station.piername != '' ? `(${station.piername})` : ''
    return `${nickname} ${name} <small>${piername}</small>`
}

function setDepartArrive(route) {
    const depart = route.depart_time.split(':')
    const arrive = route.arrive_time.split(':')

    return `Depart : ${depart[0]}:${depart[1]} <span class="mx-2">|</span> Arrive: ${arrive[0]}:${arrive[1]}`
}

function searchRouteStation(e) {
    let is_routes = routes.filter((item, key) => {
        return item.route.station_from.name.toLowerCase().includes(keyup_from.toLowerCase()) &&
                item.route.station_to.name.toLowerCase().includes(keyup_to.toLowerCase())
    })
    is_routes.forEach((item, index) => {
        let obj = {
            isroute: `<p class="mb-0">${setStation(item.route.station_from)} <span class="fw-bold">--></span> ${setStation(item.route.station_to)}</p>
                        <p class="mb-0 small">${setDepartArrive(item.route)}</p>`,
            price: [parseInt(item.regular_price), index],
            discount: [parseInt(item.discount), index],
            commission: [item.commission, index],
            vat: [item.vat, index],
            amount: [item.totalamt, index],
            isactive: [item.id, item.isactive, index]
        }
        _routes.push(obj)
    })
}

function updateDatatableData() {
    $('#api-route-datatable').dataTable({
        columnDefs: [{
            'defaultContent': '-',
            'targets': '_all',
        }],
        columns: [
            {
                data: 'isroute',
                render: (data) => {
                    return data
                }
            },
            {
                data: 'price',
                className: "position-relative d-none",
                render: (data, index) => {
                    return `<input type="number" class="form-control form-control-sm input-regular text-center" id="regular-${data[1]}"
                                    data-index="${data[1]}" value="${data[0]}" onKeyup="updateInputPrice(this, '${data[1]}')">
                            <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="price-updating-${data[1]}"></i>
                            <i class="fi mdi-check check-updated d-none" id="price-updated-${data[1]}"></i>
                            <i class="fi mdi-close fail-updated text-danger d-none" id="price-fail-${data[1]}"></i>`
                }
            },
            {
                data: 'discount',
                className: "position-relative",
                render: (data) => {
                    return `<input type="number" class="form-control form-control-sm input-discount text-center" id="discount-${data[1]}"
                                data-index="${data[1]}" value="${data[0]}" onKeyup="updateInputDiscount(this, '${data[1]}')">
                            <i class="fi fi-loading-dots fi-spin spin-updating d-none" id="discount-updating-${data[1]}"></i>
                            <i class="fi mdi-check check-updated d-none" id="discount-updated-${data[1]}"></i>
                            <i class="fi mdi-close fail-updated text-danger d-none" id="discount-fail-${data[1]}"></i>`
                }
            },
            {
                data: 'commission',
                className: "text-center d-none",
                render: (data) => {
                    return `<p class="mt-2" id="commission-${data[1]}">${parseFloat(data[0]).toFixed(2)}</p>`
                }
            },
            {
                data: 'vat',
                className: "text-center d-none",
                render: (data) => {
                    return `<p class="mt-2" id="vat-${data[1]}">${parseFloat(data[0]).toFixed(2)}</p>`
                }
            },
            {
                data: 'amount',
                className: "text-center",
                render: (data) => {
                    return `<p class="mt-2 fw-bold" id="amount-${data[1]}" data-index="${data[1]}">${data[0]}</p>`
                }
            },
            {
                data: 'isactive',
                className: "text-center",
                render: (data) => {
                    return `<label class="d-flex justify-content-center align-items-center mt-2">
                                <input class="d-none-cloaked section-isactive input-isactive" id="number-${data[2]}"
                                        type="checkbox" name="isactive" value="${data[0]}" ${data['1'] === 'Y' ? 'checked' : ''}
                                        onChange="updateActive(this)"/>
                                <i class="switch-icon switch-icon-success switch-icon-sm"></i>
                            </label>`
                }
            }
        ],
        data: _routes,
        destroy: true,
        searching: false,
        ordering: false,
        language : {
            sLengthMenu: "_MENU_",
            paginate: {
                previous: "<",
                next: ">"
            }
        },
        pageLength: 15,
        lengthMenu: [
            [10, 15, 30, 50, 100, -1],
            [10, 15, 30, 50, 100, 'All']
        ]
    })
}

let price_timeout = null
function updateInputPrice(e, index) {
    clearTimeout(price_timeout)
    let price = e.value
    let discount = document.querySelector(`#discount-${index}`)
    let net_price = parseInt(price) - parseInt(discount.value)
    let commission = calCommission(net_price, index)
    let vat = calVat(commission, index)
    let amount = document.querySelector(`#amount-${index}`)

    document.querySelector(`#price-updating-${index}`).classList.remove('d-none')
    document.querySelector(`#price-updated-${index}`).classList.add('d-none')
    if(price === '') price = 0

    amount.innerHTML = net_price + parseFloat(commission) + parseFloat(vat)

    price_timeout = setTimeout(function () {
        updateData(index, 'price')
    }, 2000)
}

let discount_timeout = null
function updateInputDiscount(e, index) {
    clearTimeout(discount_timeout)
    let discount = e.value
    let price = document.querySelector(`#regular-${index}`)
    let amount = document.querySelector(`#amount-${index}`)
    let net_price = parseInt(price.value) - parseInt(discount)
    let commission = calCommission(net_price, index)
    let vat = calVat(commission, index)

    document.querySelector(`#discount-updating-${index}`).classList.remove('d-none')
    document.querySelector(`#discount-updated-${index}`).classList.add('d-none')
    if(discount === '') discount = 0

    amount.innerHTML = net_price + parseFloat(commission) + parseFloat(vat)

    discount_timeout = setTimeout(function () {
        updateData(index, 'discount')
    }, 2000)
}

async function updateActive(e) {
    let response = await fetch(`/ajax/api-route/status/${e.value}`)
    let res = await response.json()
    if(res['result']) $.SOW.core.toast.show('success', '', `Status updated.`, 'top-right', 0, true);
    else $.SOW.core.toast.show('danger', '', `Something wrong.`, 'top-right', 0, true);
}
