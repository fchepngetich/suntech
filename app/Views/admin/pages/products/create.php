<div class="container">
    <?= $this->extend('admin/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <div class="container">
        <div class="page-header ">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Add Products</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Add Product
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="<?= base_url('admin/products') ?>" class="btn btn-primary btn-sm ">View Product</a>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <?php if (session()->getFlashdata('errors')): ?>
                            <div class="alert alert-danger">
                                <ul>
                                    <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                        <li><?= esc($error) ?></li>
                                    <?php endforeach ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <form action="<?= base_url('admin/products/store') ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control" id="name" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Original Price</label>
                                        <input type="text" name="price" class="form-control" id="price" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discounted_price">Discounted Price</label>
                                        <input type="text" name="discounted_price" class="form-control"
                                            id="discounted_price">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description"
                                            required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="specification">Specifications</label>
                                        <textarea name="specification" class="form-control"
                                            id="specification"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
    <div class="form-group">
        <label for="category-hierarchy" class="form-label">Select Product Category</label>
        <select id="category-hierarchy" name="category_hierarchy" class="form-control">
            <option value="">Select Category</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category['id']; ?>" data-category-id="<?= $category['id']; ?>" data-level="1">
                    <?= $category['name']; ?>
                </option>

                <?php if (!empty($category['subcategories'])): ?>
                    <?php foreach ($category['subcategories'] as $subcategory): ?>
                        <option value="<?= $subcategory['id']; ?>" data-category-id="<?= $category['id']; ?>" data-level="2" data-subcategory-id="<?= $subcategory['id']; ?>">
                            &nbsp;&nbsp;— <?= $subcategory['name']; ?>
                        </option>

                        <?php if (!empty($subcategory['subsubcategories'])): ?>
                            <?php foreach ($subcategory['subsubcategories'] as $subsubcategory): ?>
                                <option value="<?= $subsubcategory['id']; ?>" data-category-id="<?= $category['id']; ?>" data-level="3" data-subcategory-id="<?= $subcategory['id']; ?>">
                                    &nbsp;&nbsp;&nbsp;&nbsp;— <?= $subsubcategory['name']; ?>
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <!-- Hidden inputs for each level -->
        <input type="hidden" name="category_id" id="category_id">
        <input type="hidden" name="subcategory_id" id="subcategory_id">
        <input type="hidden" name="subsubcategory_id" id="subsubcategory_id">
    </div>
</div>






                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Main Product Image</label>
                                        <input type="file" name="image" class="form-control-file" id="image"
                                            accept="image/*" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sideview_images">Side View Images</label>
                                        <input type="file" name="sideview_images[]" class="form-control-file"
                                            id="sideview_images" accept="image/*" multiple>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" name="stock" class="form-control" id="stock" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_top_deal">Top Deal</label>
                                        <select name="is_top_deal" class="form-control" id="is_top_deal">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_recommended">Recommended</label>
                                        <select name="is_recommended" class="form-control" id="is_recommended">
                                            <option value="0">No</option>
                                            <option value="1">Yes</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <span><a class="btn btn-info" href="">Cancel</a></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= $this->section('scripts') ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>

        CKEDITOR.replace('description');
        CKEDITOR.replace('specification');

document.getElementById('category-hierarchy').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const selectedValue = selectedOption.value;
    const level = selectedOption.getAttribute('data-level');
    const categoryId = selectedOption.getAttribute('data-category-id');
    const subcategoryId = selectedOption.getAttribute('data-subcategory-id');

    // Clear hidden fields
    document.getElementById('category_id').value = '';
    document.getElementById('subcategory_id').value = '';
    document.getElementById('subsubcategory_id').value = '';

    // Set the correct hidden input based on selection level
    if (level === '1') {
        document.getElementById('category_id').value = selectedValue;
    } else if (level === '2') {
        document.getElementById('subcategory_id').value = selectedValue;
        document.getElementById('category_id').value = categoryId; // Set category ID for subcategory
    } else if (level === '3') {
        document.getElementById('subsubcategory_id').value = selectedValue;
        document.getElementById('subcategory_id').value = subcategoryId; // Set subcategory ID for subsubcategory
        document.getElementById('category_id').value = categoryId; // Set category ID for subsubcategory
    }
});
</script>
   

    <?= $this->endSection() ?>

    <?= $this->endSection() ?>