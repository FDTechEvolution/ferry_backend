let from_selected = null
let to_selected = null

const station_from = document.querySelector('#station-from')
if(station_from) {
    station_from.addEventListener('change', (e) => {
        from_selected = e.target.value
        getRouteDepartTime()
    })
}

const station_to = document.querySelector('#station-to')
if(station_to) {
    station_to.addEventListener('change', (e) => {
        to_selected = e.target.value
        getRouteDepartTime()
    })
}

async function getRouteDepartTime() {
    if(from_selected && to_selected) {
        let response = await fetch(`/ajax/report/depart-arrive-time/${from_selected}/${to_selected}`)
        let res = await response.json()

        const depart_select = document.querySelector('#depart_time')
        while(depart_select.options.length > 0) {
            depart_select.remove(0)
        }

        let _option = document.createElement('option')
        _option.value = 'all'
        _option.innerText = '- ALL -'
        depart_select.add(_option)

        res.data.forEach((time, index) => {
            let _option = document.createElement('option')
            _option.value = `${time.depart_time}-${time.arrive_time}`
            _option.innerText = `Depart : ${time.depart_time} / Arrive : ${time.arrive_time}`
            depart_select.add(_option)
        })
    }
}
