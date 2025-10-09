<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome to The Future ERP</title>
</head>

<body style="margin:0;padding:0;background:#f6f7f9;">
    <div style="display:none;max-height:0;overflow:hidden;opacity:0">Welcome aboard! Your workspace is ready.</div>
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:#f6f7f9;">
        <tr>
            <td align="center" style="padding:24px;">
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
                    style="width:100%;max-width:600px;background:#ffffff;border-radius:8px;overflow:hidden;">
                    <tr>
                        <td
                            style="padding:24px 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:20px;line-height:28px;color:#0f172a;font-weight:700;">
                            Welcome to The Future ERP
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:0 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:24px;color:#0f172a;">
                            Hi {{$user_name}},
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:0 24px 8px 24px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:24px;color:#0f172a;">
                            Your workspace <strong>{{$workspace_name}}</strong> is live. Here are a few quick links to
                            get started:
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:4px 24px 0 24px;font-family:Arial,Helvetica,sans-serif;font-size:14px;line-height:22px;color:#334155;">
                            • Dashboard: <a href="{{$dashboard_url}}" style="color:#2563eb;">{{$dashboard_url}}</a><br />
                            • Docs: <a href="{{$docs_url}}" style="color:#2563eb;">{{$docs_url}}</a><br />
                            • Billing: <a href="{{$billing_url}}" style="color:#2563eb;">{{$billing_url}}</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding:16px 24px 8px 24px;">
                            <a href="{{$dashboard_url}}"
                                style="display:inline-block;text-decoration:none;background:#2563eb;border-radius:6px;padding:12px 20px;font-family:Arial,Helvetica,sans-serif;font-size:16px;line-height:20px;color:#ffffff;">Go
                                to Dashboard</a>
                        </td>
                    </tr>
                    <tr>
                        <td
                            style="padding:24px;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#64748b;border-top:1px solid #e5e7eb;">
                            Need help getting started? Reply to this email or visit our help center.
                        </td>
                    </tr>
                </table>
                <table role="presentation" width="600" cellspacing="0" cellpadding="0" border="0"
                    style="width:100%;max-width:600px;">
                    <tr>
                        <td
                            style="padding:12px 24px 0 24px;text-align:center;font-family:Arial,Helvetica,sans-serif;font-size:12px;line-height:18px;color:#94a3b8;">
                            © {{$current_year}} The Future ERP · <a href="{{$preferences_url}}"
                                style="color:#64748b;text-decoration:underline;">Email preferences</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>