<div class="text-right" style="margin-right: 10px;">
    <span style="font-size: 1.5rem;"><i class="bi bi-cart"></i></span>
    @if (Auth::check())
        <a href="{{ route('mycart', ['user_id' => Auth::user()->id]) }}">Cart Item(s): {{ $num_cart_items }}</a>
    @else
        <a href="{{ route('mycart', ['session_id' => Session::getId()]) }}">Cart Item(s): </a>
    @endif
</div>
