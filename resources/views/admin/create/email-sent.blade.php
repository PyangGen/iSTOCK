<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family: Arial, sans-serif;">

<table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
<tr>
<td align="center">

    <table width="600" cellpadding="0" cellspacing="0" 
           style="background:#ffffff; border-radius:10px; padding:40px; box-shadow:0 4px 10px rgba(0,0,0,0.05);">

        <tr>
            <td style="font-size:22px; font-weight:600; padding-bottom:20px;">
                Verify your email
            </td>
        </tr>

        <tr>
            <td style="font-size:14px; color:#555; line-height:1.6;">
                We need to verify your email address 
                <strong>{{ $email }}</strong> 
                before you can access your account. 
                Enter the code below in your open browser window.
            </td>
        </tr>

        <tr>
            <td align="left" style="padding:30px 0;">
                <div style="font-size:36px; letter-spacing:5px; font-weight:bold; color:#111;">
                    {{ $code }}
                </div>
            </td>
        </tr>

        <tr>
            <td style="border-top:1px solid #eaeaea; padding-top:20px; font-size:12px; color:#777;">
                This code expires in 5 minutes.
                <br><br>
                If you didn’t sign up for iSTOCK, you can safely ignore this email. Someone else might have typed your email address by mistake.
            </td>
        </tr>

    </table>

</td>
</tr>
</table>

</body>
</html>
