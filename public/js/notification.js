function readthis(hash){

    // var data  = {
    //     'hash' : hash
    // }
    fetch(`/shop/notification/get/${hash}`, {
        method : 'POST',
        headers : new Headers({
            origin: 'same-origin'
        }),
    })
    .then((response)=>{
        const result = JSON.parse(response)
        const notification = result.notification
        
    })
    
}