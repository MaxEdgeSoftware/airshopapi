$('#form107').on('submit', function(e){
    $('.change-password-report').hide()
    $('#message').html('Changing password.... please wait.')
    $('.change-password-report-true').hide()
    $('#loader').show()
    const oldpassword = $('#changepassword_old').val()
    const newpassword1 = $('#changepassword_new1').val()
    const newpassword2 = $('#changepassword_new2').val()
    var data = {
        'oldpassword' : oldpassword,
        'newpassword1' : newpassword1,
        'newpassword2' : newpassword2,
    }
    console.log(oldpassword)
    setTimeout(() => {
        fetch('/shop/password-reset', {
            method: 'POST',
            headers : new Headers({
                origin: 'same',
            }),
            body: JSON.stringify(data)
        })
        .then((response)=>response.json())
        .then((response)=>{
            console.log(response)
            if (response.status == false || response.status == 'false'){
                $('.change-password-report').show()
                $('.change-password-report').html(response.message)

                $('#loader').hide()

                return false;
            }
            $('.change-password-report-true').html('Password successfully changed')
            $('.change-password-report-true').show()


            $('#loader').hide()
        })
    }, 1000);
    e.preventDefault()
}) 