<!DOCTYPE html>
<html lang="en">

<?php include('includes/head.php'); ?>

<style>
    body {
        font-family: var(--app-font);
        background: #f8fafc;
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

    .btn-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
    }
</style>

<body>
    <div id="wrapper">

        <?php include('includes/top-nav-bar.php'); ?>
        <?php include('includes/sidebar.php'); ?>

        <div class="content-page">
            <div class="content">
                <div class="container-fluid">

                    <?php
                    $municipalities = isset($municipalities) ? $municipalities : array();
                    $meet_title = isset($meet->meet_title) ? $meet->meet_title : 'Provincial Meet';
                    $meet_year  = isset($meet->meet_year)  ? $meet->meet_year  : date('Y');
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box d-flex align-items-center justify-content-between flex-wrap">
                                <div class="mb-2">
                                    <h4 class="page-title mb-0">
                                        <?= htmlspecialchars($meet_title . ' ' . $meet_year, ENT_QUOTES, 'UTF-8'); ?> – Municipalities
                                    </h4>
                                </div>

                            </div>
                            <hr style="border:0;height:2px;background:linear-gradient(90deg,#059669 0%,#0ea5e9 50%,#22c55e 100%);border-radius:999px;margin-top:4px;">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success alert-dismissible fade show">
                                    <?= $this->session->flashdata('success'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>

                            <?php if ($this->session->flashdata('error')): ?>
                                <div class="alert alert-danger alert-dismissible fade show">
                                    <?= $this->session->flashdata('error'); ?>
                                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center justify-content-between mb-3">
                                        <div>
                                            <h5 class="card-title mb-0">Municipality list</h5>
                                            <small class="text-muted">Only the city/municipality name is shown here. Province and barangay fields remain hidden.</small>
                                        </div>
                                        <button class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#addMunicipalityModal">
                                            <i class="mdi mdi-plus"></i> Add Municipality
                                        </button>
                                    </div>

                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0" id="municipalityTable">
                                            <thead>
                                                <tr>
                                                    <th>Municipality / City</th>
                                                    <th class="text-right" style="width: 140px;">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($municipalities)): ?>
                                                    <?php foreach ($municipalities as $row): ?>
                                                        <?php $city = isset($row->municipality) ? $row->municipality : ''; ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?></td>
                                                            <td class="text-right">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-outline-secondary btn-sm btn-icon btn-edit-city"
                                                                    data-city="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>"
                                                                    data-toggle="tooltip"
                                                                    data-placement="top"
                                                                    title="Edit">
                                                                    <i class="mdi mdi-pencil"></i>
                                                                </button>
                                                                <form class="d-inline" action="<?= site_url('provincial/delete_municipality'); ?>" method="post"
                                                                    onsubmit="return confirm('Delete this municipality? This removes every matching address row.');">
                                                                    <input type="hidden" name="city" value="<?= htmlspecialchars($city, ENT_QUOTES, 'UTF-8'); ?>">
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm btn-icon" title="Delete">
                                                                        <i class="mdi mdi-delete-outline"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="2" class="text-center text-muted">No municipalities found.</td>
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

    <!-- Add Municipality Modal -->
    <div class="modal fade" id="addMunicipalityModal" tabindex="-1" role="dialog" aria-labelledby="addMunicipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addMunicipalityModalLabel">Add Municipality</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/add_municipality'); ?>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <input type="text" name="city" class="form-control" required placeholder="e.g. Davao City">
                        <small class="form-text text-muted">Only the city/municipality name is required.</small>
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

    <!-- Edit Municipality Modal -->
    <div class="modal fade" id="editMunicipalityModal" tabindex="-1" role="dialog" aria-labelledby="editMunicipalityModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editMunicipalityModalLabel">Edit Municipality</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <?= form_open('provincial/update_municipality'); ?>
                <div class="modal-body">
                    <input type="hidden" name="current_city" id="editCurrentCity">
                    <div class="form-group">
                        <label>Municipality / City</label>
                        <input type="text" name="city" id="editCityName" class="form-control" required>
                        <small class="form-text text-muted">Update only the city/municipality label shown in dropdowns.</small>
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
            if ($.fn.tooltip) {
                $('[data-toggle="tooltip"]').tooltip({
                    container: 'body'
                });
            }

            $('.btn-edit-city').on('click', function() {
                var city = $(this).data('city') || '';
                $('#editCurrentCity').val(city);
                $('#editCityName').val(city);
                $('#editMunicipalityModal').modal('show');
            });

            if ($.fn.DataTable) {
                $('#municipalityTable').DataTable({
                    pageLength: 10,
                    lengthChange: false,
                    order: [
                        [0, 'asc']
                    ],
                    autoWidth: false,
                    columnDefs: [{
                        targets: -1,
                        orderable: false,
                        searchable: false
                    }]
                });
            }
        });
    </script>

</body>

</html>