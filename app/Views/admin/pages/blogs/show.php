<?= $this->extend('admin/layout/pages-layout') ?>

<?= $this->section('content') ?>

<div class="container mt-5">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>View Blog</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin/blogs') ?>">Blogs</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Blog
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/blogs/edit/' . $blog['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                <form action="<?= base_url('admin/blogs/delete/' . $blog['id']); ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><?= esc($blog['title']); ?></h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <!-- Display Blog Image -->
                    <img src="<?= base_url($blog['image']); ?>" class="img-fluid" alt="Blog Image" />
                </div>
                <div class="col-md-8">
                    <!-- Display Blog Description -->
                    <p><?= nl2br(html_entity_decode(strip_tags($blog['description']))); ?></p>
                    </div>
            </div>
        </div>
    </div>

    <a href="<?= base_url('admin/blogs'); ?>" class="btn btn-secondary mt-3">Back to Blogs</a>
</div>

<?= $this->endSection() ?>
