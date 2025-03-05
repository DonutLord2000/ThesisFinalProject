<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship Application Approved</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background-color: #c00;
            color: #fff;
            padding: 20px;
            text-align: center;
        }
        .content {
            padding: 20px;
            background-color: #f9f9f9;
        }
        .footer {
            text-align: center;
            padding: 20px;
            font-size: 12px;
            color: #666;
        }
        .highlight {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GRC-MLALAF Scholarship Program</h1>
        </div>
        <div class="content">
            <div class="highlight">
                <h2>Congratulations! Your Application is Approved</h2>
            </div>
            <p>Dear Applicant,</p>
            <p>We are pleased to inform you that your application for the GRC-MLALAF Scholarship Program has been <strong>APPROVED</strong>.</p>
            <p>Application Details:</p>
            <ul>
                <li>Application ID: #{{ $application->id }}</li>
                <li>Submitted on: {{ $application->created_at->format('F d, Y') }}</li>
                <li>Status: Approved</li>
            </ul>
            @if($application->admin_notes)
                <p>Additional Notes:</p>
                <p>{{ $application->admin_notes }}</p>
            @endif
            <p>What happens next?</p>
            <p>Our scholarship office will contact you within the next 5 business days with further instructions regarding the next steps, including the scholarship orientation and enrollment procedures.</p>
            <p>If you have any questions, please contact our scholarship office at scholarship@grc.edu.ph.</p>
            <p>Congratulations once again, and welcome to the GRC-MLALAF Scholarship Program!</p>
            <p>Best regards,<br>GRC-MLALAF Scholarship Committee</p>
        </div>
        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>© {{ date('Y') }} GRC-MLALAF Scholarship Program. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

