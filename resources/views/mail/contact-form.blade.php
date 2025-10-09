<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>New Contact Form Submission</title>
</head>

<body style="margin:0;padding:0;background:#f6f7f9;">
  <!-- Preheader (hidden) -->
  <div style="display:none;max-height:0;overflow:hidden;opacity:0">New contact form submission from {{ $contactData['name'] ?? 'Website Visitor' }}</div>

  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f6f7f9;">
    <tr>
      <td align="center" style="padding:24px;">
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
          style="width:100%;max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;">

          <!-- Header -->
          <tr>
            <td style="padding:24px 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:28px;color:#0f172a;font-weight:700;text-align:center;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#ffffff;">
              📧 New Contact Form Submission
            </td>
          </tr>

          <tr>
            <td style="padding:16px 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#64748b;text-align:center;background:linear-gradient(135deg, #667eea 0%, #764ba2 100%);color:#ffffff;opacity:0.9;">
              FERP Controller - Contact Form
            </td>
          </tr>

          <!-- Contact Information -->
          <tr>
            <td style="padding:24px 24px 16px 24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td style="padding:0 0 16px 0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:24px;color:#0f172a;font-weight:600;">
                    👤 Contact Information
                  </td>
                </tr>
              </table>

              <!-- Contact Details -->
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                style="background:#f8f9fa;border-left:4px solid #667eea;border-radius:0 5px 5px 0;padding:15px;">

                <tr>
                  <td style="padding:8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;">
                    <strong style="color:#495057;min-width:80px;display:inline-block;">Name:</strong>
                    <span style="color:#212529;">{{ $contactData['name'] ?? 'Not provided' }}</span>
                  </td>
                </tr>

                <tr>
                  <td style="padding:8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;">
                    <strong style="color:#495057;min-width:80px;display:inline-block;">Email:</strong>
                    <a href="mailto:{{ $contactData['email'] ?? '' }}" style="color:#667eea;text-decoration:none;">
                      {{ $contactData['email'] ?? 'Not provided' }}
                    </a>
                  </td>
                </tr>

                @if(!empty($contactData['phone']))
                <tr>
                  <td style="padding:8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;">
                    <strong style="color:#495057;min-width:80px;display:inline-block;">Phone:</strong>
                    <a href="tel:{{ $contactData['phone'] }}" style="color:#667eea;text-decoration:none;">
                      {{ $contactData['phone'] }}
                    </a>
                  </td>
                </tr>
                @endif

                <tr>
                  <td style="padding:8px 0;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;">
                    <strong style="color:#495057;min-width:80px;display:inline-block;">Subject:</strong>
                    <span style="color:#212529;">{{ $contactData['subject'] ?? 'No subject' }}</span>
                  </td>
                </tr>

              </table>
            </td>
          </tr>

          <!-- Message Section -->
          <tr>
            <td style="padding:0 24px 24px 24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0">
                <tr>
                  <td style="padding:0 0 16px 0;font-family:Arial,Helvetica,sans-serif;font-size:18px;line-height:24px;color:#0f172a;font-weight:600;">
                    💬 Message
                  </td>
                </tr>
              </table>

              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                style="background:#ffffff;border:1px solid #dee2e6;border-radius:5px;padding:20px;">
                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#212529;white-space:pre-wrap;">{{ $contactData['details'] ?? 'No message provided.' }}</td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Timestamp -->
          <tr>
            <td style="padding:0 24px 24px 24px;">
              <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0"
                style="background:#e9ecef;border-radius:5px;padding:15px;">
                <tr>
                  <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:20px;color:#495057;text-align:center;">
                    <strong>📅 Received:</strong> {{ now()->format('F j, Y \a\t g:i A T') }}
                  </td>
                </tr>
              </table>
            </td>
          </tr>

          <!-- Footer -->
          <tr>
            <td style="padding:24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#64748b;border-top:1px solid #e5e7eb;text-align:center;">
              <strong>FERP Controller</strong> - Contact Management System<br>
              <span style="font-size:11px;color:#adb5bd;">
                This email was automatically generated from the contact form on your website.<br>
                Please respond directly to the sender's email address above.
              </span>
            </td>
          </tr>

        </table>

        <!-- Footer Links -->
        <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
          style="width:100%;max-width:600px;">
          <tr>
            <td style="padding:12px 24px 0 24px;text-align:center;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#94a3b8;">
              © {{ date('Y') }} FERP Controller.
              <a href="mailto:{{ env('MAILJET_FROM', 'support@company.com') }}" style="color:#64748b;text-decoration:underline;">
                Need help?
              </a>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>

</html>
