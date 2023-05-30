<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movie Quotes</title>
</head>
<body style=" background: linear-gradient(187.16deg, #181623 0.07%, #191725 51.65%, #0D0B14 98.75%); margin: 0; padding: 0; min-height: 100vh; font-family: Arial, sans-serif; font-size: 16px; font-weight: 200;">
<table align="center" style="max-width: 1250px; min-width: 300px; padding: 80px 20px 0 20px;; height: 100%; color: white">
    <thead>
    <tr>
        <td align="center" valign="bottom">
            <img src="{{ asset('images/quote.png') }}" alt="Quote Icon">
            <br>
            <h1 style="font-size: 16px; color: #DDCCAA;">MOVIE QUOTES</h1>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="left" valign="top">
            <p style="margin: 60px 0 0 0">Hola {{ $username }}!</p>
            <p style="margin: 25px 0">Thanks for joining Movie quotes! We really appreciate it. Please click the button below to update your password:</p>
            <br>
            <a href="{{ env('FRONTEND_URL') . '/password/reset/' . $token }}" style="text-decoration: none; color: white; background: #E31221; padding: 10px; border-radius: 4px;">Update password</a>
            <br>
            <br>
            <p style="margin: 40px 0">If clicking doesn't work, you can try copying and pasting it to your browser:</p>
            <p style="margin: 0; word-break: break-all; color:  #DDCCAA;">{{ env('FRONT_URL') . '/password/reset/' . $token }}</p>
            <br>
            <p style="margin: 40px 0 0 0">If you have any problems, please contact us: support@moviequotes.ge</p>
            <p style="margin: 30px 0;">MovieQuotes Crew</p>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>
