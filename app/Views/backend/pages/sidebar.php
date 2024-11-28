<div class="shop-sidebar mt-5">
    <div class="single-widget category">
        <h3 class="title">Filter by Categories</h3>
        <ul class="categor-list">
            <?php foreach ($subcategories as $category): ?>
                <li><a
                        href="<?= base_url('subcategories/subcategory/' . $category['slug']); ?>"><?= $category['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div class="single-widget recent-post">
        <h3 class="title">Our Recent Blogs</h3>
        <?php foreach ($blogs as $blog): ?>
    <div class="single-post">
        <div class="image">

            <img src="<?= base_url($blog['image']); ?>" alt="<?= esc($blog['title']); ?>">
        </div>
        <div class="content mt-2">
            <h5><a href="<?= base_url('blogs/show/' . $blog['id']); ?>"><?= esc($blog['title']); ?></a></h5>
            
            <ul class="comment">
                <li><i class="fa fa-calendar" aria-hidden="true"></i><?= date('M d, Y', strtotime($blog['created_at'])); ?></li>
            </ul>
        </div>
    </div>
<?php endforeach; ?>


    </div>
</div>