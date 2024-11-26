<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Payslip</title>

</head>

<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-size: 18px;
            font-family: "Poppins", sans-serif;
            color: #353f47;
        }

        p {
            margin-top: 4px;
            font-weight: 400;
            font-size: 18px;
        }

        h5 {
            font-size: 20px;
        }

        .container.custom-container {
            max-width: 900px;
            margin: 3rem auto;
        }

        .payslip-para {
            padding-top: 1.8rem;
        }

        .logo img {
            max-height: 150px;
            /* Optional: Set a max-height for the logo on smaller screens */
            width: auto;
            /* Maintain aspect ratio */
        }

        /* Flexbox for header (image and text) */
        .payslip-header {
            margin-bottom: 30px;
        }

        .header-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header-left {
            flex: 1;
        }

        .header-left h1 {
            font-size: 3rem;
            font-weight: 500;
        }

        .header-right {
            flex: 0 0 150px;
            text-align: right;
        }

        /* Employee and Employer Details Section */
        .row {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .employee-description,
        .employer-description {
            width: 48%;
        }

        .employee-description h5,
        .employer-description h5 {
            font-weight: bold;
        }

        .employer-description {
            text-align: right;
        }

        /* Table Styles */
        .payslip-table {
            width: 100%;
            border-collapse: collapse;
        }

        .payslip-table th,
        .payslip-table td {
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: start;
            width: 50%;
        }

        .payslip-table th {
            background-color: #f1f1f1;
        }

        .text-end {
            text-align: end !important;
        }

        .payslip-table th {
            color: #32363a;
        }

        /* Footer Styling */
        .payslip-footer {
            margin-top: 60px;
        }

        .footer-row {
            display: flex;
            align-items: end;
            justify-content: space-between;
        }

        .footer-left,
        .footer-right {
            width: 48%;
        }


        /* System footer */
        .system {
            margin-top: 80px;
            text-align: center;
        }

        /* Responsive Design for Small Screens */
        @media (max-width: 768px) {
            .container.custom-container {
                margin: 3rem 2rem;
            }

            .header-row {
                flex-direction: column;
                text-align: center;
            }

            .header-left,
            .header-right {
                width: 100%;
                margin-bottom: 20px;
            }

            .footer-row {
                flex-direction: column;
                text-align: center;
            }

            .footer-left,
            .footer-right {
                width: 100%;
                margin-bottom: 10px;
            }

            .employee-description,
            .employer-description {
                width: 100%;
            }

            .payslip-table td {
                text-align: left;
            }
        }
    </style>
    <div class="container custom-container my-5">
        <!-- Payslip Header -->
        <div class="payslip-header">
            <div class="header-row">
                <!-- Column for Text Content -->
                <div class="header-left">
                    <h1>Cybertron Labs (Pvt) Ltd</h1>
                    <div class="payslip-para">
                        <p>PS-Syed Anas Tanveer-Apr2024</p>
                        <p>Pay Date : 10/05/2024</p>
                        <p>Pay Period : May 2024</p>
                    </div>
                </div>

                <!-- Column for Logo Image -->
                <div class="header-right">
                    <div class="logo">
                        <img src="images/cybertron-logo.png" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <!-- Employee Details -->
        <div class="row mt-4 mb-3">
            <div class="employee-description">
                <h5 class="">Employee Details</h5>
                <p>Syed Anas Tanveer</p>
                <p>Jr Full stack developer</p>
            </div>
            <div class="employer-description">
                <h5 class="">Employer Details</h5>
                <p>Cybertron Labs (Pvt) Ltd</p>
                <p>A29 KDA Scheme 1 Karsaz Road,</p>
                <p>Karachi, Pakistan.</p>
            </div>
        </div>

        <!-- Payslip Table -->
        <div class="table-responsive">
            <table class="table payslip-table">
                <thead>
                    <tr>
                        <th class="">Earnings</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Pay</td>
                        <td class="text-end">30,000.00</td>
                    </tr>
                    <tr>
                        <td>Travel Allowance</td>
                        <td class="text-end">5,000.00</td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th class="">Deductions</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Tax</td>
                        <td class="text-end">0.00</td>
                    </tr>
                    <tr>
                        <td>Leaves (3)</td>
                        <td class="text-end">4,091.00</td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th class="">Total Pay</th>
                        <th class="text-end">PKR 30,909.00</th>
                    </tr>
                </thead>
                <thead>
                    <tr>
                        <th class="">Total Pay in Words</th>
                        <th class="text-end">
                            Thirty Thousand Nine Hundred Nine PKR
                        </th>
                    </tr>
                </thead>
            </table>
        </div>

        <div class="payslip-footer">
            <div class="footer-row">
                <div class="footer-left">
                    <h5 class="">Payment Details</h5>
                    <p>Payment made to employee's bank account.</p>
                    <p>Employee Signature</p>
                </div>
                <div class="footer-right">
                    <p class="text-end">Employee Signature</p>
                </div>
            </div>
        </div>

        <div class="system mt-5">
            <p>This is a system generated payslip.</p>
        </div>

    </div>
</body>

</html>
