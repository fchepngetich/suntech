<div class="container">
<?= $this->extend('backend/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
<div class="page-header">
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="title">
                <h4>Manage Users</h4>
            </div>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?= base_url('admin/home') ?>">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Manage Users
                    </li>
                </ol>
            </nav>
        </div>
        <div class="col-md-6 col-sm-12 text-right">
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#user-modal">
                Add User
            </button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card card-box">
            <div class="card-body">
            <table class="table table-sm table-hover table-striped table-borderless" id="users-table">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Full Name</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $count = 1; $loggedInUserId = \App\Libraries\CIAuth::id(); foreach ($users as $user): ?>
        <tr>
            <td><?= $count++ ?></td>
            <td><?= $user['full_name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <?php
                $roleId = $user['role'];
                $roleName = '';
                foreach ($roles as $role) {
                    if ($role['id'] == $roleId) {
                        $roleName = $role['name'];
                        break;
                    }
                }
                echo htmlspecialchars($roleName); 
                ?>
            </td>            <td>
                <button type="button" class="btn btn-sm btn-warning edit-user-btn btn-sm" data-id="<?= $user['id'] ?>">
                    <i class="fa fa-edit"></i>
                </button>
                <button type="button" class="btn btn-sm btn-danger delete-user-btn" data-id="<?= $user['id'] ?>" <?= $user['id'] == $loggedInUserId ? 'disabled' : '' ?>>
                    <i class="fa fa-trash"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>                    
    </tbody>
</table>

            </div>
        </div>
    </div>
</div>
</div>
<!-- Add User Modal -->
<?php include 'modals/create-user-modal.php'?>
<?php include 'modals/edit-user-modal.php'?>

</div>

<?= $this->endSection() ?>

<?= $this->section('stylesheets') ?>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>

<script>

$(document).ready(function() {
    $('#add-user-form').on('submit', function(e) {
        e.preventDefault();

        var csrfName = $('.ci_csrf_data').attr('name');
        var csrfHash = $('.ci_csrf_data').val();
        var form = this;
        var modal = $('#user-modal');
        var formData = new FormData(form);
        formData.append(csrfName, csrfHash);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if (response.token) {
                    $('.ci_csrf_data').val(response.token);
                }
                if (response.status === 1) {
                    $(form)[0].reset();
                    modal.modal('hide');
                    toastr.success(response.msg);
                    location.reload(); 
                } else if (response.status === 0) {
                    if (response.errors) {
                        $.each(response.errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val);
                        });
                    } else {
                        toastr.error(response.msg);
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});


$(document).ready(function() {
    $('.edit-user-btn').on('click', function() {
        var userId = $(this).data('id');
        $.ajax({
            url: '<?= base_url('admin/user/edit') ?>',
            method: 'GET',
            data: { id: userId },
            dataType: 'json',
            success: function(response) {
                if (response.status === 1) {
                    $('#edit-user-id').val(response.data.id);
                    $('#edit-full-name').val(response.data.full_name);
                    $('#edit-email').val(response.data.email);
                    
                    var roleSelect = $('#edit-role');
                    roleSelect.empty();
                    $.each(response.roles, function(index, role) {
                        var selected = (role.id === response.data.role) ? 'selected' : '';
                        roleSelect.append('<option value="' + role.id + '" ' + selected + '>' + role.name + '</option>');
                    });

                    $('#edit-user-modal').modal('show');
                } else {
                    toastr.error('Failed to fetch user data.');
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });

    $('#edit-user-form').on('submit', function(e) {
        e.preventDefault();

        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            dataType: 'json',
            contentType: false,
            cache: false,
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if (response.token) {
                    $('input[name="<?= csrf_token() ?>"]').val(response.token); 
                }
                if (response.status === 1) {
                    $(form)[0].reset();
                    $('#edit-user-modal').modal('hide');
                    toastr.success(response.msg);
                     location.reload(); 
                } else if (response.status === 0) {
                    toastr.error(response.msg);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val);
                        });
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});

$(document).ready(function() {
    $('.delete-user-btn').on('click', function() {
        var userId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure you want to delete user?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/user/delete') ?>',
                    method: 'POST',
                    data: {
                        id: userId,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.token) {
                            $('.ci_csrf_data').val(response.token);
                        }
                        if (response.status === 1) {
                            Swal.fire(
                                'Deleted!',
                                response.msg,
                                'success'
                            ).then(() => {
                                location.reload(); 
                            });
                            $('#user-row-' + userId).remove();
                        } else {
                            Swal.fire(
                                'Error!',
                                response.msg,
                                'error'
                            )
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX request failed:", xhr, status, error);
                        Swal.fire(
                            'Error!',
                            'An error occurred. Please try again.',
                            'error'
                        )
                    }
                });
            }
        });
    });
});

</script>
<?= $this->endSection() ?>
