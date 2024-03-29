<footer class="ps-footer">
    <div class="container">
        <div class="ps-footer__widgets">
            <aside class="col-md-3 widget widget_footer widget_contact-us">
                <h4 class="widget-title">Contact us</h4>
                <div class="widget_content">
                    <p>Call us 24/7</p>
                    <h3>1800 97 97 69</h3>
                    <p>502 New Design Str, Melbourne, Australia <br /><a
                            href="mailto:contact@martfury.co">contact@martfury.co</a></p>
                    <ul class="ps-list--social">
                        <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                        <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                        <li><a class="google-plus" href="#"><i class="fa fa-google-plus"></i></a></li>
                        <li><a class="instagram" href="#"><i class="fa fa-instagram"></i></a></li>
                    </ul>
                </div>
            </aside>
            <aside class="col-md-4 widget widget_footer widget_contact-us">
                <div class="logo">
                    <a href="{{ route('shop.home.index') }}" aria-label="Logo">
                        @if ($logo = core()->getCurrentChannel()->logo_url)
                            <img src="{{ $logo }}" class="logo full-img" width="200" height="50" />
                        @else
                            <img src="{{ asset('themes/martfury/assets/images/logo.png') }}" class="logo full-img" width="200" height="50" />
                        @endif
                    </a>
                </div>
            
                @if ($velocityMetaData)
                    {!! $velocityMetaData->footer_left_content !!}
                @else
                    {!! __('velocity::app.admin.meta-data.footer-left-raw-content') !!}
                @endif
            </aside>
            {!! DbView::make(core()->getCurrentChannel())->field('footer_content')->render() !!}
            {{-- <aside class="widget widget_footer">
                <h4 class="widget-title">Quick links</h4>
                <ul class="ps-list--link">
                    <li><a href="/page/blank">Policy</a></li>
                    <li><a href="/page/blank">Term &amp; Condition</a></li>
                    <li><a href="/page/blank">Shipping</a></li>
                    <li><a href="/page/blank">Return</a></li>
                    <li><a href="/page/faqs">FAQs</a></li>
                </ul>
            </aside>
            <aside class="widget widget_footer">
                <h4 class="widget-title">Company</h4>
                <ul class="ps-list--link">
                    <li><a href="/page/about-us">About Us</a></li>
                    <li><a href="/page/blank">Affilate</a></li>
                    <li><a href="/page/blank">Career</a></li>
                    <li><a href="/page/contact-us">Contact</a></li>
                </ul>
            </aside> --}}
            {{-- <aside class="widget widget_footer">
                <h4 class="widget-title">Bussiness</h4>
                <ul class="ps-list--link">
                    <li><a href="/page/about-us">Our Press</a></li>
                    <li><a href="/account/checkout">Checkout</a></li>
                    <li><a href="/account/user-information">My account</a></li>
                    <li><a href="/shop">Shop</a></li>
                </ul>
            </aside> --}}
        </div>
        {{-- <div class="ps-footer__links">
            <p><strong>Consumer Electric:</strong><a href="/shop">Air Conditioners</a><a href="/shop">Audios
                    &amp; Theaters</a><a href="/shop">Car Electronics</a><a href="/shop">Office
                    Electronics</a><a href="/shop">TV Televisions</a><a href="/shop">Washing Machines</a></p>
            <p><strong>Clothing &amp; Apparel:</strong><a href="/shop">Printers</a><a
                    href="/shop">Projectors</a><a href="/shop">Scanners</a><a href="/shop">Store &amp;
                    Business</a><a href="/shop">4K Ultra HD TVs</a><a href="/shop">LED TVs</a><a
                    href="/shop">OLED TVs</a></p>
            <p><strong>Home, Garden &amp; Kitchen:</strong><a href="/shop">Cookware</a><a
                    href="/shop">Decoration</a><a href="/shop">Furniture</a><a href="/shop">Garden Tools</a><a
                    href="/shop">Garden Equipments</a><a href="/shop">Powers And Hand Tools</a><a
                    href="/shop">Utensil &amp; Gadget</a></p>
            <p><strong>Health &amp; Beauty:</strong><a href="/shop">Hair Care</a><a
                    href="/shop">Decoration</a><a href="/shop">Makeup</a><a href="/shop">Body Shower</a><a
                    href="/shop">Skin Care</a><a href="/shop">Cologine</a><a href="/shop">Perfume</a></p>
            <p><strong>Jewelry &amp; Watches:</strong><a href="/shop">Necklace</a><a href="/shop">Pendant</a><a
                    href="/shop">Diamond Ring</a><a href="/shop">Sliver Earing</a><a href="/shop">Leather
                    Watcher</a><a href="/shop">Gucci</a></p>
            <p><strong>Computer &amp; Technologies:</strong><a href="/shop">Desktop PC</a><a
                    href="/shop">Laptop</a><a href="/shop">Smartphones</a><a href="/shop">Tablet</a><a
                    href="/shop">Game Controller</a><a href="/shop">Audio &amp; Video</a><a
                    href="/shop">Wireless Speaker</a></p>
        </div> --}}
        <div class="ps-footer__copyright">
            <p>&copy; 2022 Martfury. All Rights Reserved</p>
            <p>
                <span>We Using Safe Payment For:</span>
                <img src="{{ asset('themes/martfury/assets/images/payment-method/1.jpg') }}" alt="Martfury" role="button" />
                <img src="{{ asset('themes/martfury/assets/images/payment-method/2.jpg') }}" alt="Martfury" role="button" />
                <img src="{{ asset('themes/martfury/assets/images/payment-method/3.jpg') }}" alt="Martfury" role="button" />
                <img src="{{ asset('themes/martfury/assets/images/payment-method/4.jpg') }}" alt="Martfury" role="button" />
                <img src="{{ asset('themes/martfury/assets/images/payment-method/5.jpg') }}" alt="Martfury" role="button" />
            </p>
        </div>
    </div>
