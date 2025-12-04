<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    body {
        font-family: var(--app-font);
        background: #f8fafc;
    }

    .page-title-box h4 {
        font-weight: 800;
        letter-spacing: -0.01em;
    }

    .card {
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 8px 18px rgba(0, 0, 0, 0.04);
    }

    .card-title {
        font-weight: 800;
        color: #111827;
    }

    .table thead th {
        text-transform: uppercase;
        font-size: 0.78rem;
        letter-spacing: 0.08em;
        color: #6b7280;
        border-bottom-width: 2px;
    }

    .badge-medal {
        font-weight: 800;
        padding: 6px 10px;
        border-radius: 10px;
    }

    .badge-gold {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-silver {
        background: #e5e7eb;
        color: #374151;
    }

    .badge-bronze {
        background: #ffedd5;
        color: #9a3412;
    }

    .medal-section {
        border: 1px dashed #e5e7eb;
        background: #fff;
        border-radius: 12px;
        padding: 12px;
        margin-bottom: 12px;
    }

    .medal-section .medal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        flex-wrap: wrap;
    }

    .medal-row {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
    }

    .medal-row .card-body {
        padding: 12px;
    }

    .medal-row .form-group {
        margin-bottom: 0.5rem;
    }
</style>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <?php
                    $validation_list = validation_errors('<li>', '</li>');
                    $error_message   = $this->session->flashdata('error');
                    $category_error  = $this->session->flashdata('category_error');
                    $event_categories_list = isset($event_categories) ? $event_categories : array();
                    $event_groups_list = isset($event_groups) ? $event_groups : array();
                    $events_list = isset($events) ? $events : array();
                    $municipalities_list = isset($municipalities) ? $municipalities : array();
                    $meet_title = isset($meet->meet_title) ? $meet->meet_title : 'Provincial Meet';
                    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">
                                        <?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?> – Admin
                                    </h4>
                                </div>
                                <div class="d-flex align-items-center flex-wrap" style="gap: 8px;">

                                    <!-- Primary action -->
                                    <button class="btn btn-sm btn-outline-primary" id="openWinnerModal" data-toggle="modal" data-target="#winnerModal">
                                        <i class="mdi mdi-plus"></i> Add Winners
                                    </button>
                                    <!-- Secondary action -->
                                    <a href="<?= site_url('provincial/standings'); ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="mdi mdi-trophy"></i> View Standings
                                    </a>

                                    <!-- Settings -->
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-toggle="modal" data-target="#meetHeaderModal">
                                        <i class="mdi mdi-cog-outline"></i> Meet Header
                                    </button>

                                </div>

                            </div>
                            <!-- Updated gradient: green + blue, no purple -->
                            <hr style="border:0;height:2px;background:linear-gradient(90deg,#059669 0%,#0ea5e9 50%,#22c55e 100%);border-radius:999px;margin-top:4px;">
                        </div>
                    </div>

                    <!-- Alerts -->
                    <div class="row">
                        <div class="col-lg-8">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($error_message)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $error_message; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($category_error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $category_error; ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($validation_list)): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    <ul class="mb-0 pl-3" style="list-style: disc;">
                                        <?= $validation_list; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Main content -->
                    <div class="row">
                        <!-- Recent winners preview -->
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-start mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Recent winners</h5>
                                            <small class="text-muted">Latest entries saved to the standings.</small>
                                        </div>

                                    </div>

                                    <?php $recent_winners = isset($recent_winners) ? $recent_winners : array(); ?>
                                    <?php if (!empty($recent_winners)): ?>
                                        <div class="table-responsive">
                                            <table class="table table-hover mb-0">
                                                <thead>
                                                    <tr>
                                                        <th>Event</th>
                                                        <th>Group</th>
                                                        <th>Category</th>
                                                        <th>Winner</th>
                                                        <th class="text-center">Medal</th>
                                                        <th>Municipality</th>
                                                        <th class="text-right">Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($recent_winners as $row): ?>
                                                        <?php
                                                        $badgeClass = 'badge-silver';
                                                        if ($row->medal === 'Gold') {
                                                            $badgeClass = 'badge-gold';
                                                        } elseif ($row->medal === 'Bronze') {
                                                            $badgeClass = 'badge-bronze';
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($row->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->event_group, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->category ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($row->full_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-center">
                                                                <span class="badge badge-medal <?= $badgeClass; ?>"><?= htmlspecialchars($row->medal, ENT_QUOTES, 'UTF-8'); ?></span>
                                                            </td>
                                                            <td><?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-outline-secondary btn-sm btn-edit-winner"
                                                                    data-id="<?= (int) $row->id; ?>"
                                                                    data-event-id="<?= (int) $row->event_id; ?>"
                                                                    data-first-name="<?= htmlspecialchars($row->first_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-middle-name="<?= htmlspecialchars($row->middle_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-last-name="<?= htmlspecialchars($row->last_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-medal="<?= htmlspecialchars($row->medal, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-municipality="<?= htmlspecialchars($row->municipality, ENT_QUOTES, 'UTF-8'); ?>">
                                                                    Edit
                                                                </button>
                                                                <form action="<?= site_url('provincial/delete_winner/' . (int) $row->id); ?>"
                                                                    method="post" style="display:inline-block;"
                                                                    onsubmit="return confirm('Delete this winner?');">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center text-muted py-4">
                                            <i class="mdi mdi-trophy-outline" style="font-size: 1.6rem;"></i>
                                            <p class="mb-0">No entries yet. Click “Add Winners” to start encoding.</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Events CRUD -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Events</h5>
                                            <small class="text-muted">Add, edit, or delete events; categories auto-fill when selecting an event.</small>
                                        </div>
                                        <button class="btn btn-sm btn-primary" id="openAddEventModal" data-toggle="modal" data-target="#eventModal">
                                            <i class="mdi mdi-plus"></i> Add Event
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-sm table-hover mb-0" id="eventsTable">
                                            <thead>
                                                <tr>
                                                    <th style="width:40%;">Event</th>
                                                    <th style="width:20%;">Group</th>
                                                    <th style="width:20%;">Category</th>
                                                    <th style="width:20%;" class="text-right">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($events_list)): ?>
                                                    <?php foreach ($events_list as $event): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->group_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td><?= htmlspecialchars($event->category_name ?? '-', ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-outline-secondary btn-sm btn-edit-event"
                                                                    data-id="<?= (int) $event->event_id; ?>"
                                                                    data-name="<?= htmlspecialchars($event->event_name, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-group-id="<?= $event->group_id !== null ? (int) $event->group_id : ''; ?>"
                                                                    data-category-id="<?= $event->category_id !== null ? (int) $event->category_id : ''; ?>">
                                                                    Edit
                                                                </button>
                                                                <form action="<?= site_url('provincial/delete_event/' . (int) $event->event_id); ?>"
                                                                    method="post" style="display:inline-block;"
                                                                    onsubmit="return confirm('Delete this event?');">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                                                        Delete
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center text-muted">No events found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <?php include('includes/footer.php'); ?>

        </div>

    </div>

    <?php include('includes/footer_plugins.php'); ?>

    <!-- Meet Header Modal -->
    <?php
    $meet_title = isset($meet->meet_title) ? $meet->meet_title : 'Provincial Meet';
    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
    $subtitle   = isset($meet->subtitle)
        ? $meet->subtitle
        : 'Live results encoded by authorized officials. Read-only landing page for public viewing.';
    ?>
    <div class="modal fade" id="meetHeaderModal" tabindex="-1" role="dialog" aria-labelledby="meetHeaderModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="meetHeaderModalLabel"><i class="mdi mdi-cog-outline"></i> Meet Header Settings</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/update_meet_settings'); ?>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Meet Title</label>
                        <input type="text" name="meet_title" class="form-control form-control-sm"
                            value="<?= htmlspecialchars($meet_title, ENT_QUOTES, 'UTF-8'); ?>"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Year</label>
                        <input type="text" name="meet_year" class="form-control form-control-sm"
                            placeholder="e.x: 2025 or 2025–2026"
                            value="<?= htmlspecialchars($meet_year, ENT_QUOTES, 'UTF-8'); ?>"
                            required>
                    </div>

                    <div class="form-group mb-2">
                        <label>Subtitle (optional)</label>
                        <textarea name="subtitle" class="form-control form-control-sm" rows="2"
                            placeholder="Shown under the title on the landing page"><?= htmlspecialchars($subtitle, ENT_QUOTES, 'UTF-8'); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Header</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add/Edit Event Modal -->
    <div class="modal fade" id="eventModal" tabindex="-1" role="dialog" aria-labelledby="eventModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="eventModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/add_event', array('id' => 'eventForm')); ?>
                <div class="modal-body">
                    <input type="hidden" name="event_id" id="eventIdField" value="">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="event_name" id="eventName" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Group</label>
                        <select name="group_id" id="eventGroup" class="form-control" required>
                            <option value="">-- Select Group --</option>
                            <?php foreach ($event_groups_list as $group): ?>
                                <option value="<?= (int) $group->group_id; ?>">
                                    <?= htmlspecialchars($group->group_name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Category (optional)</label>
                        <select name="category_id" id="eventCategory" class="form-control">
                            <option value="">-- No Category --</option>
                            <?php foreach ($event_categories_list as $category): ?>
                                <option value="<?= (int) $category->category_id; ?>">
                                    <?= htmlspecialchars($category->category_name, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Leave blank if the event is uncategorized.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="eventSubmitBtn">Save Event</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add Winner Modal -->
    <div class="modal fade" id="winnerModal" tabindex="-1" role="dialog" aria-labelledby="winnerModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="winnerModalLabel"><i class="mdi mdi-plus-circle-outline"></i> Add Winners</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/admin', array('id' => 'winnerForm')); ?>
                <div class="modal-body">
                    <input type="hidden" name="winner_id" id="winnerIdField" value="">
                    <div class="form-group">
                        <label>Event <span class="text-danger">*</span></label>
                        <select name="event_id" id="eventSelect" class="form-control" required>
                            <option value="">-- Select Event --</option>
                            <?php foreach ($events_list as $event): ?>
                                <?php
                                $parts = array();
                                if (!empty($event->group_name)) {
                                    $parts[] = $event->group_name;
                                }
                                $parts[] = $event->event_name;
                                if (!empty($event->category_name)) {
                                    $parts[] = $event->category_name;
                                }
                                $label = implode(' – ', $parts);
                                ?>
                                <option value="<?= (int) $event->event_id; ?>"
                                    data-category-id="<?= $event->category_id !== null ? (int) $event->category_id : ''; ?>"
                                    data-category-name="<?= htmlspecialchars($event->category_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    data-group-name="<?= htmlspecialchars($event->group_name ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                                    <?= set_select('event_id', $event->event_id); ?>>
                                    <?= htmlspecialchars($label, ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="form-text text-muted">Select the event; category auto-fills below.</small>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Group – auto-set from event</label>
                            <input type="text" class="form-control" id="selectedGroup" value="Select an event" readonly>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Category – auto-set from event</label>
                            <input type="text" class="form-control" id="selectedCategory" value="Select an event" readonly>
                        </div>
                    </div>

                    <div class="alert alert-info py-2">
                        Add Gold, Silver, and Bronze winners in one go. Empty rows are skipped.
                    </div>

                    <div id="municipalityOptionsTemplate" class="d-none">
                        <option value="">-- Select Municipality --</option>
                        <?php foreach ($municipalities_list as $municipality): ?>
                            <?php $name = $municipality->municipality; ?>
                            <option value="<?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
                                <?= htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>
                            </option>
                        <?php endforeach; ?>
                    </div>

                    <div class="medal-section" data-medal="Gold">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-gold mr-2">Gold</span>
                                <span class="text-muted small">Winners for this medal</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Gold">
                                <i class="mdi mdi-plus"></i> Add Gold winner
                            </button>
                        </div>
                        <div class="medal-rows" id="goldRows"></div>
                    </div>

                    <div class="medal-section" data-medal="Silver">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-silver mr-2">Silver</span>
                                <span class="text-muted small">Add one or more Silver winners</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Silver">
                                <i class="mdi mdi-plus"></i> Add Silver winner
                            </button>
                        </div>
                        <div class="medal-rows" id="silverRows"></div>
                    </div>

                    <div class="medal-section mb-0" data-medal="Bronze">
                        <div class="medal-header mb-2">
                            <div class="d-flex align-items-center">
                                <span class="badge badge-medal badge-bronze mr-2">Bronze</span>
                                <span class="text-muted small">Add any Bronze winners</span>
                            </div>
                            <button type="button" class="btn btn-outline-secondary btn-sm btn-add-medal" data-medal="Bronze">
                                <i class="mdi mdi-plus"></i> Add Bronze winner
                            </button>
                        </div>
                        <div class="medal-rows" id="bronzeRows"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" name="submit" value="1" class="btn btn-success" id="winnerSubmitBtn">
                        <i class="mdi mdi-content-save-outline"></i> Save Winners
                    </button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Add Event Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Add Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/add_category'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <!-- Edit Event Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Event</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/update_category'); ?>
                <div class="modal-body">
                    <input type="hidden" name="category_id" id="editCategoryId">
                    <div class="form-group">
                        <label>Event Name</label>
                        <input type="text" name="category_name" id="editCategoryName" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            var createAction = "<?= site_url('provincial/admin'); ?>";
            var updateAction = "<?= site_url('provincial/update_winner'); ?>";
            var createEventAction = "<?= site_url('provincial/add_event'); ?>";
            var updateEventAction = "<?= site_url('provincial/update_event'); ?>";
            var $eventSelect = $('#eventSelect');
            var $groupDisplay = $('#selectedGroup');
            var $categoryDisplay = $('#selectedCategory');
            var $winnerForm = $('#winnerForm');
            var $winnerSubmitBtn = $('#winnerSubmitBtn');
            var $winnerModalLabel = $('#winnerModalLabel');
            var $eventForm = $('#eventForm');
            var $eventModalLabel = $('#eventModalLabel');
            var $eventSubmitBtn = $('#eventSubmitBtn');
            var $eventIdField = $('#eventIdField');
            var $eventNameInput = $('#eventName');
            var $eventGroupSelect = $('#eventGroup');
            var $eventCategorySelect = $('#eventCategory');
            var medalContainers = {
                Gold: $('#goldRows'),
                Silver: $('#silverRows'),
                Bronze: $('#bronzeRows')
            };
            var municipalityOptionsHtml = $('#municipalityOptionsTemplate').html();
            var rowCounter = 0;
            var isEditMode = false;

            function updateMeta() {
                var $selected = $eventSelect.find('option:selected');
                if (!$selected.val()) {
                    $groupDisplay.val('Select an event');
                    $categoryDisplay.val('Select an event');
                    return;
                }

                var groupName = $selected.data('group-name') || 'Unspecified';
                var categoryName = $selected.data('category-name') || 'Unspecified';

                $groupDisplay.val(groupName);
                $categoryDisplay.val(categoryName);
            }

            $eventSelect.on('change', updateMeta);

            updateMeta();

            function setEventCreateMode() {
                $eventForm.attr('action', createEventAction);
                $eventModalLabel.text('Add Event');
                $eventSubmitBtn.text('Save Event');
                $eventIdField.val('');
                $eventNameInput.val('');
                $eventGroupSelect.val('');
                $eventCategorySelect.val('');
            }

            function setEventEditMode(data) {
                $eventForm.attr('action', updateEventAction);
                $eventModalLabel.text('Edit Event');
                $eventSubmitBtn.text('Update Event');
                $eventIdField.val(data.id || '');
                $eventNameInput.val(data.name || '');
                $eventGroupSelect.val(data.group_id || '');
                $eventCategorySelect.val(data.category_id || '');
            }

            function clearAllRows() {
                $.each(medalContainers, function(key, $container) {
                    $container.empty();
                });
            }

            function addWinnerRow(medal, data) {
                data = data || {};
                if (!medalContainers[medal]) {
                    return;
                }

                if (isEditMode) {
                    clearAllRows();
                }

                rowCounter += 1;
                var index = rowCounter;
                var badgeClass = 'badge-bronze';
                if (medal === 'Gold') {
                    badgeClass = 'badge-gold';
                } else if (medal === 'Silver') {
                    badgeClass = 'badge-silver';
                }

                var entryNumber = medalContainers[medal].find('.medal-row').length + 1;
                var $row = $(
                    '<div class="medal-row card mb-2" data-medal="' + medal + '">' +
                    '<div class="card-body pb-2">' +
                    '<div class="d-flex align-items-center justify-content-between mb-2">' +
                    '<div class="d-flex align-items-center">' +
                    '<span class="badge badge-medal ' + badgeClass + ' mr-2">' + medal + '</span>' +
                    '<small class="text-muted">Entry ' + entryNumber + '</small>' +
                    '</div>' +
                    '<button type="button" class="btn btn-link text-danger p-0 btn-remove-row">Remove</button>' +
                    '</div>' +
                    '<div class="form-row">' +
                    '<div class="form-group col-md-3">' +
                    '<label class="small text-muted mb-1">First name</label>' +
                    '<input type="text" name="winners[' + index + '][first_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label class="small text-muted mb-1">Middle name</label>' +
                    '<input type="text" name="winners[' + index + '][middle_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label class="small text-muted mb-1">Last name</label>' +
                    '<input type="text" name="winners[' + index + '][last_name]" class="form-control form-control-sm">' +
                    '</div>' +
                    '<div class="form-group col-md-3">' +
                    '<label class="small text-muted mb-1">Municipality</label>' +
                    '<select name="winners[' + index + '][municipality]" class="form-control form-control-sm">' +
                    municipalityOptionsHtml +
                    '</select>' +
                    '</div>' +
                    '</div>' +
                    '<input type="hidden" name="winners[' + index + '][medal]" value="' + medal + '">' +
                    '</div>' +
                    '</div>'
                );

                $row.find('input[name="winners[' + index + '][first_name]"]').val(data.first_name || '');
                $row.find('input[name="winners[' + index + '][middle_name]"]').val(data.middle_name || '');
                $row.find('input[name="winners[' + index + '][last_name]"]').val(data.last_name || '');
                $row.find('select[name="winners[' + index + '][municipality]"]').val(data.municipality || '');

                medalContainers[medal].append($row);
            }

            function seedDefaultRows() {
                clearAllRows();
                rowCounter = 0;
                addWinnerRow('Gold');
            }

            function ensureBaseRows() {
                if (medalContainers.Gold.find('.medal-row').length === 0) {
                    addWinnerRow('Gold');
                }
            }

            $(document).on('click', '.btn-add-medal', function() {
                var medal = $(this).data('medal');
                addWinnerRow(medal);
            });

            $(document).on('click', '.btn-remove-row', function() {
                $(this).closest('.medal-row').remove();
            });

            function setCreateMode() {
                isEditMode = false;
                $winnerForm.attr('action', createAction);
                $('#winnerIdField').val('');
                $eventSelect.val('').trigger('change');
                $winnerSubmitBtn.html('<i class="mdi mdi-content-save-outline"></i> Save Winners');
                $winnerModalLabel.text('Add Winners');
                seedDefaultRows();
                updateMeta();
            }

            function setEditMode(data) {
                isEditMode = true;
                $winnerForm.attr('action', updateAction);
                $('#winnerIdField').val(data.id || '');
                $eventSelect.val(data.event_id || '').trigger('change');

                clearAllRows();
                rowCounter = 0;
                addWinnerRow(data.medal || 'Gold', data);

                $winnerSubmitBtn.html('<i class="mdi mdi-content-save-outline"></i> Update Winner');
                $winnerModalLabel.text('Edit Winner');
                updateMeta();
            }

            $('#openWinnerModal').on('click', function() {
                setCreateMode();
            });

            $('#openAddEventModal').on('click', function() {
                setEventCreateMode();
            });

            $('#winnerModal').on('shown.bs.modal', function() {
                if (!isEditMode) {
                    ensureBaseRows();
                }
            });

            $('.btn-edit-winner').on('click', function() {
                var $btn = $(this);
                var data = {
                    id: $btn.data('id'),
                    event_id: $btn.data('event-id'),
                    first_name: $btn.data('first-name'),
                    middle_name: $btn.data('middle-name'),
                    last_name: $btn.data('last-name'),
                    medal: $btn.data('medal'),
                    municipality: $btn.data('municipality')
                };

                setEditMode(data);
                $('#winnerModal').modal('show');
            });

            $('.btn-edit-event').on('click', function() {
                var $btn = $(this);
                var data = {
                    id: $btn.data('id'),
                    name: $btn.data('name'),
                    group_id: ($btn.data('group-id') || '').toString(),
                    category_id: ($btn.data('category-id') || '').toString()
                };
                setEventEditMode(data);
                $('#eventModal').modal('show');
            });

            seedDefaultRows();

            if ($.fn.DataTable) {
                $('#eventsTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    order: [[1, 'asc'], [0, 'asc']],
                    columnDefs: [
                        { targets: -1, orderable: false, searchable: false }
                    ],
                    autoWidth: false
                });
            }

            <?php if (!empty($validation_list) || !empty($error_message)): ?>
                setCreateMode();
                $('#winnerModal').modal('show');
            <?php endif; ?>
        });
    </script>

</body>

</html>
