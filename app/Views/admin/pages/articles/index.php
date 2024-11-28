<div class="container">
    <?= $this->extend('admin/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('message')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('message') ?>
        </div>
    <?php endif; ?>
    <div class="page-header ">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>Articles</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('admin') ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            View Articles
                        </li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6 col-sm-12 text-right">
                <a href="<?= base_url('admin/articles/create') ?>" class="btn btn-primary">Create New Article</a>
            </div>
        </div>
    </div>

<ul>
    <?php foreach ($articles as $article): ?>
        <li>
            <a href="<?= base_url('articles/show/' . $article['id']) ?>">
                <?= esc($article['title']) ?>
            </a>
            <a href="<?= base_url('articles/edit/' . $article['id']) ?>">Edit</a>
            <a href="<?= base_url('articles/delete/' . $article['id']) ?>" 
               onclick="return confirm('Are you sure you want to delete this article?');">Delete</a>
        </li>
    <?php endforeach; ?>
</ul>

</div>

<?= $this->endSection() ?>