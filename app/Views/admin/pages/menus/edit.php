<div class="container">
    <?= $this->extend('admin/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="container">
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Edit Menu</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                           Edit Menu
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/menus') ?>" class="btn btn-primary btn-sm ">View Menus</a>
            </div>
        </div>
    </div>       
    <div class="card shadow">
            <div class="card-body">
                <form action="<?= base_url('admin/menus/update/' . $menu['id']) ?>" method="post">
                    <div class="form-group">
                        <label for="name">Menu Name</label>
                        <input type="text" name="name" id="name" 
                               value="<?= esc($menu['name']) ?>" 
                               class="form-control" placeholder="Enter menu name" required>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="<?= base_url('admin/menus') ?>" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
   
    </div>

    <?= $this->endSection() ?>
