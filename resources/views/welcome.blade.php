<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Angular</title>

    <base href="/">
    <meta name="viewport"
          content="width=device-width, initial-scale=1">
    <link rel="icon"
          type="image/x-icon"
          href="favicon.ico">
</head>
<body>
<app-root></app-root>
<script type="text/javascript"
        src="{{ asset('js/inline.bundle.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/polyfills.bundle.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/scripts.bundle.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/styles.bundle.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/vendor.bundle.js') }}"></script>
<script type="text/javascript"
        src="{{ asset('js/main.bundle.js') }}"></script>
</body>
</html>