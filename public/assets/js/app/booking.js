const customers = document.querySelectorAll('.customer-btn-edit')
let lead = false
let _customer = null
customers.forEach((item) => {
    item.addEventListener('click', (e) => {
        lead = false
        let customer = _customer = e.target.dataset
        let sub_passenger = document.querySelector('#sub-passenger')
        sub_passenger.classList.add('d-none')

        document.querySelector('#customer-id').value = customer.customer_id
        document.querySelector('#passenger-full-name').value = customer.fullname
        let title = document.querySelector('#passenger-title')
        let _options = title.querySelectorAll('option')
        _options.forEach((opt) => { if(opt.value == customer.title.toLowerCase()) opt.selected = true })
        let b_day = customer.bday.split('-')

        $('.passenger-b-day').datepicker()
        $('.passenger-b-day').datepicker('setEndDate', new Date())
        $('.passenger-b-day').datepicker('setDate', `${b_day[2]}/${b_day[1]}/${b_day[0]}`)

        if(customer.email !== '') {
            lead = true
            sub_passenger.classList.remove('d-none')
            document.querySelector('#passenger-email').value = customer.email
            document.querySelector('#passenger-mobile').value = customer.mobile
            document.querySelector('#passenger-mobile-th').value = customer.mobile_th
            document.querySelector('#passenger-address').innerText = customer.address
            document.querySelector('#passenger-passport').value = customer.passport
            if(customer.code_mobile !== '') document.querySelector(`#code-${customer.code_mobile}`).selected = true
            let country = document.querySelector('#passenger-country')
            let options = country.querySelectorAll('option')
            options.forEach((opt) => { if(opt.value == customer.country) opt.selected = true })
        }
    })
})

const customer_update = document.querySelector('#booking-customer-update')
if(customer_update) {
    customer_update.addEventListener('click', () => {
        const field_customer = document.querySelector('#booking-customer-field')
        const form_customer = document.querySelector('#booking-customer-form')
        let email = true
        let mobile = true
        if(lead) {
            email = checkInputRequired('#passenger-email')
            mobile = checkInputRequired('#passenger-mobile')
        }

        let name = checkInputRequired('#passenger-full-name')
        let bday = checkInputRequired('.passenger-b-day')

        if(email && mobile && name && bday) {
            form_customer.submit()
            field_customer.disabled = true
            customer_update.disabled = true
        }
    })
}

function checkInputRequired(element_id) {
    let element = document.querySelector(element_id)
    if(element.value === '') element.classList.add('border-danger')
    else element.classList.remove('border-danger')

    return element.value === '' ? false : true
}
