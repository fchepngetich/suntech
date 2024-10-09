<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Add SubSubCategory</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin')?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Add SubsubCategory
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/subsubcategories') ?>" class="btn btn-info btn-sm">View SubSubCategories</a>
            </div>
        </div>
    </div>
    <div class="card card-box">
    <div class="card-body">

<form action="<?= base_url('/admin/subsubcategories/create') ?>" method="post">
<input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" />

    <div class="form-group">
        <label for="name">Subsubcategory Name</label>
        <input type="text" name="name" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="subcategory_id">Subcategory</label>
        <select name="subcategory_id" class="form-control" required>
            <?php foreach ($subcategories as $subcategory): ?>
                <option value="<?= esc($subcategory['id']) ?>"><?= esc($subcategory['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Add Subsubcategory</button>
</form>
</div></div>

</div>

<?= $this->section('scripts') ?>
<script>

</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
