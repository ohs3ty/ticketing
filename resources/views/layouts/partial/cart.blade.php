<div class="text-right" style="margin-right: 10px;">
    <span style="font-size: 1.5rem;"><i class="bi bi-cart"></i></span>
    @if (Auth::check())
        <a href="{{ route('mycart', ['user_id' => Auth::user()->id]) }}">View Cart</a>
    @else
        <a href="{{ route('mycart', ['session_id' => Session::getId()]) }}">View Cart</a>
    @endif
</div>
