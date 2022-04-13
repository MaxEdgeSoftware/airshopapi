function updatecommand (action, value){
    const viewdeletebtn = document.querySelector('.viewdeletebtn')
    var formdata = new FormData()
    formdata.append('action', action)
    
    if (action == 'image') {
        const filesize = (value[0].size/1024).toFixed(2)
        if(filesize > 5000){
            alert('Image size must be less than 5mb')
            return false
        }
        formdata.append('value', value[0])
    }else{
        formdata.append('value', value)
    }

    

    const xhr = new XMLHttpRequest()
    xhr.open('POST', `/product/update/${viewdeletebtn.id}`)
    xhr.addEventListener('readystatechange', function(){
        if(xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('thedescription').style.display = 'block'
            document.getElementById('viewproductdescrcont').style.display = 'none'
            document.getElementById('viewproductimagechange').style.display = 'none'
            document.getElementById('viewproductinitialimage').style.display = 'block'
            document.getElementById('viewproductpricechange').style.display = 'none'
            document.getElementById('viewproductinitialprice').style.display = 'block'
        
            viewproduct(viewdeletebtn.id)
        }
    })
    xhr.send(formdata)
    console.log(xhr)
}

function viewproduct(id){

    const imagecont = document.getElementById('viewimg')
    imagecont.innerHTML = ''
    $('#viewproductnewprice').val('')
    $('#viewproducttitle').html('')
    $('#view-product_description').html('')
    $('#viewproductprice').html('')
    $('#viewproductdescription').html('')
    $('#viewproductcategory').html('')

    fetch(`/product/get/${id}`, {
        method: 'POST',
        headers: new Headers({
            origin: 'same-origin'
        }),
    })
    .then((response)=>response.json())
    .then((response)=>{
        product = response
        setTimeout(() => {
        console.log(product)
            const imagecont = document.getElementById('viewimg')
            imagecont.innerHTML = ''
            const img = document.createElement('img')
            img.src = product.product.Image
            imagecont.append(img)
            $('#viewproducttitle').html(product.product.Name)
            $('#view-product_description').html(product.product.Description)
            $('#viewproductdescription').html(product.product.Description)
            $('#viewproductprice').html(product.product.Price)
            $('#viewproductcategory').html(product.product.Category)
            $('#viewproductnewprice').val(product.product.Price)
            
            const viewdeletebtn = document.querySelector('.viewdeletebtn')
            viewdeletebtn.id = product.product.Product_id

            $("#view-product-cont").show()
        }, 1000);
    
    })
    
}

function closeviewproductcont() {
    fetchmyproduct('')
    $('#view-product-cont').hide()
}
$('.viewdeletebtn').on('click', function(){
    const id = this.id
    deleteproduct(id)
})
function deleteproduct (id) {
    const check = confirm('Are you sure, to delete this product?')
    if (check) {
        
        fetch(`/product/delete/${id}`,{
            method: 'DELETE',
            headers : new Headers({
                origin: 'same-origin'
            }),
        })
        .then((response)=>{fetchmyproduct('')})
        
    }
    $("#view-product-cont").hide()
}
function fetchmyproduct (param){
    var data = {
        'param' : param
    }
    fetch ('/shop/myproducts/fetch', {
        method: 'POST',
        headers : new Headers({
            origin: 'same-origin'
        }),
        body: JSON.stringify(data),
    })
    .then((response)=>response.json())
    .then((response)=>{
        $('tbody').html("")
        if(response.status == false){
            $('tbody').html("No item with the name "+data.param)
            return
        }
        response.reverse()
        response.forEach(item => {
            const tr = document.createElement('tr')
            console.log(item)
            tr.addEventListener('click', function(){
                viewproduct(`${item.Product_id}`)
            })
            tr.classList.add('tr')
            tr.innerHTML = `<td> <center><img src="${item.Image}" height="50" alt=""></center></td>
            <td>${item.Name}</td>
            <td>${item.Category}</td>
            <td>N${item.Price}</td>`
            $('tbody').append(tr)
        });
    })
}
$('#closeaddproduct').on('click', function(){
    $('.addproduct-cont').fadeOut(100)
})


$('#showadditem').on('click', function(){
    $('.addproduct-cont').fadeIn(100)
})
$('#showadditem1').on('click', function(){
    $('.addproduct-cont').fadeIn(100)
})
 

$('#product-image').on('change', function(){
    $('.picuploaderr').text('')
    const file = $(this)[0].files[0]
    
    if (!file || file == null){
        return false
    }
    const filesize = (file.size/1024).toFixed(2)
    if(filesize > 5000){
        $('.picuploaderr').text('File size, cannot be more than 5mb')
        return false
    }
    $('.product-image-preview').html('')
    const img = document.createElement('img')
    img.style.width = '100%'
    img.style.maxHeight = '250px'
    img.style.objectFit = 'contain'
    const fr = new FileReader()
    fr.readAsDataURL(file)
    fr.onload = function() {
        img.src = fr.result
        $('.product-image-preview').html(img)
    }
    
})
$('#closeproductadded').on('click', function(){
    const thislink = window.location.href
    if (thislink == 'http://localhost:8000/store/items/#?additem' || thislink == 'http://localhost:8000/store/items/'){
        fetchmyproduct('')
    }
    $('#productadded').hide();
})
$('#form106').on('submit', function(e){
    e.preventDefault()
    $("#loader").show();
    $("#message").html('adding product..');
    
    $('#productadded').hide();
    $('.product-not-added').hide();

    const productname = $('#product-name').val();
    const productprice = $('#product-price').val();
    const productcategory = $('#product-category').val();
    const productimage = $('#product-image')[0].files[0];
    const productdescr = $('#product-descr').val()
    const activeshop = $('.activeshop').text()
    if (productname == '' || productprice == '' || productdescr == '' || productcategory == ''){
        alert('All fields are required')
        $("#loader").hide();
        return false
    }
    if (!productimage || productimage == null){
        $("#loader").hide();
        return false
    }
    const productimagesize = (productimage.size/1024).toFixed(2)
    if(productimagesize > 50000){
        $('.picuploaderr').text('File size, cannot be more than 5mb')
        $("#loader").hide();
        return false
    }

    setTimeout(() => {
        

        var formdata = new FormData()
        formdata.append('Name', productname)
        formdata.append('Description', productdescr)
        formdata.append('Category', productcategory)
        formdata.append('Price', parseFloat(productprice))
        formdata.append('Image', productimage)
        const xhr = new XMLHttpRequest()
        xhr.open('POST', `/product/${activeshop}/add/`)
        xhr.addEventListener('readystatechange', function(){
            if(xhr.readyState === 4 && xhr.status === 200) {
                const result = JSON.parse(xhr.response) 
                $("#loader").hide();
                if (result.status == 'true' || result.status == true){
                    $('#product-name').val("");
                    $('#product-price').val("");
                    $('#product-category').val("");
                    $('#product-image')[0].files = null;
                    $('#product-descr').val("")
                    $('.addproduct-cont').fadeOut(100)
                    $('#productadded').show()
                    $('.product-image-preview').html(`<div class="lead">Product Image Preview</div>`)
                }else{
                    $('#erroruploadproduct').css({zIndex:10000})
                    $('#erroruploadproduct').show()
                    $('.error').text('An error occur, please refresh the page')
                }
            }
        })
        xhr.send(formdata)
        // product-name, product-price, product-image, product-descr
    }, 2000);
})

