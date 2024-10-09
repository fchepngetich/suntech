<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container mt-5">
<div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>View Blogs</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Blogs
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/blogs/create') ?>" class="btn btn-primary btn-sm ">Add Blog</a>
            </div>
        </div>
    </div>

<div class="container mt-5">
 
    <form action="<?= base_url('admin/blogs/store') ?>" method="post" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" class="form-control-file" required>
        </div>

        <button type="submit" class="btn btn-success">Create</button>
        <a href="/blogs" class="btn btn-secondary">Back</a>
    </form>
</div>


</div>

<?= $this->endSection() ?>

