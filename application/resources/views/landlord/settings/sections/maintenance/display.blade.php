<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('lang.maintenance_mode')</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            background-color: #f4f6f9;
            color: #3d4e6b;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .maintenance-wrapper {
            text-align: center;
            max-width: 800px;
            width: 90%;
            padding: 80px 60px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }
        .maintenance-message {
            font-size: 15px;
            line-height: 1.7;
            color: #5a6a85;
        }
    </style>
</head>
<body>
    <div class="maintenance-wrapper">
        @if(!empty($message))
        <div class="maintenance-message">{!! $message !!}</div>
        @endif
    </div>
</body>
</html>
