const regulars = document.querySelectorAll('.input-regular')
const discounts = document.querySelectorAll('.input-discount')
regulars.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let price = e.target.value
        let index = e.target.dataset.index
        let discount = document.querySelector(`#discount-${index}`)
        let amount = document.querySelector(`#amount-${index}`)

        amount.value = parseInt(price) - parseInt(discount.value)
    })
    beforeUpdate(item)
})

discounts.forEach((item) => {
    item.addEventListener('keyup', (e) => {
        let discount = e.target.value
        let index = e.target.dataset.index
        let price = document.querySelector(`#regular-${index}`)
        let amount = document.querySelector(`#amount-${index}`)

        amount.value = parseInt(price.value) - parseInt(discount)
    })
    beforeUpdate(item)
})

function beforeUpdate(item) {
    item.addEventListener('keyup', delay((e) => {
        let index = e.target.dataset.index
        updateData(index)
    }, 2000))
}

function delay(fn, ms) {
    let timer = 0
    return function(...args) {
        clearTimeout(timer)
        timer = setTimeout(fn.bind(this, ...args), ms || 0)
    }
}

async function updateData(index) {
    let regular = document.querySelector(`#regular-${index}`)
    let discount = document.querySelector(`#discount-${index}`)
    let amount = document.querySelector(`#amount-${index}`)

    console.log(regular.value, discount.value, amount.value)
}
