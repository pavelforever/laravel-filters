@if($products->isNotEmpty())

    @foreach($products as $product)
        <div class="wrapper">
            <div class="product-img">
              <img src="{{asset('storage/'.$product->image)}}" height="420" width="327">
            </div>
            <div class="product-info">
              <div class="product-text">
                <h1>{{$product->name}}</h1>
                <h2>
                    @foreach ($product->categories as $i => $cat )
                    {{ $i > 0  ? ' / ' : ''}}{{ $cat->title }}
                    @endforeach   
                </h2>
                <p>{{$product->description}}</p>
              </div>
              <div class="product-price-btn" style="display:flex">
                <button  type="button" class="gnr_btn" data-product="{{ $product->id }}">
                    <p>Generate link<p>
                    <div id="lottie-container-{{$product->id}}"></div>    
                </button>
                <button id="dwn_link_{{$product->id}}" style="display:none"><a href="" target="_blank" class="dwn_link" data-product="{{ $product->id }}">Download</a></button>
                
              </div>
            </div>
        </div>
        
    @endforeach

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.5/lottie.min.js"></script>

    <script>
        $(document).ready(function () {
        $('#lottie-container-{{$product->id}}').hide();
        let animation = lottie.loadAnimation({
            container: document.getElementById('lottie-container-{{$product->id}}'),
            renderer: 'svg',
            height: '40px',
            loop: false,
            autoplay: false,
            path: '{{ asset("Sucess_animation.json") }}',
            rendererSettings: {
                preserveAspectRatio: "xMidYMid slice",
                id: "lottie-svg-{{$product->id}}"
            }
        });

        $('.gnr_btn[data-product="{{$product->id}}"]').click(function() { 
            
            animation.goToAndPlay(0);
            $('#lottie-container-{{$product->id}}').show();
            $('.gnr_btn[data-product="{{$product->id}}"]').find('p').animate({
                'width': 'hide'
            })

            setTimeout(() => {
                $(this).hide()
                $('#dwn_link_'+{{$product->id}}).show();
            }, 2000);
            $.ajax({
                type: 'GET',
                url: '{{ route("product.generate", ["user" => $user->id, "product" => $product->id]) }}',
                success: function (response) {
                    var downloadLink = response.download_link;
                    $('.dwn_link[data-product="{{$product->id}}"]').attr('href', downloadLink).show();
                },
                error: function () {
                    console.error('Failed to generate download link.');
                }
            });
        });

        $('#dwn_link_'+{{$product->id}}).click(function() {
            
            $(this).hide();
            $('#lottie-container-{{$product->id}}').hide();
            $('.gnr_btn[data-product="{{$product->id}}"]').show()
            $('.gnr_btn[data-product="{{$product->id}}').find('p').animate({width: 'show'});
        });

    });  
    </script>
    <style>
        #lottie-svg-{{$product->id}} {
            height: 40px !important;
            width: 40px !important;
        }
        body {
        background-color: #fdf1ec;
        }

        .wrapper {
        height: 420px;
        width: 654px;
        margin: 50px auto;
        border-radius: 7px 7px 7px 7px;
        /* VIA CSS MATIC https://goo.gl/cIbnS */
        -webkit-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
        -moz-box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
        box-shadow: 0px 14px 32px 0px rgba(0, 0, 0, 0.15);
        }

        .product-img {
        float: left;
        height: 420px;
        width: 327px;
        }

        .product-img img {
        border-radius: 7px 0 0 7px;
        }

        .product-info {
        float: left;
        height: 420px;
        width: 327px;
        border-radius: 0 7px 10px 7px;
        background-color: #ffffff;
        }

        .product-text {
        height: 300px;
        width: 327px;
        }

        .product-text h1 {
        margin: 0 0 0 38px;
        padding-top: 52px;
        font-size: 34px;
        color: #474747;
        }

        .product-text h1,
        .product-price-btn p {
        font-family: 'Bentham', serif;
        }

        .product-text h2 {
        margin: 0 0 47px 38px;
        font-size: 13px;
        font-family: 'Raleway', sans-serif;
        font-weight: 400;
        text-transform: uppercase;
        color: #d2d2d2;
        letter-spacing: 0.2em;
        }

        .product-text p {
        height: 125px;
        margin: 0 0 0 38px;
        font-family: 'Playfair Display', serif;
        color: #8d8d8d;
        line-height: 1.7em;
        font-size: 15px;
        font-weight: lighter;
        overflow: hidden;
        }

        .product-price-btn {
        height: 103px;
        width: 327px;
        margin-top: 17px;
        position: relative;
        }


        .wrapper span{
        display: inline-block;
        height: 50px;
        font-family: 'Suranna', serif;
        font-size: 34px;
        }

        .product-price-btn button{
        float: right;
        display: inline-block;
        height: 50px;
        width: 176px;
        margin: 0 40px 0 16px;
        box-sizing: border-box;
        border: transparent;
        border-radius: 60px;
        font-family: 'Raleway', sans-serif;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.2em;
        color: #ffffff;
        background-color: #9cebd5;
        cursor: pointer;
        outline: none;
        }
        .product-price-btn button:hover {
        background-color: #79b0a1;
        }

        .product-price-btn button a{
            text-decoration: none;
            color: #ffff;
        }
    </style>
@else
    <h3>You don't have products yet</h3>
@endif
