<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>FAQs </h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View FAQs
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/faqs') ?>" class="btn btn-primary btn-sm ">View</a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
    
        <form action="<?= base_url('admin/faqs/store') ?>" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <textarea class="form-control" name="description" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Save</button>
            <a href="<?= base_url('admin/faqs') ?>" class="btn btn-secondary">Back to FAQs</a>
        </form>
    </div>
</div>

<!-- Include CKEditor Script -->
<script src="https://cdn.ckeditor.com/4.16.1/standard/ckeditor.js"></script>
<script>
    // Initialize CKEditor
    CKEDITOR.replace('descriptions'); // Replace the textarea with CKEditor
</script>

<?= $this->endSection() ?>
