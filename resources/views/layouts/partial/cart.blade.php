<div class="text-right" style="margin-right: 10px;">
    <span style="font-size: 1.5rem;"><i class="bi bi-cart"></i></span>
    @if (Auth::check())
        <a style="color: black;" href="{{ route('buy.mycart', ['user_id' => Auth::user()->id]) }}">View Cart</a>
    @else
        <a style="color: black;" href="{{ route('buy.mycart', ['session_id' => Session::getId()]) }}">View Cart</a>
    @endif
</div>
