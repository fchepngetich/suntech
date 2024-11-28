<div class="container">
    <?= $this->extend('admin/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Menus</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Menu
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/menus/create') ?>" class="btn btn-primary">Create New Menu</a>
            </div>
        </div>
    </div>


    <!-- Menus List in a Table -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Menu Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($menus as $index => $menu): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= esc($menu['name']) ?></td>
                            <td>
                                <a href="<?= base_url('admin/menus/edit/' . $menu['id']) ?>"
                                    class="btn btn-sm btn-warning">Edit</a>
                                <a href="<?= base_url('admin/menus/delete/' . $menu['id']) ?>" class="btn btn-sm btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this menu?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>