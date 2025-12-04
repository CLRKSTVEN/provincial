<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: var(--app-font);
        background: linear-gradient(to bottom right, #EEF2FF 0%, #E0E7FF 50%, #FEF3C7 100%);
        color: #1e293b;
        min-height: 100vh;
        position: relative;
        overflow-x: hidden;
    }

    /* Animated background shapes */
    body::before,
    body::after {
        content: '';
        position: fixed;
        border-radius: 50%;
        opacity: 0.35;
        animation: float 20s infinite ease-in-out;
        z-index: 0;
    }

    body::before {
        width: 500px;
        height: 500px;
        background: radial-gradient(circle, #818CF8 0%, transparent 70%);
        top: -200px;
        right: -200px;
        animation-delay: 0s;
    }

    body::after {
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, #FCD34D 0%, transparent 70%);
        bottom: -150px;
        left: -150px;
        animation-delay: -10s;
    }

    @keyframes float {

        0%,
        100% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(30px, -30px) scale(1.05);
        }

        66% {
            transform: translate(-20px, 20px) scale(0.97);
        }
    }

    .landing-page-wrapper {
        min-height: 100vh;
        padding: 0;
        position: relative;
        z-index: 1;
        display: flex;
        align-items: stretch;
    }

    .landing-card {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        width: 100%;
    }

    .landing-card-inner {
        flex: 1;
        display: flex;
        flex-direction: column;
        max-width: 1200px;
        margin: 0 auto;
        width: 100%;
        padding: 40px 28px 32px;
    }

    /* Header Section */
    .landing-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 24px;
        margin-bottom: 28px;
        animation: slideDown 0.6s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .landing-title h4 {
        font-size: 0.9rem;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: #6366F1;
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
        font-size: 2.35rem;
        font-weight: 900;
        color: #1e293b;
        margin-bottom: 6px;
        letter-spacing: -0.03em;
        line-height: 1.15;
    }

    .landing-title small {
        color: #64748b;
        font-size: 0.9rem;
        line-height: 1.6;
        display: block;
        max-width: 520px;
    }

    /* Group Pills */
    .group-pills {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }

    .group-pills .btn {
        border-radius: 10px;
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border: 2px solid transparent;
        transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        position: relative;
        overflow: hidden;
    }

    .group-pills .btn::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.35), transparent);
        transition: left 0.5s;
    }

    .group-pills .btn:hover::before {
        left: 100%;
    }

    .group-pills .btn-outline-primary {
        background: white;
        color: #475569;
        border-color: #e2e8f0;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    .group-pills .btn-outline-primary:hover {
        border-color: #6366F1;
        color: #6366F1;
        box-shadow: 0 6px 16px rgba(99, 102, 241, 0.16);
        transform: translateY(-1px);
    }

    .group-pills .btn-primary {
        background: linear-gradient(135deg, #6366F1 0%, #8B5CF6 100%);
        color: white;
        border-color: #6366F1;
        box-shadow: 0 6px 20px rgba(99, 102, 241, 0.35);
    }

    .group-pills .btn-primary:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 26px rgba(99, 102, 241, 0.45);
    }

    .landing-actions {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .login-btn {
        padding: 8px 20px;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 10px;
        border: 2px solid #e2e8f0;
        background: white;
        color: #475569;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.08);
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .login-btn:hover {
        color: #6366F1;
        border-color: #6366F1;
        box-shadow: 0 6px 18px rgba(99, 102, 241, 0.22);
        transform: translateY(-1px);
    }

    .summary-row {
        margin-bottom: 22px;
        animation: fadeIn 0.8s ease-out 0.2s backwards;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(16px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .summary-card {
        background: white;
        border-radius: 16px;
        padding: 18px 20px;
        border: 1px solid #e2e8f0;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        height: 100%;
        box-shadow: 0 2px 10px rgba(15, 23, 42, 0.04);
    }

    .summary-card.clickable {
        cursor: pointer;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #6366F1, #8B5CF6, #EC4899);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .summary-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(99, 102, 241, 0.12);
        border-color: #6366F1;
    }

    .summary-card:hover::before {
        transform: scaleX(1);
    }

    .summary-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #94a3b8;
        margin-bottom: 8px;
        font-weight: 700;
    }

    .summary-value {
        font-size: 2rem;
        font-weight: 800;
        color: #1e293b;
        margin-bottom: 6px;
        line-height: 1.1;
        display: flex;
        align-items: baseline;
        gap: 6px;
        flex-wrap: wrap;
    }

    .summary-sub {
        font-size: 0.85rem;
        color: #64748b;
        line-height: 1.4;
    }

    /* Winners Table */
    .winners-table-wrapper {
        background: white;
        border-radius: 18px;
        border: 2px solid #e2e8f0;
        overflow: hidden;
        flex: 1;
        display: flex;
        flex-direction: column;
        box-shadow: 0 8px 32px rgba(15, 23, 42, 0.06);
        animation: fadeIn 0.8s ease-out 0.4s backwards;
        margin-top: 6px;
    }

    .winners-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
        background: linear-gradient(to right, #F8FAFC 0%, #EEF2FF 100%);
        border-bottom: 1px solid #e2e8f0;
        flex-wrap: wrap;
    }

    .winners-toolbar-left {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .winners-heading {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        color: #1e293b;
    }

    .winners-subtext {
        margin: 0;
        color: #94a3b8;
        font-size: 0.9rem;
    }

    .winners-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: flex-end;
    }

    .filter-chip {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 12px;
        border-radius: 999px;
        background: white;
        border: 1px solid #e2e8f0;
        font-size: 0.85rem;
        font-weight: 700;
        color: #475569;
        box-shadow: 0 2px 6px rgba(15, 23, 42, 0.05);
    }

    .filter-chip-primary {
        background: #EEF2FF;
        border-color: #C7D2FE;
        color: #4338ca;
    }

    .filter-chip-accent {
        background: #EFF6FF;
        border-color: #BFDBFE;
        color: #0ea5e9;
    }

    .filter-chip-muted {
        background: #F8FAFC;
        border-color: #E2E8F0;
        color: #94a3b8;
    }

    .clear-filter-btn {
        border-radius: 999px;
        font-weight: 700;
        padding: 8px 14px;
    }

    .table-responsive {
        flex: 1;
        overflow-y: auto;
    }

    .winners-table {
        margin: 0;
        width: 100%;
    }

    .winners-table thead {
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .winners-table thead th {
        background: linear-gradient(to bottom, #F8FAFC 0%, #F1F5F9 100%);
        font-size: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 800;
        color: #475569;
        border-bottom: 3px solid #e2e8f0;
        padding: 14px 14px;
        white-space: nowrap;
        border-top: none;
    }

    .winners-table tbody td {
        padding: 14px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 0.95rem;
        color: #334155;
        transition: background-color 0.2s ease;
    }

    .winners-table tbody tr {
        background: white;
        transition: background-color 0.2s ease;
    }

    .winners-table tbody tr:hover {
        background: #F9FAFB;
    }

    .winners-table tbody tr:last-child td {
        border-bottom: none;
    }

    .winners-table tbody tr.no-results-row,
    .winners-table tbody tr.no-results-row:hover {
        background: white;
    }

    /* Medal Chips */
    .chip-medal {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 18px;
        border-radius: 999px;
        font-size: 0.75rem;
        font-weight: 900;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border: 3px solid;
        min-width: 100px;
        transition: all 0.2s ease;
        box-shadow: 0 4px 12px rgba(15, 23, 42, 0.1);
    }

    .chip-medal:hover {
        transform: translateY(-1px);
    }

    .chip-gold {
        background: linear-gradient(135deg, #FEF3C7 0%, #FDE68A 100%);
        color: #78350f;
        border-color: #F59E0B;
        box-shadow: 0 4px 14px rgba(245, 158, 11, 0.4);
    }

    .chip-silver {
        background: linear-gradient(135deg, #F1F5F9 0%, #E2E8F0 100%);
        color: #334155;
        border-color: #94A3B8;
        box-shadow: 0 4px 14px rgba(148, 163, 184, 0.4);
    }

    .chip-bronze {
        background: linear-gradient(135deg, #FED7AA 0%, #FDBA74 100%);
        color: #7c2d12;
        border-color: #F97316;
        box-shadow: 0 4px 14px rgba(249, 115, 22, 0.4);
    }

    /* Footer */
    .footer-note {
        margin-top: 14px;
        padding-top: 10px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        align-items: center;
        font-size: 0.8rem;
        color: #94a3b8;
        font-weight: 500;
        gap: 10px;
        flex-wrap: wrap;
    }

    .municipality-picker {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 14px;
        margin-bottom: 12px;
    }

    .municipality-picker-label {
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        display: block;
    }

    .municipality-picker-row {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        align-items: center;
    }

    .municipality-picker select {
        min-width: 220px;
    }

    .municipality-empty {
        text-align: center;
        color: #94a3b8;
        padding: 10px 0;
    }

    .footer-note span {
        text-align: right;
    }

    .loader-wrapper {
        background: linear-gradient(to bottom right, #EEF2FF 0%, #E0E7FF 50%, #FEF3C7 100%);
    }

    @media (max-width: 991.98px) {
        .landing-card-inner {
            padding: 28px 18px 24px;
        }

        .landing-header {
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 22px;
        }

        .landing-title h2 {
            font-size: 2rem;
        }

        .landing-title small {
            max-width: 100%;
        }

        .landing-actions {
            width: 100%;
            justify-content: space-between;
        }

        .group-pills {
            flex: 1;
        }

        .group-pills .btn {
            flex: 1;
            min-width: 100px;
            text-align: center;
        }

        .summary-value {
            font-size: 1.8rem;
        }

        .winners-table thead th {
            font-size: 0.7rem;
            padding: 12px 10px;
        }

        .winners-table tbody td {
            padding: 12px 10px;
            font-size: 0.85rem;
        }

        .winners-toolbar {
            align-items: flex-start;
        }

        .winners-actions {
            width: 100%;
            justify-content: flex-start;
        }

        .footer-note {
            justify-content: center;
            text-align: center;
        }
    }

    @media (max-width: 576px) {
        .landing-title h2 {
            font-size: 1.75rem;
        }

        .landing-title small {
            font-size: 0.85rem;
        }

        .chip-medal {
            min-width: 80px;
            padding: 8px 16px;
            font-size: 0.7rem;
        }

        .landing-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .login-btn {
            width: 100%;
            justify-content: center;
        }

        .winners-actions {
            flex-direction: column;
            align-items: stretch;
        }

        .winners-actions .clear-filter-btn {
            width: 100%;
            text-align: center;
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
                                            style="font-size:0.9rem;font-weight:700;color:#6366F1;">
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
                                                        style="color: #94a3b8; font-size: 1.1rem;">
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
    $normalizeName = function($name) {
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
        usort($sortedMunicipalities, function($a, $b) use ($tallyMap, $normalizeName) {
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
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
        window.ALL_MUNICIPALITIES = <?= json_encode(array_values(array_map(function($mun) {
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
                        '<td colspan="6" class="text-center py-5" style="color:#94a3b8;font-size:1.1rem;">' +
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
