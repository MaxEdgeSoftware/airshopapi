const hamburger = document.getElementById('hamburger')
const sidebar = document.getElementById('sidebar')

hamburger.addEventListener('click', function(){
    sidebar.classList.toggle('inactive')
})
