<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Edit SubsubCategory</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin')?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Edit SubsubCategory
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/subsubcategories') ?>" class="btn btn-info btn-sm">View SubsubCategories</a>
            </div>
        </div>
    </div>

    <div class="card card-box">
    <div class="card-body">
    <form action="<?= base_url('admin/subsubcategories/edit/' . esc($subsubcategory['slug'])) ?>" method="post">
    <div class="form-group">
        <label for="name">Subsubcategory Name</label>
        <input type="text" name="name" class="form-control" value="<?= esc($subsubcategory['name']) ?>" required>
    </div>

    <div class="form-group">
        <label for="subcategory_id">Subcategory</label>
        <select name="subcategory_id" class="form-control" required>
            <?php foreach ($subcategories as $subcategory): ?>
                <option value="<?= esc($subcategory['id']) ?>" <?= ($subcategory['id'] == $subsubcategory['subcategory_id']) ? 'selected' : '' ?>><?= esc($subcategory['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Update Subsubcategory</button>
</form>
</div>



</div>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#editCategoryForm').on('submit', function(e) {
        e.preventDefault();
        var form = this;
        var formData = new FormData(form);

        $.ajax({
            url: $(form).attr('action'),
            method: $(form).attr('method'),
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            dataType: 'json',
            beforeSend: function() {
                toastr.remove();
                $(form).find('span.error-text').text('');
            },
            success: function(response) {
                if (response.token) {
                    $('input[name=csrf_test_name]').val(response.token); // Update CSRF token name as needed
                }

                if (response.status === 1) {
                    toastr.success(response.msg);
                    window.location.href = response.redirect;
                } else if (response.status === 0) {
                    toastr.error(response.msg);
                } else {
                    if (response.errors) {
                        $.each(response.errors, function(prefix, val) {
                            $(form).find('span.' + prefix + '_error').text(val);
                        });
                    } else {
                        toastr.error('An unexpected error occurred.');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", xhr, status, error);
                toastr.error('An error occurred. Please try again.');
            }
        });
    });
});
</script>
<?= $this->endSection() ?>

<?= $this->endSection() ?>
