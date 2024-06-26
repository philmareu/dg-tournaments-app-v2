<div class="uk-width-medium-1-3 uk-container-center uk-margin-top">
    <div class="uk-panel uk-panel-box">
        <h1>Login</h1>
        <form class="uk-form uk-form-stacked" method="POST" action="{{ $action }}">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            @include('vendor.laraform.elements.form.email', ['name' => 'email'])
            @include('vendor.laraform.elements.form.password', ['name' => 'password'])
            @include('vendor.laraform.elements.form.checkbox', ['name' => 'remember', 'checked' => false])

            <div class="uk-form-row">
                <div class="uk-grid uk-grid-collapse">
                    <div class="uk-width-medium-1-2">
                        <button type="submit" class="uk-button uk-button-primary">Login</button>
                        <a href="{{ url('/auth/register') }}" class="uk-button">Register</a>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <a href="{{ url('/password/email') }}" class="forgot-password">Forgot Your Password?</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
