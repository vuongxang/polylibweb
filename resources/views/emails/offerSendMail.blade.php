<!-- @component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent -->

@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => $offer['url']])

Button Text
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
<!-- <!DOCTYPE html>
<html>
<head>
    <title>kings</title>
</head>
<body>
    <h1>{{ $offer['name'] }}</h1>
    <p>{{ $offer['content'] }}</p>

    <p>Thank you</p>
</body>
</html> -->