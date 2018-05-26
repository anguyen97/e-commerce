@component('mail::message')
# Hello {{$order_details['order_info']['name']}},

Thank you for trusting and using our products. AShoes would like to send you your order details.

@component('mail::table')
|      ID       | Name             |  Brand         |   Quantity     |   Size     | Color         | Price     |
| ------------- |:----------------:|:--------------:|:--------------:|:----------:|:-------------:|:---------:|
@foreach ($order_details['order_details_info'] as $item)
|{{$item->id}}|{{$item->name}}|{{$item->brand}}|{{$item->quantity}}|{{$item->size}}|{{$item->color}}|{{$item->price}}|
@endforeach

Tax: 5%;
Total: {{$order_details['order_info']['total_price']}}

@endcomponent
Thanks,<br>
{{ config('app.name') }}
@endcomponent