</footer>
{{-- <div class="footer">
    <div class="footer-content">
        <div class="footer-list-container">

            <?php
                $categories = [];

                foreach (app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id) as $category){
                    if ($category->slug) array_push($categories, $category);
                }
            ?>

            @if (count($categories))
                <div class="list-container">
                    <span class="list-heading">Categories</span>
                    <ul class="list-group">
                        @foreach ($categories as $key => $category)
                            <li>
                                <a href="{{ route('shop.productOrCategory.index', $category->slug) }}">{{ $category->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {!! DbView::make(core()->getCurrentChannel())->field('footer_content')->render() !!}

            <div class="list-container">
                @if(core()->getConfigData('customer.settings.newsletter.subscription'))
                    <label class="list-heading" for="subscribe-field">{{ __('shop::app.footer.subscribe-newsletter') }}</label>
                    <div class="form-container">
                        <form action="{{ route('shop.subscribe') }}">
                            <div class="control-group" :class="[errors.has('subscriber_email') ? 'has-error' : '']">
                                <input type="email" id="subscribe-field" class="control subscribe-field" name="subscriber_email" placeholder="Email Address" required><br/>

                                <button class="btn btn-md btn-primary">{{ __('shop::app.subscription.subscribe') }}</button>
                            </div>
                        </form>
                    </div>
                @endif

                <?php
                    $term = request()->input('term');

                    if (! is_null($term)) {
                        $serachQuery = 'term='.request()->input('term');
                    }
                ?>

                <label class="list-heading" for="locale-switcher">{{ __('shop::app.footer.locale') }}</label>
                <div class="form-container">
                    <div class="control-group">
                        <select class="control locale-switcher" id="locale-switcher" onchange="window.location.href = this.value" @if (count(core()->getCurrentChannel()->locales) == 1) disabled="disabled" @endif>

                            @foreach (core()->getCurrentChannel()->locales as $locale)
                                @if (isset($serachQuery))
                                    <option value="?{{ $serachQuery }}&locale={{ $locale->code }}" {{ $locale->code == app()->getLocale() ? 'selected' : '' }}>{{ $locale->name }}</option>
                                @else
                                    <option value="?locale={{ $locale->code }}" {{ $locale->code == app()->getLocale() ? 'selected' : '' }}>{{ $locale->name }}</option>
                                @endif
                            @endforeach

                        </select>
                    </div>
                </div>

                <div class="currency">
                    <label class="list-heading" for="currency-switcher">{{ __('shop::app.footer.currency') }}</label>
                    <div class="form-container">
                        <div class="control-group">
                            <select class="control locale-switcher" id="currency-switcher" onchange="window.location.href = this.value">

                                @foreach (core()->getCurrentChannel()->currencies as $currency)
                                    @if (isset($serachQuery))
                                        <option value="?{{ $serachQuery }}&currency={{ $currency->code }}" {{ $currency->code == core()->getCurrentCurrencyCode() ? 'selected' : '' }}>{{ $currency->code }}</option>
                                    @else
                                        <option value="?currency={{ $currency->code }}" {{ $currency->code == core()->getCurrentCurrencyCode() ? 'selected' : '' }}>{{ $currency->code }}</option>
                                    @endif
                                @endforeach

                            </select>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div> --}}
