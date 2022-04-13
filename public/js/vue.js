    var app = new Vue({
        el: '#app',
        delimiters: ['[[', ']]'],
        data() {
            return {
                shopDetail: {},
                cart:[{},{}],
                cartTotal : 0,
                hideStore : false,
                hideCart : false,
                hideHome : true,
                hideAbout : false,
                isCart : false,
                products : [],
                isNotCart : true,
                cartfiled : false
            }
        },
        methods: {
            loadshop: function(){
                this.message = '{{store}}'
            },
            addtocart : function(id){
                let userid = ''
                userid = localStorage.getItem('uid')
                if (userid == null){
                    userid = Math.floor(Math.random(11111111111)*99999999999)
                }
                var data = {
                    'product' : id,
                    'user' : userid,
                    'shop' : '{{store}}'
                }
                fetch (`{% url "addtocart" %}`,
                    {method: 'POST',
                        headers:{
                            'Content-Type' : 'application/json',
                            'X-CSRFTOKEN': '{{ csrf_token }}'
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify(data)
                    }
                )
                .then((response)=>json(response))
                .then((response)=>{
                    if (response.status == true || response.status == 'true'){
                        localStorage.setItem('uid') = userid
                        
                    }
                })

            },
            showhomepage : function(){
                this.hideHome = true
                this.hideStore = false
                this.hideAbout = false
                this.hideCart = false
            },
            showstorepage : function(){
                this.fetchproducts()
                this.hideHome = false
                this.hideAbout = false
                this.hideCart = false
                this.hideStore = true

            },
            showaboutpage : function(){
                this.hideHome = false
                this.hideAbout = true
                this.hideCart = false
                this.hideStore = false
            },
            showcartpage : function(){
                const userid = localStorage.getItem('uid')
                if (userid == null) {
                    this.isNotCart = true
                    this.isCart = false
                }

                this.hideHome = false
                this.hideStore = false
                this.hideAbout = false
                this.hideCart = true
            },


            fetchproducts : function(){
                fetch('{% url "shopproducts" store %}', {
                        method: 'POST',
                        headers:{
                            'Content-Type' : 'application/json',
                            'X-CSRFTOKEN': '{{ csrf_token }}'
                        },
                        credentials: 'same-origin',
                    })
                    .then((response) => response.json())
                    .then((response)=>{
                        console.log(response);
                        this.products = response
                    })
                    .catch((error)=>{
                        console.log(error)
                    })
            },
            fetchShop : function(){
                fetch('{% url "fetchshop" store %}', {
                        method: 'POST',
                        headers:{
                            'Content-Type' : 'application/json',
                            'X-CSRFTOKEN': '{{ csrf_token }}'
                        },
                        credentials: 'same-origin',
                    })
                    .then((response) => response.json())
                    .then((response)=>{
                        console.log(response);
                        if (response.status == false || response.status == 'false'){
                            
                            $(".page_wrapper").html(`<div class="alert alert-info">Invalid Shop</div> <br /> <center> <a href="{% url 'homepage' %}" class="btn btn-info">Home</a> </center`)
                            return false;
                        }
                        this.shopDetail = response
                    })
                    .catch((error)=>{
                        console.log(error)
                    })
            }
        },
        created(){
            this.loadshop()
            this.fetchShop()
        }

    });