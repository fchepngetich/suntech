<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>View Products</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Products
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/products/add-product') ?>" class="btn btn-primary btn-sm ">Add Product</a>
            </div>
        </div>
    </div>
    <div class="row">
        
        <div class="col-md-12">
            <div class="card card-box">
                <div class="card-body">
                <?php if (session()->getFlashdata('message') !== NULL): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?php echo session()->getFlashdata('message'); ?>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        </div>
                    <?php endif; ?>
                    <table class="data-table table nowrap dataTable no-footer dtr-inline" id="products-table" role="grid">
                        <thead>
                            <tr role="row">
                                <th>#</th>
                                <th>Product Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th class="datatable-nosort">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $count = 1; ?>
                            <?php foreach ($products as $product) : ?>
                                <tr role="row" class="<?= $count % 2 == 0 ? 'even' : 'odd' ?>">
                                    <td><?= $count++ ?></td>
                                    <td><?= htmlspecialchars($product['name']) ?></td>
                                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                                    <td>Ksh <?= htmlspecialchars($product['price']) ?></td>
                                    <td><?= htmlspecialchars($product['stock']) ?></td>

                                    <td>
                    <a href="<?= base_url('admin/products/edit-product/'.$product['slug']) ?>" class="btn edit-btn">
                        <i class="icon-copy dw dw-edit2"></i>
                    </a>
                    <a href="<?= base_url('admin/products/delete-product/'.$product['slug']) ?>" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete this product?');">
                        <i class="icon-copy dw dw-delete"></i>
                    </a>
                </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#products-table').DataTable({
        "scrollX": true,
        "autoWidth": false,
        "ordering": true,
        "columnDefs": [{
            "targets": 'datatable-nosort',
            "orderable": false
        }]
    });

    $('.delete-product-btn').on('click', function() {
        var productId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '<?= base_url('admin/products/delete-product') ?>',
                    method: 'POST',
                    data: {
                        id: productId,
                        <?= csrf_token() ?>: '<?= csrf_hash() ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.token) {
                            $('.ci_csrf_data').val(response.token);
                        }
                        if (response.status === 1) {
                            Swal.fire(
                                'Deleted!',
                                response.msg,
                                'success'
                            ).then(() => {
                                location.reload(); 
                            });
                        } else {
                            Swal.fire('Error!', response.msg, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'An error occurred. Please try again.', 'error');
                    }
                });
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
