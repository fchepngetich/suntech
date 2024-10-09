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

    <!-- File: app/Views/blogs/index.php -->
<div class="container mt-5">
 
    <table class="table table-bordered">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Image</th>
                <th scope="col">Description</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($blogs as $blog): ?>
                <tr>
                    <th scope="row"><?= $blog['id']; ?></th>
                    <td><?= $blog['title']; ?></td>
                    <td>
                        <img src="<?= base_url($blog['image']); ?>" alt="Blog Image" style="height: 100px; object-fit: cover;">
                    </td>
                    <td><?= substr($blog['description'], 0, 100); ?>...</td>
                    <td>
    <a href="<?= base_url('admin/blogs/' . $blog['id']); ?>" class="btn btn-secondary btn-sm">Read More</a>
    <a href="<?= base_url('admin/blogs/edit/' . $blog['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
    <form action="<?= base_url('admin/blogs/delete/' . $blog['id']); ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
        <input type="hidden" name="_method" value="DELETE">
        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
    </form>
</td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

</div>

<?= $this->endSection() ?>

