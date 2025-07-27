<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>{{ $subject }}</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f6f6f6;font-family:Arial,sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f6f6f6;padding:20px 0;">
    <tr>
      <td align="center">
        <table width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff;border-radius:6px;overflow:hidden;">
          <!-- Header -->
          <tr>
            <td style="background-color:#2d89ef;padding:20px;color:#ffffff;text-align:center;font-size:24px;font-weight:bold;">
              
            </td>
          </tr>

          <!-- Body Content -->
          <tr>
            <td style="padding:30px 20px;color:#333333;font-size:16px;line-height:1.5;">
              {!! $body !!}
            </td>
          </tr>

          
          <tr>
            <td style="padding:10px 20px;text-align:center;font-size:14px;">
             
            </td>
          </tr>
         

          <!-- Footer Note -->
          <!-- Unsubscribe -->
          @isset($unsubscribeUrl)
          <tr>
            <td style="padding:20px;text-align:center;font-size:12px;color:#888888;">
              <p style="margin-bottom:10px;">Anda menerima email ini karena tercatat sebagai salah satu member dari kelas yang saya miliki, atau subscribe di freebies saya.</p>
              <p style="margin-bottom:10px;">Dan kemudian saya import ke sistem baru saya yang bernama <a href="https://jowmail.com/" style="color:#2d89ef;text-decoration:none;">jowmail.com</a>.</p>
              <p style="margin-bottom:10px;">Jika ini bukan Anda, abaikan saja email ini.</p>
               <p>Jika kamu tidak ingin menerima email lagi dari kami,<br>
<a href="{{ $unsubscribeUrl }}" style="color:#d9534f;text-decoration:underline;">klik di sini untuk unsubscribe</a>.</p>
              


            </td>
          </tr>
           @endisset

          <!-- Copyright -->
          <tr>
            <td style="background-color:#f0f0f0;padding:15px;text-align:center;font-size:12px;color:#999999;">
              &copy; {{ date('Y') }} JOW Aplikasi Masa kini. All rights reserved.
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>