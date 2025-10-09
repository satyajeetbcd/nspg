<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Welcome to FERP Controller</title>
</head>

<body style="margin:0;padding:0;background:#f6f7f9;">
  <!-- Preheader (hidden) -->
  <div style="display:none;max-height:0;overflow:hidden;opacity:0">Welcome to FERP Controller! Start managing your business today.</div>

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f6f7f9;">
    <tr>
      <td align="center" style="padding:24px;">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
          style="width:100%;max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;">

          <!-- Header -->
          <tr>
            <td style="padding:24px 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:28px;color:#ffffff;font-weight:700;text-align:center;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
              🎉 Welcome to FERP Controller!
            </td>
          </tr>

          <tr>
            <td style="padding:0 24px 16px 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#ffffff;text-align:center;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);opacity:0.9;">
              Your account has been successfully created
            </td>
          </tr>

          <!-- Welcome Message -->
          <tr>
            <td style="padding:24px 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:24px;color:#0f172a;">
              Hi <strong>{{ $customer->name ?? 'Valued Customer' }}</strong>,
            </td>
          </tr>

          <tr>
            <td style="padding:0 24px 24px 24px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:24px;color:#0f172a;">
              Welcome to FERP Controller! We're excited to have you on board. ✨<br><br>
              Your account has been successfully created and you can now start exploring our powerful business management features.
            </td>
          </tr>

          <!-- Features Section -->
          <tr>
            <td style="padding:0 24px 24px 24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                style="background:#f8f9fa;border-radius:8px;padding:20px;">

                <tr>
                  <td style="padding:0 0 16px 0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:24px;color:#0f172a;font-weight:600;">
                    🚀 What you can do now:
                  </td>
                </tr>

                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#495057;">
                    ✅ Access your dashboard<br>
                    ✅ Manage your business data<br>
                    ✅ Generate reports and analytics<br>
                    ✅ Collaborate with your team<br>
                    ✅ Customize your workspace
                  </td>
                </tr>

              </table>
            </td>
          </tr>

          <!-- Account Details -->
          <tr>
            <td style="padding:0 24px 24px 24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                style="background:#e3f2fd;border-radius:8px;padding:20px;border-left:4px solid #2196f3;">

                <tr>
                  <td style="padding:0 0 12px 0;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:24px;color:#0f172a;font-weight:600;">
                    📋 Your Account Details:
                  </td>
                </tr>

                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#1976d2;">
                    <strong>Email:</strong> {{ $customer->email ?? 'N/A' }}<br>
                    <strong>Name:</strong> {{ $customer->name ?? 'N/A' }}<br>
                    <strong>Created:</strong> {{ now()->format('F j, Y \a\t g:i A') }}
                  </td>
                </tr>

              </table>
            </td>
          </tr>

          <!-- Next Steps -->
          <tr>
            <td align="center" style="padding:0 24px 24px 24px;">
              <a href="{{ env('APP_URL') }}"
                style="display:inline-block;text-decoration:none;background:#667eea;border-radius:6px;padding:12px 24px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;color:#ffffff;font-weight:600;">
                Get Started Now
              </a>
            </td>
          </tr>

          <!-- Support Info -->
          <tr>
            <td style="padding:0 24px 24px 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#64748b;text-align:center;">
              Need help getting started? Our support team is here to help!<br>
              📧 <a href="mailto:{{ env('MAILJET_FROM', 'support@company.com') }}" style="color:#667eea;text-decoration:none;">Contact Support</a>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#64748b;border-top:1px solid #e5e7eb;text-align:center;">
              Thanks for choosing <strong>FERP Controller</strong>! 💙<br>
              We can't wait to serve you!<br><br>
              <span style="font-size:11px;color:#94a3b8;">
                © {{ date('Y') }} FERP Controller. All rights reserved.
              </span>
            </td>
          </tr>

        </table>
      </td>
    </tr>
  </table>
</body>

</html>
