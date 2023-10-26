function getValueStandard(e, index) {
    const _value = e.value
    const _col = document.querySelector(`.col-standard-${index}`)
    const _input = _col.querySelectorAll('input')

    _input.forEach((input) => { input.value = 0 })
    e.value = _value
}

function getValueOnline(e, index) {
    const _value = e.value
    const _col = document.querySelector(`.col-online-${index}`)
    const _input = _col.querySelectorAll('input')

    _input.forEach((input) => { input.value = 0 })
    e.value = _value
}