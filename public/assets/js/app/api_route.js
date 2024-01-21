const regulars = document.querySelectorAll('.input-regular')
const discounts = document.querySelectorAll('.input-discount')
const isactives = document.querySelectorAll('.input-isactive')
regulars.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let price = e.target.value
        let index = e.target.dataset.index
        let discount = document.querySelector(`#discount-${index}`)
        let amount = document.querySelector(`#amount-${index}`)

        document.querySelector(`#price-updating-${index}`).classList.remove('d-none')
        document.querySelector(`#price-updated-${index}`).classList.add('d-none')
        if(price === '') price = 0

        amount.value = parseInt(price) - parseInt(discount.value)
    })
    beforeUpdate(item, 'price')
})

discounts.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let discount = e.target.value
        let index = e.target.dataset.index
        let price = document.querySelector(`#regular-${index}`)
        let amount = document.querySelector(`#amount-${index}`)

        document.querySelector(`#discount-updating-${index}`).classList.remove('d-none')
        document.querySelector(`#discount-updated-${index}`).classList.add('d-none')
        if(discount === '') discount = 0

        amount.value = parseInt(price.value) - parseInt(discount)
    })
    beforeUpdate(item, 'discount')
})

isactives.forEach((item) => {
    item.addEventListener('change', async (e) => {
        let response = await fetch(`/ajax/api-route/status/${e.target.value}`)
        let res = await response.json()
        if(res['result']) $.SOW.core.toast.show('success', '', `Status updated.`, 'top-right', 0, true);
        else $.SOW.core.toast.show('danger', '', `Something wrong.`, 'top-right', 0, true);
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
    let amount = document.querySelector(`#amount-${index}`)

    let data = new FormData()
    data.append('id', id.value)
    data.append('regular', regular.value)
    data.append('discount', discount.value)
    data.append('amount', amount.value)

    let response = await fetch('/ajax/api-route/update', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: data
                    })
    let res = await response.json()
    if(res['result']) {
        document.querySelector(`#${type}-updating-${index}`).classList.add('d-none')
        document.querySelector(`#${type}-updated-${index}`).classList.remove('d-none')
    }
    else {
        document.querySelector(`#${type}-updating-${index}`).classList.add('d-none')
        document.querySelector(`#${type}-fail-${index}`).classList.remove('d-none')
    }
}
