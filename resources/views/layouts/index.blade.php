<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Stockly | E-Retailer</title>
    <meta name="author" content="Kepha Okello">
    <meta name="viewport" content="width=device-width">
    <link rel="shortcut icon" href="{{ secure_asset('images/eretailer_logo.png') }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
</head>
<body>

    <div id="dom-loader-animation">
        <i class="fa fa-spinner fa-spin fa-5x"></i>
    </div>

    <div class="header-and-nav">
        <div class="content">
            <h2>e-retailer (ER) | <span>order tracking</span></h2>
        </div>
    </div>

    <div class="header-nav-links-elements">
        <div class="header-nav-links">
            <div class="pull-left" id="nav-magento-dashboard">
                <a href="{{ $magento_admin_url }}" target="_blank"><img src="{{ secure_asset('images/magento_logo.png') }}"
                class="img-responsive" alt="|"> To Dashboard</a>
            </div>
        </div>

        <div class="pull-right" id="nav-elements">
            <ul>
                <li>
                    <a href="{{ url('/') }}" id="link_all_orders">All Orders</a>
                </li>
                <li>
                    <a href="{{ url('/suppliers') }}" id="link_all_suppliers">Suppliers</a>
                </li>
                <li>
                    <a href="{{ url('/import') }}" id="link_import">Import</a>
                </li>
            </ul>
        </div>

    </div>

    <div class="body-content-div">
        <div class="content">
            <div class="render-body-content">
                <div class="current-page-title">
                    <h4 id="page_header_title"></h4>
                </div>
                @yield('content')

            </div>
        </div>
    </div>

    <div class="body-modal">
        <div class="modal fade" id="primary_modal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                </div>
            </div>
        </div>
    </div>
    <div id="snackbar"></div>

    <a href="#" class="cd-top" style="  background: teal url({{ secure_asset('images/cd-top-arrow.svg') }}) no-repeat center 50%;">Top</a>

    @if(Session::has('returned_flash_message'))
        <script type="application/javascript">
            window.onload = function(){
                $('#flash_message_link').click();
            };
        </script>
        <a id="flash_message_link" class="hidden" href="javascript:;"
           onclick="toast_message('{{Session::get("returned_flash_message")}}')"></a>
    @endif

</body>
<footer>
    <div class="pull-left">
        <a href="https://www.stockly.ai" class="img-responsive" target="_blank"><img src="{{ secure_asset('images/stockly_logo.png') }}" alt="Stockly"></a>
    </div>
    <div class="pull-right">Order Tracker, Powered by <a href="https://www.stockly.ai" target="_blank">Stockly</a>
        &copy; {{date('Y')}} <a id="the-developer-footer" href="https://github.com/donksly" title="Developer" target="_blank"><i class="fa fa-2x fa-github"></i></a></div>
</footer>
<script src="{{secure_asset('js/app.js')}}"></script>
</html>
<script>
    function toast_message(message) {
        var x = document.getElementById("snackbar");
        $(x).html('<i class="fa fa-info-circle fa-lg"></i> '+message);
        x.className = "show";
        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }
</script>