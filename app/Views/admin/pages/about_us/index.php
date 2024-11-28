<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>about Us</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View About Us
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
            <a href="<?= base_url('admin/about-us/create') ?>" class="btn btn-primary mb-3">Add New</a>
            </div>
        </div>
    </div>

    <!-- File: app/Views/blogs/index.php -->
 

<div class="container mt-5">

    <?php if (session()->getFlashdata('success')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php endif; ?>

    <div class="list-group">
        <?php foreach ($about_us as $item): ?>
            <div class="list-group-item">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1"><?= esc($item['name']) ?></h5>
                    <div>
                        <a href="<?= base_url('admin/about-us/edit/' . $item['id']) ?>" class="btn btn-sm btn-warning">Edit</a>
                        <a href="<?= base_url('admin/about-us/delete/' . $item['id']) ?>" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</a>
                    </div>
                </div>
                <p class="mb-1"><?= html_entity_decode($item['description']) ?></p> <!-- Render description as HTML -->
                <?php if ($item['image']): ?>
                    <img src="<?= base_url('images/aboutus/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>


</div>



<?= $this->endSection() ?>

