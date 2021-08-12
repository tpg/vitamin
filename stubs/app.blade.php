<!doctype html>
<html lang="en">
<head>
    <title>Vitamin</title>
    <meta charset="UTF-8" />
    <meta name="base-url" content="{{ Arr::get($page, 'props.baseUrl') }}"/>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {!! $vitamin !!}
</head>
<body>
    @inertia
</body>
</html>
