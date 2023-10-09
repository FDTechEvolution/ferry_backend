<meta charset="UTF-8">
<title>Ferry Application</title>
<meta name="description" content="...">

<meta name="viewport" content="width=device-width, maximum-scale=5, initial-scale=1">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- up to 10% speed up for external res -->
<link rel="dns-prefetch" href="https://fonts.googleapis.com/">
<link rel="dns-prefetch" href="https://fonts.gstatic.com/">
<link rel="preconnect" href="https://fonts.googleapis.com/">
<link rel="preconnect" href="https://fonts.gstatic.com/">
<!-- preloading icon font is helping to speed up a little bit -->
<link rel="preload" href="{{ asset('assets/fonts/flaticon/Flaticon.woff2') }}" as="font" type="font/woff2" crossorigin>

<link rel="stylesheet" href="{{ asset('assets/css/core.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/vendor_bundle.min.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&display=swap">

<!-- Custom Style -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

<!-- favicon -->
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">