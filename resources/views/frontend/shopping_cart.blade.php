@extends('frontend.layout')

@section('shopping-cart')
<section class="shoping-cart spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__table">
                    <table id="shopping-cart">
                        <thead>
                            <tr>
                                <th class="shoping__product">Products</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach ($cart as $idCart => $item)
                                <tr>
                                    <td class="shoping__cart__item">
                                        <img src="{{ asset('images').'/'.$item['image'] }}" alt="">
                                        <h5>{{ $item['name'] }}</h5>
                                    </td>
                                    <td class="shoping__cart__price">
                                        ${{ $item['price'] }}
                                    </td>
                                    <td class="shoping__cart__quantity">
                                        <div class="quantity">
                                            <div class="pro-qty">
                                                <input data-id="{{ $idCart }}" type="text" value="{{ $item['qty'] }}">
                                            </div>
                                        </div>
                                    </td>
                                    <td class="shoping__cart__total">
                                        @php 
                                            $totalRow = $item['price'] * $item['qty']; 
                                            $total += $totalRow;
                                        @endphp
                                        ${{ number_format($totalRow, 2) }}
                                    </td>
                                    <td class="shoping__cart__item__close">
                                        <a onclick="return confirm('Are you sure ?')" href="{{ route('delete.item.cart', [$idCart]) }}"class="delete-item-cart"><span class="icon_close"></span></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="shoping__cart__btns">
                    <a href="#" class="primary-btn cart-btn">CONTINUE SHOPPING</a>
                    <a onclick="return confirm('Are you sure?')" href="{{ route('delete.cart') }}" id="delete-cart" class="primary-btn cart-btn cart-btn-right text-danger"><i class="fa-sharp fa-solid fa-trash"></i>
                        Delete Cart</a>
                    <a href="#" class="primary-btn cart-btn cart-btn-right" id="update-cart"><span class="icon_loading"></span>
                        Upadate Cart</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__continue">
                    <div class="shoping__discount">
                        <h5>Discount Codes</h5>
                        <form action="#">
                            <input type="text" placeholder="Enter your coupon code">
                            <button type="submit" class="site-btn">APPLY COUPON</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="shoping__checkout">
                    <h5>Cart Total</h5>
                    <ul>
                        <li>Subtotal <span>${{ number_format($total, 2) }}</span></li>
                        <li>Total <span>${{ number_format($total, 2) }}</span></li>
                    </ul>
                    <a href="{{ route('checkout') }}" class="primary-btn">PROCEED TO CHECKOUT</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@section('my-script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#update-cart').on('click',function(){
            // alert('1231');
            var list = [];
            $('table#shopping-cart tr input').each(function(){
                var item = { 
                    id: $(this).data('id'),
                    qty: $(this).val() 
                };
                list.push(item);
            });
            console.log(list);

            $.ajax({
                type: 'POST',
                url : "{{  route('update.cart') }}",
                data:{
                    "_token" : "{{ csrf_token() }}",
                    list: list
                },
                success: function(data){
                    location.reload();
                }
            });
        });
    }); 
</script>
@endsection