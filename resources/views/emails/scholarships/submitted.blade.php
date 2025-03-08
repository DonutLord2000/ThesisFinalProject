<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Scholarship Application Received</title>
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
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>GRC-MLALAF Scholarship Program</h1>
        </div>
        <div class="content">
            <h2>Application Received</h2>
            <p>Dear Applicant,</p>
            <p>Thank you for submitting your application for the GRC-MLALAF Scholarship Program. We have received your application and it is currently being processed.</p>
            <p>Application Details:</p>
            <ul>
                <li>Application ID: #{{ $application->id }}</li>
                <li>Submitted on: {{ $application->created_at->format('F d, Y') }}</li>
                <li>Status: Pending</li>
            </ul>
            <p>What happens next?</p>
            <p>Our scholarship committee will review your application and supporting documents. You will be notified via email about any updates regarding your application status.</p>
            <p>If you have any questions, please contact our scholarship office at scholarship@grc.edu.ph.</p>
            <p>Thank you for your interest in the GRC-MLALAF Scholarship Program.</p>
            <p>Best regards,<br>GRC-MLALAF Scholarship Committee</p>
        </div>
        <div class="footer">
            <p>This is an automated email. Please do not reply to this message.</p>
            <p>© {{ date('Y') }} GRC-MLALAF Scholarship Program. All rights reserved.</p>
        </div>
    </div>
</body>
</html>

