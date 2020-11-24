<?php

if (! function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (! function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (! function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (auth()->check()) {
            if (auth()->user()->can('view backend')) {
                return 'admin.dashboard';
            }

            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }
}

if (! function_exists('barcode_class')) {
    function barcode_class($code, $type = 'QRCODE', $col = 10, $row = 10) {
        return new class($code, $type, $col, $row){
            public $png;
            public $html;
            public $plain;

            function __construct($code, $type, $col, $row)
            {
                $this->png = "data:image/png;base64,".DNS2D::getBarcodePNG($code, $type ,$col, $row);
                $this->html = "<img src='" . $this->png . "' alt='barcode'/>";
                $this->plain = $code;
            }
            function __toString()
            {
                return $this->png;
            }
        };;
    }
}
