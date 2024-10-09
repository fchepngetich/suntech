<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Add Category</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin')?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add Category
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/subcategories') ?>" class="btn btn-info btn-sm">View SubCategories</a>
            </div>
        </div>
    </div>
    <div class="card card-box">
    <div class="card-body">
<form action="<?= base_url('admin/subcategories/store') ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" name="name" id="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="category_id">Category</label>
        <select name="category_id" id="category_id" class="form-control" required>
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id'] ?>"><?= esc($category['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Create</button>
    <span><a href="<?= base_url('admin/subcategories') ?>" class="btn btn-secondary">Cancel</a>
    </span>
</form>
</div></div>

</div>

<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
