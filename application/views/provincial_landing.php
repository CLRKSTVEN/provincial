<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    :root {
        --bg-gradient: radial-gradient(circle at top left, #dbeafe 0, transparent 55%),
            radial-gradient(circle at bottom right, #fee2e2 0, transparent 55%),
            linear-gradient(135deg, #eff6ff 0%, #f9fafb 50%, #fefce8 100%);
        --card-bg: #ffffff;
        --card-border: #e2e8f0;
        --accent: #2563eb;
        --accent-soft: #eff6ff;
        --muted: #6b7280;
        --text-main: #111827;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--app-font);
        background: var(--bg-gradient);
        color: var(--text-main);
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
        -webkit-font-smoothing: antialiased;
    }

    /* Subtle animated soft blobs */
    body::before,
    body::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        opacity: 0.35;
        filter: blur(18px);
        z-index: 0;
        pointer-events: none;
        animation: glowFloat 26s ease-in-out infinite;
    }

    body::before {
        width: 520px;
        height: 520px;
        background: radial-gradient(circle, #bfdbfe 0, transparent 70%);
        top: -180px;
        right: -200px;
    }

    body::after {
        width: 420px;
        height: 420px;
        background: radial-gradient(circle, #fed7aa 0, transparent 70%);
        bottom: -150px;
        left: -200px;
        animation-delay: -11s;
    }

    @keyframes glowFloat {

        0%,
        100% {
            transform: translate3d(0, 0, 0) scale(1);
        }

        33% {
            transform: translate3d(24px, -18px, 0) scale(1.05);
        }

        66% {
            transform: translate3d(-18px, 18px, 0) scale(0.97);
        }
    }

    .landing-page-wrapper {
        min-height: 100vh;
        padding: 18px 12px;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: flex-start;
        justify-content: center;
    }

    .landing-card {
        min-height: auto;
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .landing-card-inner {
        flex: 0 0 auto;
        max-width: 1180px;
        margin: 0 auto;
        width: 100%;
        padding: 18px 18px 20px;
        border-radius: 20px;
        border: 1px solid var(--card-border);
        background: radial-gradient(circle at top left, #ffffff 0, #f8fafc 40%, #f9fafb 100%);
        box-shadow:
            0 14px 36px rgba(148, 163, 184, 0.28),
            0 0 0 1px rgba(226, 232, 240, 0.9);
        position: relative;
        overflow: hidden;
    }

    .landing-card-inner::before {
        content: 'LIVE BOARD';
        position: absolute;
        right: 40px;
        top: 30px;
        font-size: 0.7rem;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: #9ca3af;
        font-weight: 700;
        pointer-events: none;
    }

    /* Header Section */
    .landing-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 16px;
        margin-bottom: 14px;
        animation: headerDrop 0.4s ease-out;
        border-bottom: 1px solid #e5e7eb;
        padding-bottom: 10px;
    }

    @keyframes headerDrop {
        from {
            opacity: 0;
            transform: translateY(-14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .landing-title h4 {
        font-size: 0.82rem;
        font-weight: 700;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: #2563eb;
        margin-bottom: 6px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .landing-title h4::before {
        content: '🏆';
        font-size: 1.2rem;
    }


    .landing-title h2 {
        font-size: 1.85rem;
        font-weight: 900;
        color: #0f172a;
        margin-bottom: 6px;
        letter-spacing: -0.03em;
        line-height: 1.05;
    }

    .landing-title small {
        color: var(--muted);
        font-size: 0.88rem;
        line-height: 1.5;
        display: block;
        max-width: 500px;
    }

    .landing-actions {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    /* Group Pills – segmented control */
    .group-pills {
        display: inline-flex;
        gap: 0;
        align-items: stretch;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        background: #f9fafb;
        box-shadow: 0 8px 18px rgba(148, 163, 184, 0.25);
        overflow: hidden;
    }

    .group-pills .btn {
        border-radius: 0;
        border: 0;
        padding: 5px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        position: relative;
        color: #6b7280;
        background: transparent;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 74px;
        transition: all 0.18s ease;
    }

    .group-pills .btn+.btn {
        border-left: 1px solid #e5e7eb;
    }

    .group-pills .btn-outline-primary {
        box-shadow: none;
    }

    .group-pills .btn-outline-primary:hover {
        color: #111827;
        background: #edf2ff;
    }

    .group-pills .btn-primary {
        color: #ffffff;
        background: linear-gradient(135deg, #2563eb, #4f46e5);
        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.4),
            0 12px 24px rgba(37, 99, 235, 0.55);
    }

    .group-pills .btn-primary:hover {
        filter: brightness(1.04);
    }

    .login-btn {
        padding: 7px 14px;
        font-size: 0.8rem;
        font-weight: 700;
        border-radius: 999px;
        border: 1px solid #d1d5db;
        background: #ffffff;
        color: #111827;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 8px 18px rgba(156, 163, 175, 0.35);
        transition: all 0.18s ease;
        white-space: nowrap;
        position: relative;
        overflow: hidden;
    }

    .login-btn::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(circle at top left, rgba(37, 99, 235, 0.15), transparent 60%);
        opacity: 0;
        transition: opacity 0.25s ease;
    }

    .login-btn:hover {
        color: #1d4ed8;
        border-color: #2563eb;
        transform: translateY(-1px);
        box-shadow:
            0 0 0 1px rgba(37, 99, 235, 0.35),
            0 16px 26px rgba(148, 163, 184, 0.5);
    }

    .login-btn:hover::before {
        opacity: 1;
    }

    /* Summary Row */
    .summary-row {
        margin-bottom: 14px;
        margin-top: 4px;
        animation: summaryFade 0.4s ease-out 0.05s both;
    }

    @keyframes summaryFade {
        from {
            opacity: 0;
            transform: translateY(12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .summary-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 12px 14px;
        border: 1px solid #e2e8f0;
        transition: all 0.22s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        box-shadow:
            0 12px 24px rgba(148, 163, 184, 0.25),
            0 0 0 1px rgba(226, 232, 240, 0.85);
    }

    .summary-card.clickable {
        cursor: pointer;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        inset: -40%;
        background:
            radial-gradient(circle at top left, rgba(191, 219, 254, 0.4), transparent 55%),
            radial-gradient(circle at bottom right, rgba(254, 243, 199, 0.4), transparent 55%);
        opacity: 0;
        transition: opacity 0.25s ease;
        pointer-events: none;
    }

    .summary-card:hover {
        transform: translateY(-2px) translateZ(0);
        box-shadow:
            0 20px 40px rgba(148, 163, 184, 0.4),
            0 0 0 1px rgba(59, 130, 246, 0.35);
        border-color: rgba(59, 130, 246, 0.6);
    }

    .summary-card:hover::before {
        opacity: 1;
    }

    .summary-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.18em;
        color: #9ca3af;
        margin-bottom: 6px;
        font-weight: 700;
    }

    .summary-value {
        font-size: 1.6rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 2px;
        line-height: 1.08;
        display: flex;
        align-items: baseline;
        gap: 8px;
        flex-wrap: wrap;
    }

    .summary-sub {
        font-size: 0.85rem;
        color: var(--muted);
        line-height: 1.4;
    }

    /* Winners Table Wrapper */
    .winners-table-wrapper {
        background: #ffffff;
        border-radius: 18px;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        flex: 1;
        display: flex;
        flex-direction: column;
        box-shadow:
            0 18px 36px rgba(148, 163, 184, 0.32),
            0 0 0 1px rgba(226, 232, 240, 0.9);
        animation: tableReveal 0.4s ease-out 0.1s both;
        margin-top: 2px;
    }

    @keyframes tableReveal {
        from {
            opacity: 0;
            transform: translateY(14px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .winners-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 14px;
        background: linear-gradient(to right, #eff6ff, #f9fafb);
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
    }

    .winners-toolbar-left {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .winners-heading {
        margin: 0;
        font-size: 0.95rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #111827;
    }

    .winners-subtext {
        margin: 0;
        color: var(--muted);
        font-size: 0.8rem;
    }

    .winners-actions {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 5px 10px;
        border-radius: 999px;
        border: 1px solid #e5e7eb;
        font-size: 0.78rem;
        font-weight: 600;
        color: #111827;
        background: #ffffff;
        box-shadow: 0 4px 10px rgba(148, 163, 184, 0.2);
    }

    .filter-chip-primary {
        border-color: rgba(37, 99, 235, 0.4);
        background: #e0edff;
        color: #1d4ed8;
    }

    .filter-chip-accent {
        border-color: rgba(56, 189, 248, 0.5);
        background: #e0f2fe;
        color: #0369a1;
    }

    .filter-chip-muted {
        border-color: #e5e7eb;
        color: var(--muted);
        background: #f9fafb;
    }

    .clear-filter-btn {
        border-radius: 999px;
        font-weight: 600;
        padding: 6px 14px;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.14em;
    }

    .table-responsive {
        flex: 1;
        overflow-y: auto;
    }

    .winners-table {
        margin: 0;
        width: 100%;
        border-collapse: collapse;
    }

    .winners-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .winners-table thead th {
        background: linear-gradient(to bottom, #f3f4f6 0%, #e5e7eb 100%);
        font-size: 0.72rem;
        text-transform: uppercase;
        letter-spacing: 0.16em;
        font-weight: 700;
        color: #4b5563;
        border-bottom: 1px solid #e5e7eb;
        padding: 9px 10px;
        white-space: nowrap;
        border-top: none;
        position: relative;
    }

    .winners-table thead th::after {
        content: '';
        position: absolute;
        left: 12px;
        right: 12px;
        bottom: 2px;
        height: 1px;
        background: linear-gradient(to right, transparent, rgba(209, 213, 219, 0.9), transparent);
        opacity: 0.8;
    }

    .winners-table tbody tr {
        background: #ffffff;
        transition: background-color 0.16s ease, transform 0.08s ease;
    }

    .winners-table tbody td {
        padding: 9px 10px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.88rem;
        color: #111827;
    }

    .winners-table tbody tr:hover {
        background: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 10px 24px rgba(148, 163, 184, 0.45);
    }

    .winners-table tbody tr:last-child td {
        border-bottom: none;
    }

    .winners-table tbody tr.no-results-row,
    .winners-table tbody tr.no-results-row:hover {
        background: #ffffff;
        box-shadow: none;
        transform: none;
    }

    /* Medal Chips – light theme */
    .chip-medal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 6px 14px;
        border-radius: 999px;
        font-size: 0.68rem;
        font-weight: 900;
        letter-spacing: 0.16em;
        text-transform: uppercase;
        border: 2px solid;
        min-width: 86px;
        transition: all 0.2s ease;
        box-shadow:
            0 0 0 1px rgba(148, 163, 184, 0.3),
            0 8px 18px rgba(148, 163, 184, 0.35);
    }

    .chip-medal:hover {
        transform: translateY(-1px) scale(1.02);
        box-shadow:
            0 0 0 1px rgba(148, 163, 184, 0.5),
            0 14px 30px rgba(148, 163, 184, 0.55);
    }

    .chip-gold {
        background: linear-gradient(135deg, #fef3c7, #fde68a);
        color: #78350f;
        border-color: #f59e0b;
        box-shadow:
            0 0 18px rgba(251, 191, 36, 0.4),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    .chip-silver {
        background: linear-gradient(135deg, #f9fafb, #e5e7eb);
        color: #374151;
        border-color: #9ca3af;
        box-shadow:
            0 0 18px rgba(156, 163, 175, 0.35),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    .chip-bronze {
        background: linear-gradient(135deg, #fed7aa, #fdba74);
        color: #7c2d12;
        border-color: #f97316;
        box-shadow:
            0 0 18px rgba(248, 153, 82, 0.45),
            0 0 0 1px rgba(248, 250, 252, 1);
    }

    /* Footer */
    .footer-note {
        margin-top: 12px;
        padding-top: 10px;
        border-top: 1px dashed #e5e7eb;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        font-size: 0.78rem;
        color: var(--muted);
        font-weight: 500;
        gap: 8px;
        flex-wrap: wrap;
    }

    .footer-note span {
        text-align: right;
    }

    /* Municipality picker + modal table – light styling */
    .municipality-picker {
        background: #f9fafb;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 12px;
    }

    .municipality-picker-label {
        font-weight: 700;
        color: #111827;
        margin-bottom: 6px;
        display: block;
        font-size: 0.86rem;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .municipality-picker-row {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
        align-items: center;
    }

    .municipality-picker select {
        min-width: 220px;
        background-color: #ffffff;
        border-color: #d1d5db;
        color: #111827;
    }

    .municipality-picker select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 1px rgba(37, 99, 235, 0.5);
    }

    .municipality-empty {
        text-align: center;
        color: var(--muted);
        padding: 10px 0;
    }

    /* Modal light theme */
    .modal-content {
        background: #ffffff;
        color: #111827;
        border-radius: 16px;
        border: 1px solid #e5e7eb;
        box-shadow:
            0 26px 70px rgba(148, 163, 184, 0.6),
            0 0 0 1px rgba(226, 232, 240, 0.9);
    }

    .modal-header {
        border-bottom-color: #e5e7eb;
        background: #f9fafb;
    }

    .modal-title {
        font-size: 0.95rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: #111827;
    }

    .modal-body {
        background: #ffffff;
    }

    .modal-footer {
        border-top-color: #e5e7eb;
        background: #f9fafb;
    }

    .modal .table thead th {
        background: #f3f4f6;
        border-bottom-color: #e5e7eb;
        color: #4b5563;
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
    }

    .modal .table tbody td {
        border-bottom-color: #e5e7eb;
        color: #111827;
        font-size: 0.9rem;
    }

    .modal .btn-light {
        background-color: #ffffff;
        border-color: #e5e7eb;
        color: #111827;
    }

    .modal .btn-light:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }

    /* Loader – soft light overlay */
    .loader-wrapper {
        position: fixed;
        inset: 0;
        z-index: 50;
        background: radial-gradient(circle at top left, #dbeafe 0, #eff6ff 40%, #f9fafb 100%);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .loader {
        position: relative;
        width: 120px;
        height: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .loader-bar {
        width: 14px;
        height: 14px;
        border-radius: 999px;
        background: linear-gradient(135deg, #60a5fa, #4f46e5);
        box-shadow: 0 0 10px rgba(96, 165, 250, 0.85);
        animation: pulseBars 0.9s infinite ease-in-out;
    }

    .loader-bar:nth-child(2) {
        animation-delay: 0.08s;
    }

    .loader-bar:nth-child(3) {
        animation-delay: 0.16s;
    }

    .loader-bar:nth-child(4) {
        animation-delay: 0.24s;
    }

    .loader-bar:nth-child(5) {
        animation-delay: 0.32s;
    }

    .loader-ball {
        position: absolute;
        left: 0;
        width: 14px;
        height: 14px;
        border-radius: 999px;
        background: radial-gradient(circle at top left, #fb923c, #facc15);
        box-shadow: 0 0 12px rgba(251, 146, 60, 0.9);
        animation: slideBall 1.2s infinite cubic-bezier(0.55, 0.15, 0.35, 0.85);
    }

    @keyframes pulseBars {

        0%,
        100% {
            transform: translateY(0) scale(0.9);
            opacity: 0.4;
        }

        40% {
            transform: translateY(-6px) scale(1.1);
            opacity: 1;
        }
    }

    @keyframes slideBall {
        0% {
            transform: translateX(0);
        }

        50% {
            transform: translateX(106px);
        }

        100% {
            transform: translateX(0);
        }
    }

    /* Responsive adjustments */
    @media (max-width: 991.98px) {
        .landing-page-wrapper {
            padding: 18px 10px;
        }

        .landing-card-inner {
            padding: 20px 18px 20px;
        }

        .landing-header {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 18px;
        }

        .landing-title h2 {
            font-size: 1.9rem;
        }

        .group-pills {
            width: 100%;
            justify-content: space-between;
        }

        .group-pills .btn {
            flex: 1;
            min-width: 0;
        }

        .summary-value {
            font-size: 1.7rem;
        }

        .winners-table thead th {
            font-size: 0.7rem;
            padding-inline: 10px;
        }

        .winners-table tbody td {
            padding-inline: 10px;
            font-size: 0.85rem;
        }

        .winners-toolbar {
            align-items: flex-start;
        }

        .winners-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .landing-card-inner::before {
            right: 22px;
            top: 20px;
        }

        .footer-note {
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .landing-card-inner {
            padding-inline: 14px;
        }

        .landing-title h2 {
            font-size: 1.6rem;
        }

        .landing-title small {
            font-size: 0.85rem;
        }

        .landing-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .group-pills {
            order: 1;
        }

        .login-btn {
            width: 100%;
            justify-content: center;
        }

        .chip-medal {
            min-width: 78px;
            padding-inline: 16px;
            font-size: 0.68rem;
        }

        .winners-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .winners-actions .clear-filter-btn {
            width: 100%;
            text-align: center;
        }

        .landing-card-inner::before {
            display: none;
        }
    }
</style>

<body>

    <!-- Loader -->
    <div class="loader-wrapper">
        <div class="loader">
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-bar"></div>
            <div class="loader-ball"></div>
        </div>
    </div>

    <section class="landing-page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 landing-card">
                    <div class="landing-card-inner">

                        <!-- Header -->
                        <div class="landing-header">
                            <div class="landing-title">
                                <?php
                                $meet_title = isset($meet->meet_title) ? $meet->meet_title : 'Provincial Meet';
                                $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : '';
                                $subtitle   = isset($meet->subtitle)
                                    ? $meet->subtitle
                                    : 'Official summary of results based on reports from event committees.';
                                $isLoggedIn = isset($this) && isset($this->session) ? (bool)$this->session->userdata('logged_in') : false;
                                $loginUrl   = $isLoggedIn ? site_url('provincial/admin') : site_url('login');
                                $loginText  = $isLoggedIn ? 'Admin Dashboard' : 'Login';
                                ?>
                                <h4><?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?></h4>
                                <h2>Official Results Board</h2>
                                <small>
                                    <?= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?>
                                </small>
                            </div>

                            <div class="landing-actions">
                                <div class="group-pills">
                                    <?php $group = isset($active_group) ? $active_group : 'ALL'; ?>
                                    <a href="<?= site_url(); ?>"
                                        class="btn btn-sm <?= $group === 'ALL' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        All
                                    </a>
                                    <a href="<?= site_url('?group=Elementary'); ?>"
                                        class="btn btn-sm <?= $group === 'Elementary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        Elementary
                                    </a>
                                    <a href="<?= site_url('?group=Secondary'); ?>"
                                        class="btn btn-sm <?= $group === 'Secondary' ? 'btn-primary' : 'btn-outline-primary'; ?>">
                                        Secondary
                                    </a>
                                </div>
                                <a href="<?= $loginUrl; ?>" class="login-btn" title="Admin">
                                    <?= $loginText; ?>
                                </a>
                            </div>
                        </div>

                        <!-- Summary row -->
                        <?php
                        $overview       = isset($overview) ? $overview : null;
                        $activeMunicipality = isset($active_municipality) ? $active_municipality : '';
                        $municipalities = $overview ? (int)$overview->municipalities : 0;
                        $events         = $overview ? (int)$overview->events : 0;
                        $goldTotal      = $overview ? (int)$overview->gold : 0;
                        $silverTotal    = $overview ? (int)$overview->silver : 0;
                        $bronzeTotal    = $overview ? (int)$overview->bronze : 0;
                        $totalMedals    = $overview ? (int)$overview->total_medals : 0;
                        $lastUpdate     = ($overview && $overview->last_update)
                            ? date('M d, Y h:i A', strtotime($overview->last_update))
                            : 'No data yet';
                        ?>
                        <div class="row summary-row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="summary-card clickable" id="municipalityCard"
                                    data-toggle="modal" data-target="#municipalityModal"
                                    data-bs-toggle="modal" data-bs-target="#municipalityModal"
                                    role="button" tabindex="0">
                                    <div class="summary-label">Participating Municipalities</div>
                                    <div class="summary-value" id="stat-municipalities"><?= $municipalities; ?></div>
                                    <div class="summary-sub">with at least one officially recorded medal</div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="summary-card">
                                    <div class="summary-label">Events Recorded</div>
                                    <div class="summary-value" id="stat-events"><?= $events; ?></div>
                                    <div class="summary-sub">completed with reported winners</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="summary-card">
                                    <div class="summary-label">Total Medals</div>
                                    <div class="summary-value">
                                        <span id="stat-total-medals"><?= $totalMedals; ?></span>
                                        <span id="stat-medal-breakdown"
                                            style="font-size:0.9rem;font-weight:700;color:#2563eb;">
                                            (<?= $goldTotal; ?>G · <?= $silverTotal; ?>S · <?= $bronzeTotal; ?>B)
                                        </span>
                                    </div>
                                    <div class="summary-sub">
                                        Last update:
                                        <span id="stat-last-update"><?= $lastUpdate; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Winners Table -->
                        <div class="winners-table-wrapper">
                            <div class="winners-toolbar">
                                <div class="winners-toolbar-left">
                                    <h5 class="winners-heading">Winners Table</h5>
                                    <p class="winners-subtext mb-0">Live medal board (auto-refreshes every 30s).</p>
                                </div>
                                <div class="winners-actions">
                                    <span class="filter-chip <?= $group === 'ALL' ? 'filter-chip-muted' : 'filter-chip-primary'; ?>">
                                        <?= $group === 'ALL'
                                            ? 'Group: All'
                                            : 'Group: ' . htmlspecialchars($group, ENT_QUOTES, 'UTF-8'); ?>
                                    </span>
                                    <?php if (!empty($activeMunicipality)): ?>
                                        <span class="filter-chip filter-chip-accent">
                                            Municipality: <?= htmlspecialchars($activeMunicipality, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                        <a href="<?= site_url('provincial' . ($group !== 'ALL' ? '?group=' . urlencode($group) : '')); ?>"
                                            class="btn btn-sm btn-outline-danger clear-filter-btn">
                                            Clear filter
                                        </a>
                                    <?php else: ?>
                                        <span class="filter-chip filter-chip-muted">
                                            Municipality: All
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm table-hover mb-0 winners-table">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Group</th>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th class="text-center">Medal</th>
                                            <th>Municipality</th>
                                        </tr>
                                    </thead>
                                    <tbody id="winners-body">
                                        <?php $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array(); ?>
                                        <?php if (!empty($winners)): ?>
                                            <?php foreach ($winners as $row): ?>
                                                <tr>
                                                    <td class="align-middle">
                                                        <?= htmlspecialchars($row->event_name, ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                    <td class="align-middle" style="white-space: nowrap;">
                                                        <?= htmlspecialchars($row->event_group, ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                    <td class="align-middle" style="white-space: nowrap;">
                                                        <?= htmlspecialchars($row->category ?? '-', ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?= htmlspecialchars($row->full_name, ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                    <td class="align-middle text-center">
                                                        <?php
                                                        $medal = $row->medal;
                                                        $chipClass = 'chip-silver';
                                                        if ($medal === 'Gold') {
                                                            $chipClass = 'chip-gold';
                                                        } elseif ($medal === 'Bronze') {
                                                            $chipClass = 'chip-bronze';
                                                        }
                                                        ?>
                                                        <span class="chip-medal <?= $chipClass; ?>">
                                                            <?= htmlspecialchars($medal, ENT_QUOTES, 'UTF-8'); ?>
                                                        </span>
                                                    </td>
                                                    <td class="align-middle">
                                                        <?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <?php if (!empty($allMunicipalities)): ?>
                                                <?php foreach ($allMunicipalities as $mRow): ?>
                                                    <?php $mName = $mRow->municipality; ?>
                                                    <tr class="no-results-row">
                                                        <td class="align-middle text-muted">—</td>
                                                        <td class="align-middle text-muted">—</td>
                                                        <td class="align-middle text-muted">—</td>
                                                        <td class="align-middle text-muted">No winners posted yet</td>
                                                        <td class="align-middle text-center text-muted">—</td>
                                                        <td class="align-middle">
                                                            <?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <tr class="no-results-row">
                                                    <td colspan="6" class="text-center py-5"
                                                        style="color: #9ca3af; font-size: 1.05rem;">
                                                        🏅 No results are available yet. Please wait for the organizers to
                                                        post the official list of winners.
                                                    </td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="footer-note">
                            <span>
                                For questions or clarification on these results, please coordinate with the Meet Coordinator.
                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Participating Municipalities Modal -->
    <?php
    $tally = isset($municipality_tally) ? $municipality_tally : array();
    $allMunicipalities = isset($municipalities_all) ? $municipalities_all : array();
    $groupContext = isset($active_group) ? $active_group : 'ALL';
    $baseUrl = site_url('provincial');
    $groupQuery = ($groupContext === 'Elementary' || $groupContext === 'Secondary')
        ? '&group=' . urlencode($groupContext)
        : '';
    $tallyMap = array();
    $normalizeName = function ($name) {
        return strtolower(trim((string) $name));
    };
    foreach ($tally as $row) {
        $key = $normalizeName(isset($row->municipality) ? $row->municipality : '');
        if ($key === '') {
            continue;
        }
        $tallyMap[$key] = $row;
    }
    // Order municipalities by medal tally (gold > silver > bronze) and place those with no data after
    $sortedMunicipalities = is_array($allMunicipalities) ? $allMunicipalities : array();
    if (!empty($sortedMunicipalities)) {
        usort($sortedMunicipalities, function ($a, $b) use ($tallyMap, $normalizeName) {
            $aName = isset($a->municipality) ? trim($a->municipality) : '';
            $bName = isset($b->municipality) ? trim($b->municipality) : '';

            $aKey = $normalizeName($aName);
            $bKey = $normalizeName($bName);

            $aStats = isset($tallyMap[$aKey]) ? $tallyMap[$aKey] : null;
            $bStats = isset($tallyMap[$bKey]) ? $tallyMap[$bKey] : null;

            if ($aStats && $bStats) {
                $goldDiff = (int) $bStats->gold - (int) $aStats->gold;
                if ($goldDiff !== 0) {
                    return $goldDiff;
                }
                $silverDiff = (int) $bStats->silver - (int) $aStats->silver;
                if ($silverDiff !== 0) {
                    return $silverDiff;
                }
                $bronzeDiff = (int) $bStats->bronze - (int) $aStats->bronze;
                if ($bronzeDiff !== 0) {
                    return $bronzeDiff;
                }
            } elseif ($aStats && !$bStats) {
                return -1;
            } elseif (!$aStats && $bStats) {
                return 1;
            }

            return strcasecmp($aName, $bName);
        });
    }
    ?>
    <div class="modal fade" id="municipalityModal" tabindex="-1" role="dialog" aria-labelledby="municipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="municipalityModalLabel">Participating Municipalities</h5>
                    <button type="button" class="close text-dark" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true" style="font-size:1.4rem;">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <?php if (!empty($allMunicipalities)): ?>
                        <div class="municipality-picker" id="municipalityPicker"
                            data-base-url="<?= $baseUrl; ?>" data-group-query="<?= $groupQuery; ?>">
                            <span class="municipality-picker-label">Jump to a municipal dashboard</span>
                            <div class="municipality-picker-row">
                                <select class="form-control form-control-sm" id="municipalitySelect">
                                    <option value="">Select municipality</option>
                                    <?php foreach ($allMunicipalities as $row): ?>
                                        <option value="<?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>">
                                            <?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-primary btn-sm" id="municipalityViewButton">
                                    View dashboard
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>Municipality</th>
                                        <th class="text-center">Gold</th>
                                        <th class="text-center">Silver</th>
                                        <th class="text-center">Bronze</th>
                                        <th class="text-center">Total</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($sortedMunicipalities as $row): ?>
                                        <?php
                                        $mName = $row->municipality;
                                        $mKey = $normalizeName($mName);
                                        $stats = isset($tallyMap[$mKey]) ? $tallyMap[$mKey] : null;
                                        $hasData = $stats && ((int) $stats->total_medals > 0 || (int) $stats->gold > 0 || (int) $stats->silver > 0 || (int) $stats->bronze > 0);
                                        $filterUrl = $baseUrl . '?municipality=' . urlencode($mName) . $groupQuery;
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($mName, ENT_QUOTES, 'UTF-8'); ?></td>
                                            <td class="text-center"><strong><?= $hasData ? (int) $stats->gold : '—'; ?></strong></td>
                                            <td class="text-center"><strong><?= $hasData ? (int) $stats->silver : '—'; ?></strong></td>
                                            <td class="text-center"><strong><?= $hasData ? (int) $stats->bronze : '—'; ?></strong></td>
                                            <td class="text-center"><?= $hasData ? (int) $stats->total_medals : '—'; ?></td>
                                            <td class="text-right">
                                                <?php if ($hasData): ?>
                                                    <a href="<?= $filterUrl; ?>" class="btn btn-sm btn-outline-primary">
                                                        View dashboard
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted small">No data yet</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center text-muted py-3">No municipalities recorded yet.</div>
                    <?php endif; ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- JS -->
    <script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
    <script>
        window.jQuery || document.write('<script src="https://code.jquery.com/jquery-3.6.0.min.js"><\\/script>');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        window.ALL_MUNICIPALITIES = <?= json_encode(array_values(array_map(function ($mun) {
                                        return isset($mun->municipality) ? trim($mun->municipality) : '';
                                    }, isset($sortedMunicipalities) && is_array($sortedMunicipalities) ? $sortedMunicipalities : array()))); ?>;
        (function($, bootstrap) {
            if (!$) {
                console.error('jQuery did not load; municipal modal and live updates are disabled.');
                return;
            }

            function normalizeKey(val) {
                return (val || '').trim().toLowerCase();
            }

            function formatDateTime(dtString) {
                if (!dtString) return 'No data yet';
                var d = new Date(dtString.replace(' ', 'T'));
                if (isNaN(d.getTime())) return dtString;
                var options = {
                    month: 'short',
                    day: '2-digit',
                    year: 'numeric',
                    hour: '2-digit',
                    minute: '2-digit'
                };
                return d.toLocaleString(undefined, options);
            }

            function openMunicipalityModal() {
                var modalEl = document.getElementById('municipalityModal');
                if (!modalEl) return;

                if (bootstrap && bootstrap.Modal) {
                    var instance = bootstrap.Modal.getOrCreateInstance(modalEl);
                    instance.show();
                    return;
                }

                if ($.fn && $.fn.modal) {
                    $(modalEl).modal('show');
                    return;
                }

                modalEl.classList.add('show');
                modalEl.style.display = 'block';
                modalEl.removeAttribute('aria-hidden');
                modalEl.setAttribute('aria-modal', 'true');
            }

            function renderWinnersRows(winners) {
                var hasResults = winners && winners.length > 0;

                if (hasResults) {
                    var tallies = {};
                    var medalWeight = {
                        Gold: 3,
                        Silver: 2,
                        Bronze: 1
                    };

                    winners.forEach(function(row) {
                        var key = normalizeKey(row.municipality);
                        if (!key) return;
                        if (!tallies[key]) {
                            tallies[key] = {
                                gold: 0,
                                silver: 0,
                                bronze: 0,
                                total: 0
                            };
                        }
                        var medalLower = (row.medal || '').toLowerCase();
                        if (medalLower === 'gold') tallies[key].gold++;
                        else if (medalLower === 'silver') tallies[key].silver++;
                        else if (medalLower === 'bronze') tallies[key].bronze++;
                        tallies[key].total++;
                    });

                    var sortedWinners = winners.slice().sort(function(a, b) {
                        var aKey = normalizeKey(a.municipality);
                        var bKey = normalizeKey(b.municipality);
                        var aStats = tallies[aKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };
                        var bStats = tallies[bKey] || {
                            gold: 0,
                            silver: 0,
                            bronze: 0,
                            total: 0
                        };

                        var diff = bStats.gold - aStats.gold;
                        if (diff !== 0) return diff;
                        diff = bStats.silver - aStats.silver;
                        if (diff !== 0) return diff;
                        diff = bStats.bronze - aStats.bronze;
                        if (diff !== 0) return diff;
                        diff = bStats.total - aStats.total;
                        if (diff !== 0) return diff;

                        var medalDiff = (medalWeight[b.medal] || 0) - (medalWeight[a.medal] || 0);
                        if (medalDiff !== 0) return medalDiff;

                        var aEvent = (a.event_name || '').toLowerCase();
                        var bEvent = (b.event_name || '').toLowerCase();
                        if (aEvent !== bEvent) return aEvent.localeCompare(bEvent);

                        var aGroup = (a.event_group || '').toLowerCase();
                        var bGroup = (b.event_group || '').toLowerCase();
                        if (aGroup !== bGroup) return aGroup.localeCompare(bGroup);

                        var aCat = (a.category || '').toLowerCase();
                        var bCat = (b.category || '').toLowerCase();
                        if (aCat !== bCat) return aCat.localeCompare(bCat);

                        var aName = (a.full_name || '').toLowerCase();
                        var bName = (b.full_name || '').toLowerCase();
                        return aName.localeCompare(bName);
                    });

                    var rows = '';
                    sortedWinners.forEach(function(row) {
                        var medal = row.medal || 'Silver';
                        var chipClass = 'chip-silver';
                        if (medal === 'Gold') chipClass = 'chip-gold';
                        else if (medal === 'Bronze') chipClass = 'chip-bronze';

                        rows += '<tr>' +
                            '<td class="align-middle">' + $('<div>').text(row.event_name || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.event_group || '').html() + '</td>' +
                            '<td class="align-middle" style="white-space:nowrap;">' + $('<div>').text(row.category || '-').html() + '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.full_name || '').html() + '</td>' +
                            '<td class="align-middle text-center">' +
                            '<span class="chip-medal ' + chipClass + '">' +
                            $('<div>').text(medal).html() +
                            '</span>' +
                            '</td>' +
                            '<td class="align-middle">' + $('<div>').text(row.municipality || '').html() + '</td>' +
                            '</tr>';
                    });
                    return rows;
                }

                var placeholders = [];
                if (Array.isArray(window.ALL_MUNICIPALITIES)) {
                    window.ALL_MUNICIPALITIES.forEach(function(name) {
                        if (!name) return;
                        placeholders.push(name);
                    });
                }

                if (placeholders.length === 0) {
                    return '<tr class="no-results-row">' +
                        '<td colspan="6" class="text-center py-5" style="color:#9ca3af;font-size:1.05rem;">' +
                        '🏅 No results are available yet. Please wait for the organizers to post the official list of winners.' +
                        '</td></tr>';
                }

                var rows = '';
                placeholders.forEach(function(name) {
                    rows += '<tr class="no-results-row">' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">—</td>' +
                        '<td class="align-middle text-muted">No winners posted yet</td>' +
                        '<td class="align-middle text-center text-muted">—</td>' +
                        '<td class="align-middle">' + $('<div>').text(name).html() + '</td>' +
                        '</tr>';
                });

                return rows;
            }

            function refreshResults() {
                $.getJSON('<?= site_url('provincial/live_results'); ?>', function(resp) {
                    if (!resp) return;

                    if (resp.overview) {
                        var o = resp.overview;
                        $('#stat-municipalities').text(o.municipalities || 0);
                        $('#stat-events').text(o.events || 0);

                        var gold = o.gold || 0;
                        var silver = o.silver || 0;
                        var bronze = o.bronze || 0;
                        var total = o.total_medals || (gold + silver + bronze);

                        $('#stat-total-medals').text(total);
                        $('#stat-medal-breakdown').text(
                            '(' + gold + 'G · ' + silver + 'S · ' + bronze + 'B)'
                        );
                        $('#stat-last-update').text(formatDateTime(o.last_update));
                    }

                    if (resp.winners) {
                        $('#winners-body').html(renderWinnersRows(resp.winners));
                    }
                }).fail(function() {
                    // fail silently for now
                });
            }

            $(function() {
                $('.loader-wrapper').fadeOut(200);

                $('#municipalityCard').on('click keypress', function(e) {
                    if (e.type === 'click' || e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        openMunicipalityModal();
                    }
                });

                refreshResults();
                setInterval(refreshResults, 30000);

                var $picker = $('#municipalityPicker');
                if ($picker.length) {
                    var $select = $('#municipalitySelect');
                    var $viewBtn = $('#municipalityViewButton');

                    function goToMunicipality(municipality) {
                        if (!municipality) return;
                        var baseUrl = $picker.data('base-url') || '<?= site_url('provincial'); ?>';
                        var groupQuery = $picker.data('group-query') || '';
                        var url = baseUrl + '?municipality=' + encodeURIComponent(municipality) + groupQuery;
                        window.location.href = url;
                    }

                    $viewBtn.on('click', function() {
                        goToMunicipality($select.val());
                    });

                    // (optional) If you want changing the select to auto-jump, uncomment:
                    // $select.on('change', function() {
                    //     goToMunicipality($(this).val());
                    // });
                }
            });
        })(window.jQuery, window.bootstrap);
    </script>

</body>

</html>
