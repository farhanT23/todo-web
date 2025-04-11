<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email Address</title>
    <style>
        /* Reset default styles */
        body,
        table,
        td,
        a,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
        }

        body {
            background-color: #f4f4f4;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .header {
            background-color: #007bff;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 24px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
            color: #333333;
            line-height: 1.6;
        }

        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #007bff;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 500;
            text-align: center;
        }

        .button:hover {
            background-color: #0056b3;
        }

        .fallback {
            margin-top: 20px;
            font-size: 14px;
            color: #666666;
            word-break: break-all;
        }

        .footer {
            padding: 20px;
            background-color: #f8f9fa;
            text-align: center;
            font-size: 14px;
            color: #666666;
        }

        .footer p {
            margin: 0;
        }

        @media screen and (max-width: 600px) {
            .container {
                width: 100%;
                margin: 0 10px;
            }

            .content {
                padding: 20px;
            }

            .button {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Verify Your Email Address</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Hello,</p>
            <p>Thank you for signing up with {{ config('app.name') }}! To get started, please verify your email address
                by clicking the button below:</p>
            <p>
                <a href="{{ route('verify', ['otp' => $token]) }}" class="button">Verify Email</a>
            </p>
            <p>If you’re having trouble clicking the button, copy and paste the URL below into your web browser:</p>
            <p class="fallback">
                <a href="{{ route('verify', ['otp' => $token]) }}">{{ route('verify', ['otp' => $token]) }}</a>
            </p>
            <p>If you did not create an account, no further action is required.</p>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Thanks,<br>{{ config('app.name') }} Team</p>
        </div>
    </div>
</body>

</html>
