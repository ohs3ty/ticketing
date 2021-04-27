<div class="text-right" style="margin-right: 10px;">
    <span style="font-size: 1.5rem;"><i class="bi bi-cart"></i></span>
    @if (Auth::check())
        <a href="{{ route('mycart', ['user_id' => Auth::user()->id]) }}">Cart Item(s): </a>
    @endif
</div>
