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


    <form action="<?= base_url('admin/about-us/update/' . $about_us['id']) ?>" method="post" enctype="multipart/form-data" class="needs-validation" novalidate>
        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" class="form-control" value="<?= esc($about_us['name']) ?>" required>
            <div class="invalid-feedback">Please enter a name.</div>
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description" class="form-control" required><?= esc($about_us['description']) ?></textarea>
            <div class="invalid-feedback">Please enter a description.</div>
        </div>

        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" name="image" id="image" class="form-control-file">
            <?php if ($about_us['image']): ?>
                <div class="mt-2">
                    <img src="<?= base_url('images/aboutus/' . $about_us['image']) ?>" alt="<?= esc($about_us['name']) ?>" class="img-thumbnail" width="100">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>



</div>


<!-- Include CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('description'); // Replace the textarea with CKEditor
</script>

<?= $this->endSection() ?>

