<div class="container">
    <?= $this->extend('admin/layout/pages-layout') ?>
    <?= $this->section('content') ?>

    <div class="container">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Update Product</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="<?= base_url('admin') ?>">Home</a>
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                Update Product
                            </li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 col-sm-12 text-right">
                    <a href="<?= base_url('admin/products') ?>" class="btn btn-primary btn-sm">View Products</a>
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
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <form action="<?= base_url('admin/products/update/' . $product['slug']) ?>" method="post"
                            enctype="multipart/form-data">
                            <?= csrf_field() ?>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="name">Product Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                            value="<?= esc($product['name']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="price">Original Price</label>
                                        <input type="text" name="price" class="form-control" id="price"
                                            value="<?= esc($product['price']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="discounted_price">Discounted Price</label>
                                        <input type="text" name="discounted_price" class="form-control"
                                            id="discounted_price" value="<?= esc($product['discounted_price']) ?>">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea name="description" class="form-control" id="description"
                                            required><?= esc($product['description']) ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="features">Features</label>
                                        <textarea name="features" class="form-control"
                                            id="features"><?= esc($product['features']) ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="product_category">Select Product Category</label>
                                        <select name="subsubcategory_id" class="form-control" id="product_category"
                                            required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <optgroup label="<?= esc($category['name']) ?>">
                                                    <?php foreach ($category['subcategories'] as $subcategory): ?>
                                                    <optgroup label="-- <?= esc($subcategory['name']) ?>">
                                                        <?php foreach ($subcategory['subsubcategories'] as $subsubcategory): ?>
                                                            <option value="<?= esc($subsubcategory['id']) ?>"
                                                                data-category-id="<?= esc($category['id']) ?>"
                                                                data-subcategory-id="<?= esc($subcategory['id']) ?>"
                                                                <?= ($subsubcategory['id'] == $product['subsubcategory_id']) ? 'selected' : '' ?>>
                                                                --- <?= esc($subsubcategory['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </optgroup>
                                                <?php endforeach; ?>
                                                </optgroup>
                                            <?php endforeach; ?>
                                        </select>
                                        <!-- Hidden fields to hold the category and subcategory IDs -->
                                        <input type="hidden" name="category_id" id="category_id"
                                            value="<?= esc($product['category_id']) ?>">
                                        <input type="hidden" name="subcategory_id" id="subcategory_id"
                                            value="<?= esc($product['subcategory_id']) ?>">
                                    </div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="stock">Stock</label>
                                        <input type="number" name="stock" class="form-control" id="stock"
                                            value="<?= esc($product['stock']) ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
    <div class="form-group">
        <label for="image">Main Product Image</label>
        <input type="file" name="image" class="form-control-file" id="image">
        <small>Current Image: <?= esc($product['image']) ?></small> <!-- Show the image name -->
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remove_main_image" value="1" id="removeMainImage">
            <label class="form-check-label" for="removeMainImage">
                Remove this image
            </label>
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="sideview_images">Side View Images</label>
        <input type="file" name="sideview_images[]" class="form-control-file" id="sideview_images" multiple>
        <small>Current Images:</small>
        <ul>
            <?php foreach (json_decode($product['sideview_images'], true) as $index => $image): ?>
                <li>
                    <?= esc($image) ?> <!-- Show the image name -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remove_sideview_images[]" value="<?= $index ?>" id="removeSideImage<?= $index ?>">
                        <label class="form-check-label" for="removeSideImage<?= $index ?>">
                            Remove this image
                        </label>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_top_deal">Top Deal</label>
                                        <select name="is_top_deal" class="form-control" id="is_top_deal">
                                            <option value="0" <?= ($product['is_top_deal'] == 0) ? 'selected' : '' ?>>No
                                            </option>
                                            <option value="1" <?= ($product['is_top_deal'] == 1) ? 'selected' : '' ?>>Yes
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="is_recommended">Recommended</label>
                                        <select name="is_recommended" class="form-control" id="is_recommended">
                                            <option value="0" <?= ($product['is_recommended'] == 0) ? 'selected' : '' ?>>No
                                            </option>
                                            <option value="1" <?= ($product['is_recommended'] == 1) ? 'selected' : '' ?>>
                                                Yes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <span><a class="btn btn-info"
                                            href="<?= base_url('admin/products') ?>">Cancel</a></span>
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
          CKEDITOR.replace('features');

        document.getElementById('product_category').addEventListener('change', function () {
            var selectedOption = this.options[this.selectedIndex];
            document.getElementById('category_id').value = selectedOption.getAttribute('data-category-id');
            document.getElementById('subcategory_id').value = selectedOption.getAttribute('data-subcategory-id');
        });

        var preselectedOption = document.querySelector('option[selected]');
        if (preselectedOption) {
            document.getElementById('category_id').value = preselectedOption.getAttribute('data-category-id');
            document.getElementById('subcategory_id').value = preselectedOption.getAttribute('data-subcategory-id');
        }
    </script>

    <?= $this->endSection() ?>
    <?= $this->endSection() ?>
</div>