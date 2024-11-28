<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="page-header">
<div class="row">
    <div class="col-md-6 col-sm-12">
        <div class="title">
            <h4>Add User</h4>
        </div>
        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="<?= route_to('admin.home')?>">Home</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    Add User
                </li>
            </ol>
        </nav>
    </div>
    <div class="col-md-6 col-sm-12 text-right">
        <a href="<?= base_url('admin/users') ?>" class="btn btn-info">View</a>
    </div>
</div>
</div>

<div class="container mt-5">
    <form action="<?= base_url('admin/users/store') ?>" method="post">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="role_id">Role</label>
            <select class="form-control" id="role_id" name="role_id" required>
                <option value="" disabled selected>Select Role</option>
                <?php foreach ($roles as $role): ?>
                    <option value="<?= esc($role['id']) ?>"><?= esc($role['name']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Save</button>
        <a href="<?= base_url('admin/users') ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>


 <?= $this->endSection() ?>
