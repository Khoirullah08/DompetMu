// Toggle eye Password
function togglePass(inputId, offId, onId) {
    const input = document.getElementById(inputId)
    const off = document.getElementById(offId)
    const on = document.getElementById(onId)
    if (input.type === 'password') {
        input.type = 'text'
        off.style.display = 'none'
        on.style.display = 'block'
    } else {
        input.type = 'password'
        off.style.display = 'block'
        on.style.display = 'none'
    }
}