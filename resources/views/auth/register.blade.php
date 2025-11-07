@extends('layouts.guest')
@section('title', ' Create an Account')
@section('content')

<div class="nk-split nk-split-page nk-split-lg">
    <div class="nk-split-content nk-block-area nk-block-area-column nk-auth-container bg-white">
        <div class="absolute-top-right d-lg-none p-3 p-sm-5"><a href="#"
                class="toggle btn-white btn btn-icon btn-light" data-target="athPromo"><em
                    class="icon ni ni-info"></em></a></div>
        <div class="nk-block nk-block-middle nk-auth-body">
            <div class="brand-logo pb-5"><a href="../../index.html" class="logo-link"><img
                        class="logo-light logo-img logo-img-lg" src="../../images/logo.png"
                        srcset="/demo1/images/logo2x.png 2x" alt="logo"><img
                        class="logo-dark logo-img logo-img-lg" src="../../images/logo-dark.png"
                        srcset="/demo1/images/logo-dark2x.png 2x" alt="logo-dark"></a></div>
            <div class="nk-block-head">
                <div class="nk-block-head-content">
                    <h5 class="nk-block-title">Sign-Up</h5>
                    <div class="nk-block-des">
                        <p>Create a new account to access the {{ config('app.name') }} panel.</p>
                    </div>
                </div>
            </div>
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Names -->
                <div class="form-group">
                    <div class="form-label-group"><label class="form-label"
                            for="name">Name</label>
                    </div>
                    <div class="form-control-wrap">
                        <input autocomplete="username" type="text" name="name" class="form-control form-control-lg" required id="name" placeholder="Enter your name">
                    </div>
                </div>

                <!-- Email Address -->
                <div class="form-group">
                    <div class="form-label-group"><label class="form-label"
                            for="email-address">Email or Username</label>
                    </div>
                    <div class="form-control-wrap">
                        <input autocomplete="username" type="text" name="email" class="form-control form-control-lg" required id="email" placeholder="Enter your email address or username">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="password">Passcode</label>
                    </div>
                    <div class="form-control-wrap">
                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a><input autocomplete="current-password" type="password" name="password" class="form-control form-control-lg" required id="password" placeholder="Enter your passcode">
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label-group">
                        <label class="form-label" for="password">Confirm Passcode</label>
                    </div>
                    <div class="form-control-wrap">
                        <a tabindex="-1" href="#" class="form-icon form-icon-right passcode-switch lg" data-target="password_confirmation">
                            <em class="passcode-icon icon-show icon ni ni-eye"></em>
                            <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                        </a><input autocomplete="current-password" type="password" name="password_confirmation" class="form-control form-control-lg" required id="password_confirmation" placeholder="Enter your password confirmation">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-primary btn-block">Sign up</button>
                </div>
            </form>
            <div class="form-note-s2 pt-4"> Already on our platform? <a href="{{ route('login') }}">Sign in
                    to your account</a></div>
        </div>
    </div>
    <div class="nk-split-content nk-split-stretch bg-lighter d-flex toggle-break-lg toggle-slide toggle-slide-right"
        data-toggle-body="true" data-content="athPromo" data-toggle-screen="lg"
        data-toggle-overlay="true">
        <div class="slider-wrap w-100 w-max-550px p-3 p-sm-5 m-auto">
            <div class="slider-init" data-slick='{"dots":true, "arrows":false}'>
                <div class="slider-item">
                    <div class="nk-feature nk-feature-center">
                        <div class="nk-feature-img"><img class="round"
                                src="../../images/slides/promo-a.png"
                                srcset="/demo1/images/slides/promo-a2x.png 2x" alt=""></div>
                        <div class="nk-feature-content py-4 p-sm-5">
                            <h4>Dashlite</h4>
                            <p>You can start to create your products easily with its user-friendly
                                design & most completed responsive layout.</p>
                        </div>
                    </div>
                </div>
                <div class="slider-item">
                    <div class="nk-feature nk-feature-center">
                        <div class="nk-feature-img"><img class="round"
                                src="../../images/slides/promo-b.png"
                                srcset="/demo1/images/slides/promo-b2x.png 2x" alt=""></div>
                        <div class="nk-feature-content py-4 p-sm-5">
                            <h4>Dashlite</h4>
                            <p>You can start to create your products easily with its user-friendly
                                design & most completed responsive layout.</p>
                        </div>
                    </div>
                </div>
                <div class="slider-item">
                    <div class="nk-feature nk-feature-center">
                        <div class="nk-feature-img"><img class="round"
                                src="../../images/slides/promo-c.png"
                                srcset="/demo1/images/slides/promo-c2x.png 2x" alt=""></div>
                        <div class="nk-feature-content py-4 p-sm-5">
                            <h4>Dashlite</h4>
                            <p>You can start to create your products easily with its user-friendly
                                design & most completed responsive layout.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-dots"></div>
            <div class="slider-arrows"></div>
        </div>
    </div>
</div>
@endsection