<?= $this->extend('admin/layout/pages-layout') ?>
<?= $this->section('content') ?>

<div class="container">
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
    <div class="container card mt-5">

    <table class="table table-bordered">
    <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Image</th>
            <th scope="col">Description</th>
            <th scope="col">Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($blogs as $blog): ?>
            <tr>
                <td><?= esc($blog['title']); ?></td> <!-- Use esc() to prevent XSS vulnerabilities -->
                <td>
                    <img src="<?= base_url($blog['image']); ?>" alt="Blog Image"
                        style="height: 100px; object-fit: cover;">
                </td>
                <td><?= esc(substr(html_entity_decode(strip_tags($blog['description'])), 0, 100)); ?>...</td>
                <td>
                    <!-- Dropdown Trigger with Icon -->
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Action <!-- Gear icon for actions (optional) -->
                        </button>
                        <div class="dropdown-menu">
                            <!-- View Option -->
                            <a class="dropdown-item" href="<?= base_url('admin/blogs/' . $blog['id']); ?>">
                                <i class="fas fa-eye"></i> View
                            </a>

                            <!-- Edit Option -->
                            <a class="dropdown-item" href="<?= base_url('admin/blogs/edit/' . $blog['id']); ?>">
                                <i class="fas fa-edit"></i> Edit
                            </a>

                            <!-- Delete Option -->
                            <form action="<?= base_url('admin/blogs/delete/' . $blog['id']); ?>" method="post" style="display:inline;" onsubmit="return confirm('Are you sure you want to delete this blog?');">
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="dropdown-item text-danger" style="background: transparent; border: none;">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

    </div>

</div>

<?= $this->endSection() ?>