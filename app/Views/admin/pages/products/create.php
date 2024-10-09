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
                                        <label for="features">Features</label>
                                        <textarea name="features" class="form-control" id="features"></textarea>
                                    </div>
                                </div>
                            

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="category_id">Category</label>
                                        <select name="category_id" class="form-control" id="category_id" required>
                                            <option value="">Select Category</option>
                                            <?php foreach ($categories as $category): ?>
                                                <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subcategory_id">Subcategory</label>
                                        <select name="subcategory_id" class="form-control" id="subcategory_id" required>
                                            <!-- Subcategories will be dynamically loaded based on category selection -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="subsubcategory_id">Subsubcategory</label>
                                        <select name="subsubcategory_id" class="form-control" id="subsubcategory_id" >
                                            <!-- Subsubcategories will be dynamically loaded based on subcategory selection -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="image">Main Product Image</label>
                                        <input type="file" name="image" class="form-control-file" id="image" required>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="sideview_images">Side View Images</label>
                                        <input type="file" name="sideview_images[]" class="form-control-file"
                                            id="sideview_images" multiple>
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
        // Fetch subcategories based on category selection
        document.getElementById('category_id').addEventListener('change', function () {
            const categoryId = this.value;
            fetchSubcategories(categoryId);
        });

        function fetchSubcategories(categoryId) {
            fetch('<?= base_url("admin/products/getSubcategories") ?>/' + categoryId)
                .then(response => response.json())
                .then(data => {
                    const subcategorySelect = document.getElementById('subcategory_id');
                    subcategorySelect.innerHTML = ''; // Clear previous subcategories

                    data.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                });
        }

        // Fetch subsubcategories based on subcategory selection
document.getElementById('subcategory_id').addEventListener('change', function () {
    const subcategoryId = this.value;
    fetchSubsubcategories(subcategoryId);
});

function fetchSubsubcategories(subcategoryId) {
    fetch('<?= base_url("admin/products/getSubsubcategories") ?>/' + subcategoryId)
        .then(response => response.json())
        .then(data => {
            const subsubcategorySelect = document.getElementById('subsubcategory_id');
            subsubcategorySelect.innerHTML = ''; // Clear previous subsubcategories

            data.forEach(subsubcategory => {
                const option = document.createElement('option');
                option.value = subsubcategory.id;
                option.textContent = subsubcategory.name;
                subsubcategorySelect.appendChild(option);
            });
        });
}

    </script>



    <?= $this->endSection() ?>

    <?= $this->endSection() ?>