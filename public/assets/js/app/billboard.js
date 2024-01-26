const backgroud_select = document.querySelector('#background-color-select')
const character = document.querySelector('.character-count')

let max_character = 1200
if(backgroud_select) {
    updateCharactorlength(max_character)
    backgroud_select.addEventListener('input', (e) => {
        const background_editor = document.querySelector('.ql-editor')
        background_editor.style.background = e.target.value
    })
}

const isactives = document.querySelectorAll('.billboard-isactive')
if(isactives) {
    isactives.forEach((item) => {
        item.addEventListener('change', async (e) => {
            let response = await fetch(`/ajax/media/billboard/status/${e.target.value}`)
            let res = await response.json()

            if(res['result']) $.SOW.core.toast.show('success', '', `${res['msg']}`, 'top-right', 0, true);
            else $.SOW.core.toast.show('danger', '', `${res['msg']}.`, 'top-right', 0, true);
        })
    })
}

function updateCharactorlength(character_length) {
    character.innerHTML = character_length
}

let main_content = ''
function counterWord(e) {
    const ql_editor = document.querySelector('.ql-editor')
    let character_less = max_character - e.innerText.length

    if(character_less >= 0) {
        main_content = ql_editor.innerHTML
        updateCharactorlength(character_less)
    }
    else {
        let max_charactor = main_content.substring(0, max_character)
        ql_editor.innerHTML = max_charactor
    }
}

const ql_edit = document.querySelector('.editor-edit')
if(ql_edit) {
    let character_less = max_character - ql_edit.innerText.length
    updateCharactorlength(character_less)
}
