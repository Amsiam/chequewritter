<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Cheque</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: "Arial", sans-serif;
        }
    </style>

</head>

<body
    style="font-size: 4.25mm; display: flex; justify-content: end; align-items: center;height:100vh;margin-right: 0.1in">
    <div style="">
        @php
        $date = Carbon\Carbon::parse($chequeWrite->date)->format('dmY'); @endphp
        <div style="margin-top:-0.657in;margin-left:5.60in;display:flex;gap:4.2mm">
            @for ($i = 0; $i < 8; $i++)
                <div>
                    {{ $date[$i] }}
                </div>
            @endfor
        </div>


        <div style="margin-top:0.4in;margin-left:0.8in">
            **{{ $chequeWrite->payee->name }}**
        </div>
        <div style="margin-top:0.09in;display:flex">
            <div style="margin-left:0.5in;width:4.4in;line-height: .9cm;">
                <span style="display:inline-block;width: 1in"> </span>
                **{{ ucfirst(Str::replace('cent', 'paisa', number_to_word("$chequeWrite->amount", 'en'))) }} only**
            </div>
            <div>
                <div style="margin-left:0.8in;padding-top:0.2in">
                    **{{ number_format($chequeWrite->amount, 2) }}**
                </div>
            </div>
        </div>

    </div>
</body>

</html>
