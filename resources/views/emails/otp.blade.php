<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #ffffff;
      font-family: 'Segoe UI', sans-serif;
    }
    .container {
      max-width: 600px;
      margin: auto;
      padding: 24px;
      background-color: #ffffff;
      border: 1px solid #e0e0e0;
    }
    .logo {
      text-align: center;
      margin-bottom: 24px;
    }
    .logo img {
      max-width: 150px;
      height: auto;
    }
    .message {
      color: #000000;
      font-size: 16px;
      line-height: 1.5;
      text-align: center;
      margin-bottom: 24px;
    }
    .otp-box {
      background-color: #000000;
      color: #ffffff;
      font-size: 28px;
      font-weight: bold;
      letter-spacing: 4px;
      text-align: center;
      padding: 16px;
      border-radius: 8px;
      margin: 0 auto 24px;
      max-width: 200px;
    }
    .footer {
      text-align: center;
      font-size: 12px;
      color: #777777;
      margin-top: 32px;
    }
    @media (max-width: 600px) {
      .container {
        padding: 16px;
      }
      .otp-box {
        font-size: 24px;
        padding: 12px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="logo">
      <img src="https://fairmontshippingreports.com/fairmont-logo.png" alt="fairmont-logo" width="80" style="height:auto;">
    </div>
    <div class="message">
      Hello,<br><br>
      Please use the one-time password (OTP) below to complete your verification. This code is valid for a limited time only.
    </div>
    <div class="otp-box">
     {{ $otp }}
    </div>
    <div class="message">
      If you did not request this code, please ignore this message.
    </div>
    <div class="footer">
      &copy; 2025 Fairmont. All rights reserved.
    </div>
  </div>
</body>
</html>
