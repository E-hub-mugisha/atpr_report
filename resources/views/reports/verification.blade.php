<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>RTB | Rwanda TVET Board - Verification Form</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        :root {
            --primary: #0b5ed7;
            /* RTB accent (calm blue) */
            --primary-dark: #0a4db1;
            --text: #1e293b;
            /* Slate-900 */
            --muted: #475569;
            /* Slate-600 */
            --border: #d0d7de;
            /* neutral border */
            --bg: #ffffff;
            --bg-soft: #f8fafc;
            /* soft panel background */
            --table-header: #eef2ff;
            /* subtle indigo tint */
            --success: #0f766e;
            --warning: #b45309;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f2f4f7;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue",
                Arial, "Noto Sans", "Liberation Sans", sans-serif;
            color: var(--text);
            line-height: 1.45;
        }

        .page {
            max-width: 980px;
            margin: 32px auto;
            padding: 0 16px;
        }

        .card {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(16, 24, 40, 0.06);
            overflow: hidden;
        }

        /* Header */
        .header {
            display: grid;
            grid-template-columns: 80px 1fr;
            gap: 16px;
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(0deg, #fff 0%, #f9fafb 100%);
        }

        .logo {
            width: 80px;
            height: 80px;
            border: 2px solid var(--primary);
            border-radius: 10px;
            display: grid;
            place-items: center;
            color: var(--primary);
            font-weight: 700;
            font-size: 14px;
        }

        .title-wrap {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .brand {
            font-weight: 800;
            letter-spacing: 0.2px;
            color: var(--primary-dark);
            font-size: 20px;
            margin-bottom: 4px;
        }

        .subtitle {
            font-weight: 700;
            font-size: 18px;
            color: var(--text);
        }

        .meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 2px;
        }

        /* Sections */
        .section {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border);
            background: var(--bg);
        }

        .section-title {
            font-weight: 700;
            color: var(--text);
            margin-bottom: 12px;
            font-size: 15px;
        }

        /* Definition grid */
        .def-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px 24px;
        }

        .def-row {
            display: grid;
            grid-template-columns: 180px 1fr;
            align-items: center;
            gap: 8px;
            background: var(--bg-soft);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
        }

        .def-label {
            font-weight: 600;
            color: var(--muted);
            font-size: 13px;
        }

        .def-value {
            font-weight: 600;
            color: var(--text);
            font-size: 14px;
        }

        /* Single column def grid for narrow screens */
        @media (max-width: 720px) {
            .def-grid {
                grid-template-columns: 1fr;
            }

            .header {
                grid-template-columns: 60px 1fr;
            }

            .logo {
                width: 60px;
                height: 60px;
            }
        }

        /* Modules list */
        .module-group {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .module-card {
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-soft);
            padding: 12px;
        }

        .module-heading {
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--primary-dark);
            font-size: 14px;
        }

        .module-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            gap: 6px;
        }

        .module-item {
            display: flex;
            gap: 8px;
            align-items: baseline;
            font-size: 13.5px;
        }

        .module-code {
            font-weight: 700;
            color: var(--text);
            min-width: 64px;
        }

        .module-name {
            color: var(--muted);
        }

        /* Table */
        .table-wrap {
            overflow: auto;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            min-width: 920px;
            background: var(--bg);
        }

        thead th {
            background: var(--table-header);
            color: var(--text);
            font-weight: 700;
            font-size: 13px;
            border-bottom: 1px solid var(--border);
            padding: 10px 8px;
            text-align: left;
            white-space: nowrap;
        }

        tbody td {
            border-bottom: 1px solid var(--border);
            padding: 10px 8px;
            font-size: 13.5px;
            color: var(--text);
        }

        tbody tr:nth-child(even) td {
            background: #fafbff;
        }

        .td-center {
            text-align: center;
        }

        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 12px;
            border: 1px solid var(--border);
            background: #fff;
            color: var(--muted);
        }

        .badge-pass {
            color: var(--success);
            border-color: #cde7e5;
            background: #f0fdfa;
        }

        .badge-c {
            color: var(--warning);
            border-color: #fde68a;
            background: #fffbeb;
        }

        .footer {
            padding: 16px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            background: #f9fafb;
        }

        .stamp {
            border: 2px dashed var(--border);
            border-radius: 8px;
            padding: 12px 16px;
            color: var(--muted);
            font-size: 13px;
        }

        .sig-line {
            border-top: 2px solid var(--border);
            width: 240px;
            height: 0;
        }

        .sig-label {
            font-size: 12px;
            color: var(--muted);
            margin-top: 6px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="card">

            <!-- Header -->
            <div class="header">
                <div class="logo">RTB</div>
                <div class="title-wrap">
                    <div class="brand">RTB | Rwanda TVET Board</div>
                    <div class="subtitle">Verification form</div>
                    <div class="meta">Short course program • Transport and Logistics</div>
                </div>
            </div>

            <!-- School details -->
            <div class="section">
                <div class="section-title">School details</div>
                <div class="def-grid">
                    <div class="def-row">
                        <div class="def-label">School name</div>
                        <div class="def-value">ASSOCIATION DES TRANSPORTEURS PRIVÉS AU RWANDA (ATPR)</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">School status</div>
                        <div class="def-value">PRIVATE</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">District / Sector</div>
                        <div class="def-value">Nyarugenge / Muhima</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Address</div>
                        <div class="def-value">ACP (Abahimana Association)</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Phone</div>
                        <div class="def-value">0788160099</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Email</div>
                        <div class="def-value">atprwanda@gmail.com</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">School trade</div>
                        <div class="def-value">Transport and Logistics</div>
                    </div>
                </div>
            </div>

            <!-- Short course program -->
            <div class="section">
                <div class="section-title">Short course program details</div>
                <div class="def-grid">
                    <div class="def-row">
                        <div class="def-label">Course</div>
                        <div class="def-value">TRANSPORTATION LOGISTICS</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Sector</div>
                        <div class="def-value">INZOVU / AGANZE MU RUGENDO RWIZA RUSANGE</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Mode of training</div>
                        <div class="def-value">IBT</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Number of trainees</div>
                        <div class="def-value">3</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Training period</div>
                        <div class="def-value">From 21 October 2024 to 26 January 2025</div>
                    </div>
                    <div class="def-row">
                        <div class="def-label">Trainer's name</div>
                        <div class="def-value">SHEMA OLIVIER</div>
                    </div>
                </div>
            </div>

            <!-- Competencies -->
            <div class="section">
                <div class="section-title">Competencies</div>
                <div class="module-group">
                    <div class="module-card">
                        <div class="module-heading">Complementary modules (CCMs) and general modules</div>
                        <ul class="module-list">
                            <li class="module-item">
                                <span class="module-code">CCL01</span>
                                <span class="module-name">Basic English</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">CCL02</span>
                                <span class="module-name">Basic French</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">CCL03</span>
                                <span class="module-name">Basic Kiswahili</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">CCL04</span>
                                <span class="module-name">Entrepreneurship</span>
                            </li>
                        </ul>
                    </div>
                    <div class="module-card">
                        <div class="module-heading">Specific modules</div>
                        <ul class="module-list">
                            <li class="module-item">
                                <span class="module-code">TLG01</span>
                                <span class="module-name">Introduction to Transport and Logistics</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">TLG02</span>
                                <span class="module-name">Transport and Logistics Operations</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">TLG03</span>
                                <span class="module-name">Transport and Logistics Planning</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">TLG04</span>
                                <span class="module-name">Transport and Logistics Documentation</span>
                            </li>
                            <li class="module-item">
                                <span class="module-code">TLG05</span>
                                <span class="module-name">Transport and Logistics Safety and Security</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Assessment results -->
            <div class="section">
                <div class="section-title">Assessment results</div>

                <div class="table-wrap">
                    <table aria-label="Assessment results">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Trainee's names</th>
                                <th>Attendance</th>
                                <th>CCMs</th>
                                <th>CCL01</th>
                                <th>CCL02</th>
                                <th>CCL03</th>
                                <th>CCL04</th>
                                <th>TLG01</th>
                                <th>TLG02</th>
                                <th>TLG03</th>
                                <th>TLG04</th>
                                <th>TLG05</th>
                                <th>Average (%)</th>
                                <th>Decision</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="td-center">1</td>
                                <td>AKINGENEYE Jean Paul</td>
                                <td><span class="badge badge-pass">Yes</span></td>
                                <td class="td-center">70</td>
                                <td class="td-center">72</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center"><strong>70.2</strong></td>
                                <td><span class="badge badge-c">C</span></td>
                            </tr>
                            <tr>
                                <td class="td-center">2</td>
                                <td>AMERIKA Abrahama</td>
                                <td><span class="badge badge-pass">Yes</span></td>
                                <td class="td-center">72</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center"><strong>70.2</strong></td>
                                <td><span class="badge badge-c">C</span></td>
                            </tr>
                            <tr>
                                <td class="td-center">3</td>
                                <td>BIRIMANA Jean Felix</td>
                                <td><span class="badge badge-pass">Yes</span></td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center">70</td>
                                <td class="td-center"><strong>70.0</strong></td>
                                <td><span class="badge badge-c">C</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="footer">
                <div class="stamp">Official stamp / RTB validation</div>
                <div>
                    <div class="sig-line"></div>
                    <div class="sig-label">Signature and date</div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>