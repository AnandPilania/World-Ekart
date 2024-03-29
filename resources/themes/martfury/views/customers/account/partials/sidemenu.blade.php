@php
    $customer = auth()->guard('customer')->user();
@endphp
<div class="col-lg-3">
    <div class="ps-section__left">
        <aside class="ps-widget--account-dashboard">
            <div class="ps-widget__header">
                <figure>
                    <figcaption>Hello</figcaption>
                    <p>{{ $customer->email }}</p>
                </figure>
            </div>
            @foreach ($menu->items as $menuItem)
                <div class="ps-widget__content">
                    <ul class="ps-list--user-links">
                        @php
                            $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;

                            $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                        @endphp

                        @if (! $showCompare)
                            @php
                                unset($menuItem['children']['compare']);
                            @endphp
                        @endif

                        @if (! $showWishlist)
                            @php
                                unset($menuItem['children']['wishlist']);
                            @endphp
                        @endif
                        @foreach ($menuItem['children'] as $index => $subMenuItem)
                            @if ($index == 'rma')
                                @if(core()->getConfigData('rma.settings.general.enable_rma'))
                                    <li class="{{ $menu->getActive($subMenuItem) }}">
                                        <a href="{{ $subMenuItem['url'] }}" class="d-flex justify-content-between">
                                            {{ trans($subMenuItem['name']) }}
                                            <i class="icon angle-right-icon"></i>
                                        </a>
                                    </li>
                                @endif
                            @else
                                <li class="{{ $menu->getActive($subMenuItem) }}">
                                    <a href="{{ $subMenuItem['url'] }}" class="d-flex justify-content-between">
                                        {{ trans($subMenuItem['name']) }}
                                        <i class="icon angle-right-icon"></i>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </aside>
    </div>
</div>
{{-- <div class="sidebar">
    @foreach ($menu->items as $menuItem)
        <div class="menu-block">
            <div class="menu-block-title">
                {{ trans($menuItem['name']) }}

                <i class="icon icon-arrow-down right" id="down-icon"></i>
            </div>

            <div class="menu-block-content">
                <ul class="menubar">
                    @php
                        $showCompare = core()->getConfigData('general.content.shop.compare_option') == "1" ? true : false;

                        $showWishlist = core()->getConfigData('general.content.shop.wishlist_option') == "1" ? true : false;
                    @endphp

                    @if (! $showCompare)
                        @php
                            unset($menuItem['children']['compare']);
                        @endphp
                    @endif

                    @if (! $showWishlist)
                        @php
                            unset($menuItem['children']['wishlist']);
                        @endphp
                    @endif

                    @foreach ($menuItem['children'] as $index => $subMenuItem)
                        @if ($index == 'rma')
                            @if(core()->getConfigData('rma.settings.general.enable_rma'))
                                <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                    <a href="{{ $subMenuItem['url'] }}">
                                        {{ trans($subMenuItem['name']) }}
                                    </a>

                                    <i class="icon angle-right-icon"></i>
                                </li>
                            @endif
                        @else
                            <li class="menu-item {{ $menu->getActive($subMenuItem) }}">
                                <a href="{{ $subMenuItem['url'] }}">
                                    {{ trans($subMenuItem['name']) }}
                                </a>

                                <i class="icon angle-right-icon"></i>
                            </li>
                        @endif
                      
                    @endforeach
                </ul>
            </div>
        </div>

    @endforeach
</div> --}}

@push('scripts')
<script>
    $(document).ready(function() {
        $(".icon.icon-arrow-down.right").on('click', function(e){
            var currentElement = $(e.currentTarget);
            if (currentElement.hasClass('icon-arrow-down')) {
                $(this).parents('.menu-block').find('.menubar').show();
                currentElement.removeClass('icon-arrow-down');
                currentElement.addClass('icon-arrow-up');
            } else {
                $(this).parents('.menu-block').find('.menubar').hide();
                currentElement.removeClass('icon-arrow-up');
                currentElement.addClass('icon-arrow-down');
            }
        });
    });
</script>
@endpush