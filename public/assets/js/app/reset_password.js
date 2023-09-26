const _password = document.querySelector('#password')
const _confirm = document.querySelector('#confirm-password')
const password = document.querySelector('#show-password')
const confirm = document.querySelector('#show-confirm-password')

function formSubmit() {
    let notice = document.querySelector('#reset-password-error-notice')
    if(_password.value === _confirm.value) {
        if(_password.value.length >= 6) return true
        else {
            $.SOW.core.toast.show('danger', '', 'Password must be at least 6 characters.', 'top-end', 0, true)
            notice.innerHTML = 'Password must be at least 6 characters.'
            return false
        }
    }
    else {
        $.SOW.core.toast.show('danger', '', 'Passwords not match.', 'top-end', 0, true)
        notice.innerHTML = 'Passwords not match.'
        return false
    }
}

password.addEventListener('click', () => {
    setInputType('password', 'show-password')
})

confirm.addEventListener('click', () => {
    setInputType('confirm-password', 'show-confirm-password')
})

function setInputType(element, toggle) {
    let _input = document.querySelector(`#${element}`)
    if (_input.type === "password") {
        _input.type = "text";
        setEyeIcon(toggle, 'fi-eye-disabled', 'fi-eye')
    } else {
        _input.type = "password";
        setEyeIcon(toggle, 'fi-eye', 'fi-eye-disabled')
    }
}

function setEyeIcon(element, add, remove) {
    document.querySelector(`#${element}`).classList.add(add)
    document.querySelector(`#${element}`).classList.remove(remove)
}