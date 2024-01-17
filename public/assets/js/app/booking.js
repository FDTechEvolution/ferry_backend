const customers = document.querySelectorAll('.customer-btn-edit')
customers.forEach((item) => {
    item.addEventListener('click', (e) => {
        let customer = e.target.dataset
        document.querySelector('#passenger-full-name').value = customer.fullname

        if(customer.email !== '') {
            document.querySelector('#passenger-email').value = customer.email
            document.querySelector('#passenger-mobile').value = customer.mobile
            document.querySelector('#passenger-mobile-th').value = customer.mobile_th
            document.querySelector('#passenger-address').innerText = customer.address
        }
    })
})
