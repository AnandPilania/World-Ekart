@extends('shop::layouts.master')

@section('page_title')
    {{ __('shop::app.checkout.onepage.title') }}
@stop

@section('content-wrapper')
<div class="ps-page--my-account">
    <div class="ps-breadcrumb border-bottom">
        <div class="container">
            <ul class="breadcrumb">
                <li><a href="{{ route('shop.home.index') }}">{{ __('shop::app.home.home-title') }}</a></li>
                <li>{{ __('shop::app.checkout.onepage.title') }}</li>
            </ul>
        </div>
    </div>
    <div class="ps-checkout ps-section--shopping pt-50">
        <div class="container">
            <div class="ps-section__header pb-5"><h1>{{ __('shop::app.checkout.onepage.title') }}</h1></div>
                <checkout></checkout>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('shop::checkout.cart.coupon')

    <script type="text/x-template" id="checkout-template">
        <div id="checkout" class="checkout-process">
            <div class="col-main">
                <ul class="checkout-steps">
                    <li class="active" :class="[completed_step >= 0 ? 'active' : '', completed_step > 0 ? 'completed' : '']" @click="navigateToStep(1)">
                        <div class="decorator address-info"></div>

                        <span>{{ __('shop::app.checkout.onepage.information') }}</span>
                    </li>

                    <div class="line mb-25"></div>

                    @if ($cart->haveStockableItems())
                        <li :class="[current_step == 2 || completed_step > 1 ? 'active' : '', completed_step > 1 ? 'completed' : '']" @click="navigateToStep(2)">
                            <div class="decorator shipping"></div>

                            <span>{{ __('shop::app.checkout.onepage.shipping') }}</span>
                        </li>

                        <div class="line mb-25"></div>
                    @endif

                    <li :class="[current_step == 3 || completed_step > 2 ? 'active' : '', completed_step > 2 ? 'completed' : '']" @click="navigateToStep(3)">
                        <div class="decorator payment"></div>

                        <span>{{ __('shop::app.checkout.onepage.payment') }}</span>
                    </li>

                    <div class="line mb-25"></div>

                    <li :class="[current_step == 4 ? 'active' : '']">
                        <div class="decorator review"></div>
                        <span>{{ __('shop::app.checkout.onepage.review') }}</span>
                    </li>
                </ul>

                <div class="step-content information" v-show="current_step == 1" id="address-section">
                    @include('shop::checkout.onepage.customer-info')

                    <div class="button-group">
                        <button type="button" class="ps-btn" @click="validateForm('address-form')" :disabled="disable_button" id="checkout-address-continue-button">
                            {{ __('shop::app.checkout.onepage.continue') }}
                        </button>
                    </div>
                </div>

                <div class="step-content shipping" v-show="current_step == 2" id="shipping-section">
                    <shipping-section v-if="current_step == 2" @onShippingMethodSelected="shippingMethodSelected($event)"></shipping-section>

                    <div class="button-group">
                        <button type="button" class="btn btn-lg btn-primary" @click="validateForm('shipping-form')" :disabled="disable_button" id="checkout-shipping-continue-button">
                            {{ __('shop::app.checkout.onepage.continue') }}
                        </button>
                    </div>
                </div>

                <div class="step-content payment" v-show="current_step == 3" id="payment-section">
                    <payment-section v-if="current_step == 3" @onPaymentMethodSelected="paymentMethodSelected($event)"></payment-section>

                    <div class="button-group">
                        <button type="button" class="btn btn-lg btn-primary" @click="validateForm('payment-form')" :disabled="disable_button" id="checkout-payment-continue-button">
                            {{ __('shop::app.checkout.onepage.continue') }}
                        </button>
                    </div>
                </div>

                <div class="step-content review" v-show="current_step == 4" id="summary-section">
                    <review-section v-if="current_step == 4" :key="reviewComponentKey">
                        <div slot="summary-section">
                            <summary-section :key="summeryComponentKey"></summary-section>

                            <coupon-component
                                @onApplyCoupon="getOrderSummary"
                                @onRemoveCoupon="getOrderSummary">
                            </coupon-component>
                        </div>
                    </review-section>

                    <div class="button-group">
                        <button type="button" class="btn btn-lg btn-primary" @click="placeOrder()" :disabled="disable_button" id="checkout-place-order-button" v-if="selected_payment_method.method != 'paypal_smart_button'">
                            {{ __('shop::app.checkout.onepage.place-order') }}
                        </button>

                        <div class="paypal-button-container"></div>
                    </div>
                </div>
            </div>
            <div class="col-right" v-show="current_step != 4">
                <summary-section :key="summeryComponentKey"></summary-section>
            </div>
        </div>
    </script>

    <script>
        let shippingHtml = '';
        let paymentHtml = '';
        let reviewHtml = '';
        let summaryHtml = '';
        let customerAddress = '';
        let shippingMethods = '';
        let paymentMethods = '';

        @auth('customer')
            @if(auth('customer')->user()->addresses)
                customerAddress = @json(auth('customer')->user()->addresses);
                customerAddress.email = "{{ auth('customer')->user()->email }}";
                customerAddress.first_name = "{{ auth('customer')->user()->first_name }}";
                customerAddress.last_name = "{{ auth('customer')->user()->last_name }}";
            @endif
        @endauth

        Vue.component('checkout', {
            template: '#checkout-template',
            inject: ['$validator'],

            data: function() {
                return {
                    step_numbers: {
                        'information': 1,
                        'shipping': 2,
                        'payment': 3,
                        'review': 4
                    },

                    current_step: 1,

                    completed_step: 0,

                    address: {
                        billing: {
                            address1: [''],

                            use_for_shipping: true,
                        },

                        shipping: {
                            address1: ['']
                        },
                    },

                    selected_shipping_method: '',

                    selected_payment_method: '',

                    disable_button: false,

                    new_shipping_address: false,

                    new_billing_address: false,

                    allAddress: {},

                    countryStates: @json(core()->groupedStatesByCountries()),

                    country: @json(core()->countries()),

                    summeryComponentKey: 0,

                    reviewComponentKey: 0,

                    is_customer_exist: 0
                }
            },

            created: function() {
                this.getOrderSummary();

                if(! customerAddress) {
                    this.new_shipping_address = true;
                    this.new_billing_address = true;
                } else {
                    this.address.billing.first_name = this.address.shipping.first_name = customerAddress.first_name;
                    this.address.billing.last_name = this.address.shipping.last_name = customerAddress.last_name;
                    this.address.billing.email = this.address.shipping.email = customerAddress.email;

                    if (customerAddress.length < 1) {
                        this.new_shipping_address = true;
                        this.new_billing_address = true;
                    } else {
                        this.allAddress = customerAddress;
                    }
                }
            },

            methods: {
                navigateToStep: function(step) {
                    if (step <= this.completed_step) {
                        this.current_step = step
                        this.completed_step = step - 1;
                    }
                },

                haveStates: function(addressType) {
                    if (this.countryStates[this.address[addressType].country] && this.countryStates[this.address[addressType].country].length)
                        return true;

                    return false;
                },

                validateForm: async function(scope) {
                    let self = this;

                    await this.$validator.validateAll(scope).then(function (result) {
                        if (result) {
                            if (scope == 'address-form') {
                                self.saveAddress();
                            } else if (scope == 'shipping-form') {
                                self.saveShipping();
                            } else if (scope == 'payment-form') {
                                self.savePayment();
                            }
                        }
                    });
                },

                isCustomerExist: function() {
                    this.$validator.attach({ name: "email", rules: "required|email" });

                    let self = this;

                    this.$validator.validate('email', this.address.billing.email)
                        .then(function(isValid) {
                            if (! isValid)
                                return;

                            self.$http.post("{{ route('customer.checkout.exist') }}", {email: self.address.billing.email})
                                .then(function(response) {
                                    self.is_customer_exist = response.data ? 1 : 0;
                                })
                                .catch(function (error) {})

                        })
                },

                loginCustomer: function() {
                    let self = this;

                    self.$http.post("{{ route('customer.checkout.login') }}", {
                            email: self.address.billing.email,
                            password: self.address.billing.password
                        })
                        .then(function(response) {
                            if (response.data.success) {
                                window.location.href = "{{ route('shop.checkout.onepage.index') }}";
                            } else {
                                window.flashMessages = [{'type': 'alert-error', 'message': response.data.error }];

                                self.$root.addFlashMessages()
                            }
                        })
                        .catch(function (error) {})
                },

                getOrderSummary () {
                    let self = this;

                    this.$http.get("{{ route('shop.checkout.summary') }}")
                        .then(function(response) {
                            summaryHtml = Vue.compile(response.data.html)

                            self.summeryComponentKey++;
                        })
                        .catch(function (error) {})
                },

                saveAddress: async function() {
                    let self = this;

                    this.disable_button = true;

                    if (this.allAddress.length > 0) {
                        let address = this.allAddress.forEach(address => {
                            if (address.id == this.address.billing.address_id) {
                                this.address.billing.address1 = [address.address1];
                            }

                            if (address.id == this.address.shipping.address_id) {
                                this.address.shipping.address1 = [address.address1];
                            }
                        });
                    }

                    this.$http.post("{{ route('shop.checkout.save-address') }}", this.address)
                        .then(function(response) {
                            self.disable_button = false;

                            if (self.step_numbers[response.data.jump_to_section] == 2)
                                shippingHtml = Vue.compile(response.data.html)
                            else
                                paymentHtml = Vue.compile(response.data.html)

                            self.completed_step = self.step_numbers[response.data.jump_to_section] - 1;
                            self.current_step = self.step_numbers[response.data.jump_to_section];

                            shippingMethods = response.data.shippingMethods;
                            paymentMethods  = response.data.paymentMethods;

                            self.getOrderSummary();
                        })
                        .catch(function (error) {
                            self.disable_button = false;

                            self.handleErrorResponse(error.response, 'address-form')
                        })
                },

                saveShipping: async function() {
                    let self = this;

                    this.disable_button = true;

                    this.$http.post("{{ route('shop.checkout.save-shipping') }}", {'shipping_method': this.selected_shipping_method})
                        .then(function(response) {
                            self.disable_button = false;

                            paymentHtml = Vue.compile(response.data.html)
                            self.completed_step = self.step_numbers[response.data.jump_to_section] - 1;
                            self.current_step = self.step_numbers[response.data.jump_to_section];

                            paymentMethods = response.data.paymentMethods;

                            self.getOrderSummary();
                        })
                        .catch(function (error) {
                            self.disable_button = false;

                            self.handleErrorResponse(error.response, 'shipping-form')
                        })
                },

                savePayment: async function() {
                    let self = this;

                    this.disable_button = true;

                    this.$http.post("{{ route('shop.checkout.save-payment') }}", {'payment': this.selected_payment_method})
                    .then(function(response) {
                        self.disable_button = false;

                        reviewHtml = Vue.compile(response.data.html)
                        self.completed_step = self.step_numbers[response.data.jump_to_section] - 1;
                        self.current_step = self.step_numbers[response.data.jump_to_section];

                        self.getOrderSummary();
                    })
                    .catch(function (error) {
                        self.disable_button = false;

                        self.handleErrorResponse(error.response, 'payment-form')
                    });
                },

                placeOrder: async function() {
                    let self = this;

                    this.disable_button = true;

                    this.$http.post("{{ route('shop.checkout.save-order') }}", {'_token': "{{ csrf_token() }}"})
                    .then(function(response) {
                        if (response.data.success) {
                            if (response.data.redirect_url) {
                                window.location.href = response.data.redirect_url;
                            } else {
                                window.location.href = "{{ route('shop.checkout.success') }}";
                            }
                        }
                    })
                    .catch(function (error) {
                        self.disable_button = true;

                        window.flashMessages = [{'type': 'alert-error', 'message': "{{ __('shop::app.common.error') }}" }];

                        self.$root.addFlashMessages()
                    })
                },

                handleErrorResponse: function(response, scope) {
                    if (response.status == 422) {
                        serverErrors = response.data.errors;
                        this.$root.addServerErrors(scope)
                    } else if (response.status == 403) {
                        if (response.data.redirect_url) {
                            window.location.href = response.data.redirect_url;
                        }
                    }
                },

                shippingMethodSelected: function(shippingMethod) {
                    this.selected_shipping_method = shippingMethod;
                },

                paymentMethodSelected: function(paymentMethod) {
                    this.selected_payment_method = paymentMethod;
                },

                newBillingAddress: function() {
                    this.new_billing_address = true;
                    this.address.billing.address_id = null;
                },

                newShippingAddress: function() {
                    this.new_shipping_address = true;
                    this.address.shipping.address_id = null;
                },

                backToSavedBillingAddress: function() {
                    this.new_billing_address = false;
                },

                backToSavedShippingAddress: function() {
                    this.new_shipping_address = false;
                },
            }
        });

        let shippingTemplateRenderFns = [];

        Vue.component('shipping-section', {
            inject: ['$validator'],

            data: function() {
                return {
                    templateRender: null,

                    selected_shipping_method: '',

                    first_iteration : true,
                }
            },

            staticRenderFns: shippingTemplateRenderFns,

            mounted: function() {
                for (method in shippingMethods) {
                    if (this.first_iteration) {
                        for (rate in shippingMethods[method]['rates']) {
                            this.selected_shipping_method = shippingMethods[method]['rates'][rate]['method'];
                            this.first_iteration = false;
                            this.methodSelected();
                        }
                    }
                }

                this.templateRender = shippingHtml.render;
                for (let i in shippingHtml.staticRenderFns) {
                    shippingTemplateRenderFns.push(shippingHtml.staticRenderFns[i]);
                }

                eventBus.$emit('after-checkout-shipping-section-added');
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                    ]);
            },

            methods: {
                methodSelected: function() {
                    this.$emit('onShippingMethodSelected', this.selected_shipping_method)

                    eventBus.$emit('after-shipping-method-selected', this.selected_shipping_method);
                }
            }
        });

        let paymentTemplateRenderFns = [];

        Vue.component('payment-section', {
            inject: ['$validator'],

            data: function() {
                return {
                    templateRender: null,

                    payment: {
                        method: ""
                    },

                    first_iteration : true,
                }
            },

            staticRenderFns: paymentTemplateRenderFns,

            mounted: function() {
                for (method in paymentMethods) {
                    if (this.first_iteration) {
                        this.payment.method = paymentMethods[method]['method'];
                        this.first_iteration = false;
                        this.methodSelected();
                    }
                }

                this.templateRender = paymentHtml.render;
                for (let i in paymentHtml.staticRenderFns) {
                    paymentTemplateRenderFns.push(paymentHtml.staticRenderFns[i]);
                }

                eventBus.$emit('after-checkout-payment-section-added');
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                    ]);
            },

            methods: {
                methodSelected: function() {
                    this.$emit('onPaymentMethodSelected', this.payment);

                    $('.paypal-button-container').empty();

                    eventBus.$emit('after-payment-method-selected', this.payment);
                }
            }
        });

        let reviewTemplateRenderFns = [];

        Vue.component('review-section', {
            data: function() {
                return {
                    templateRender: null,

                    error_message: ''
                }
            },

            staticRenderFns: reviewTemplateRenderFns,

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                    ]);
            },

            mounted: function() {
                this.templateRender = reviewHtml.render;

                for (let i in reviewHtml.staticRenderFns) {
                    reviewTemplateRenderFns[i] = reviewHtml.staticRenderFns[i];
                }

                this.$forceUpdate();
            }
        });

        let summaryTemplateRenderFns = [];

        Vue.component('summary-section', {
            inject: ['$validator'],

            data: function() {
                return {
                    templateRender: null
                }
            },

            staticRenderFns: summaryTemplateRenderFns,

            mounted: function() {
                this.templateRender = summaryHtml.render;

                for (let i in summaryHtml.staticRenderFns) {
                    summaryTemplateRenderFns[i] = summaryHtml.staticRenderFns[i];
                }

                this.$forceUpdate();
            },

            render: function(h) {
                return h('div', [
                    (this.templateRender ?
                        this.templateRender() :
                        '')
                    ]);
            }
        });
    </script>
@endpush
