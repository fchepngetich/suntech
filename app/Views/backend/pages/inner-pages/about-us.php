<div class="container">
    <?= $this->extend('backend/layout/pages-layout') ?>
    <?= $this->section('content') ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error'); ?>
        </div>
    <?php endif; ?>

    <div class="about-us">
        <section class="hero-area3">
            <div class="containers">
                <div class="row">
                    <div class="col-md-12">
                        <div id="heroCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="big-content">
                                        <div class="inners">
                                            <h4 class="title">About Us</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>
        <div class="container">
            <div class="row">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url(); ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">About Us</li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="container">
            <h5 class="text-center mb-4">Learn About Us</h5> <!-- Section Title -->
            <div class="row mt-3 mb-3">
                <div class="col-md-4">
                    <?php foreach ($about_us as $item): ?>
                        <div class="list-group-item"> <!-- Remove border -->
                            <?php if ($item['image']): ?>
                                <img src="<?= base_url('images/aboutus/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>"
                                    class="img-fluid mb-2"> <!-- Image at the top -->
                            <?php endif; ?>
                            <h5 class="mb-1"><?= esc($item['name']) ?></h5> <!-- Title below the image -->

                            <?php

                            // Limit description to 100 characters
                            $fullDescription = esc(strip_tags(html_entity_decode($item['description'])));
                            $shortDescription = substr($fullDescription, 0, 100); // Get the first 100 characters
                            ?>
                            <p class="mb-1"><?= $shortDescription ?><?php if (strlen($fullDescription) > 100)
                                  echo '...'; ?>
                            </p> <!-- Truncated description -->

                            <a href="<?= base_url('about-us/details/' . $item['id']) ?>" class="btn-link p-0">Read More</a>
                            <!-- Read More link -->
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-md-4">
                    <?php foreach ($about_us_second as $item): ?>
                        <div class="list-group-item"> <!-- Remove border -->
                            <?php if ($item['image']): ?>
                                <img src="<?= base_url('images/aboutus/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>"
                                    class="img-fluid mb-2"> <!-- Image at the top -->
                            <?php endif; ?>
                            <h5 class="mb-1"><?= esc($item['name']) ?></h5> <!-- Title below the image -->

                            <?php
                            // Limit description to 100 characters
                            $fullDescription = esc(strip_tags(html_entity_decode($item['description'])));
                            $shortDescription = substr($fullDescription, 0, 120); // Get the first 100 characters
                            ?>
                            <p class="mb-1"><?= $shortDescription ?><?php if (strlen($fullDescription) > 100)
                                  echo '...'; ?>
                            </p> <!-- Truncated description -->

                            <a href="<?= base_url('about-us/details/' . $item['id']) ?>" class="btn-link p-0">Read More</a>
                            <!-- Read More link -->
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="col-md-4">
                    <?php foreach ($about_us_third as $item): ?>
                        <div class="list-group-item"> <!-- Remove border -->
                            <?php if ($item['image']): ?>
                                <img src="<?= base_url('images/aboutus/' . $item['image']) ?>" alt="<?= esc($item['name']) ?>"
                                    class="img-fluid mb-2"> <!-- Image at the top -->
                            <?php endif; ?>
                            <h5 class="mb-1"><?= esc($item['name']) ?></h5> <!-- Title below the image -->

                            <?php
                            // Limit description to 100 characters
                            $fullDescription = esc(strip_tags(html_entity_decode($item['description'])));
                            $shortDescription = substr($fullDescription, 0, 100); // Get the first 100 characters
                            ?>
                            <p class="mb-1"><?= $shortDescription ?><?php if (strlen($fullDescription) > 100)
                                  echo '...'; ?>
                            </p> <!-- Truncated description -->

                            <a href="<?= base_url('about-us/details/' . $item['id']) ?>" class="btn-link p-0">Read More</a>
                            <!-- Read More link -->
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="row">
                <?php foreach ($about_us_market as $item): ?>
                    <div class="col-md-12 mb-4">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <!-- Left Column: Image -->
                                <div class="col-md-6">
                                    <?php if ($item['image']): ?>
                                        <img src="<?= base_url('images/aboutus/' . $item['image']) ?>"
                                            alt="<?= esc($item['name']) ?>" class="img-fluid img-thumbnail">
                                        <!-- Adjust width as needed -->
                                    <?php endif; ?>
                                </div>

                                <!-- Right Column: Title and Description -->
                                <div class="col-md-6">
                                    <h5 class="mb-1"><?= esc($item['name']) ?></h5>

                                    <?php
                                    $fullDescription = esc(strip_tags(html_entity_decode($item['description'])));
                                    $shortDescription = substr($fullDescription, 0, 300);
                                    ?>
                                    <p class="mb-1">
                                        <?= $shortDescription ?>    <?php if (strlen($fullDescription) > 300)
                                                  echo '...'; ?>
                                    </p> <!-- Truncated description -->

                                    <a href="<?= base_url('about-us/details/' . $item['id']) ?>" class="btn-link">Read
                                        More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>





            <div class="list-group">
                <?php foreach ($about_us_choose_us as $item): ?>
                    <div class="list-group-item">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="text-center p-2">
                                    <h5 class="mb-1"><?= esc($item['name']) ?></h5>
                                </div>

                                <!-- Display paragraph at the top -->
                                <?php
                                $dom = new DOMDocument();
                                @$dom->loadHTML($item['description']);
                                $paragraphs = $dom->getElementsByTagName('p');
                                $listItems = $dom->getElementsByTagName('li');
                                ?>

                                <?php if ($paragraphs->length > 0): ?>
                                    <p class="mb-3">
                                        <?= $paragraphs->item(0)->textContent; ?>
                                    </p>
                                <?php endif; ?>

                                <!-- Display list items in Bootstrap cards with col-md-3 -->
                                <div class="row">
                                    <?php foreach ($listItems as $index => $li): ?>
                                        <div class="col-md-4 mb-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <span class="short-text">
                                                        <?= substr($li->textContent, 0, 130); ?>...
                                                    </span>
                                                    <span class="full-text" style="display: none;">
                                                        <?= $li->textContent; ?>
                                                    </span>
                                                    <a href="javascript:void(0);" class="toggle-text btn-link p-0">Read
                                                        more</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <?php if ($item['image']): ?>
                                <div class="col-md-6 text-right">
                                    <img src="<?= base_url('images/aboutus/' . $item['image']) ?>"
                                        alt="<?= esc($item['name']) ?>" class="img-fluid img-thumbnail mt-2">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="container">
                <div class="row mt-5 mb-5">
                    <!-- Title Section -->
                    <div class="col-md-3">
                        <div class="text-center mt-5">
                            <h5 class="mb-1">What We Do: Our Energy Solutions</h5>
                        </div>
                    </div>

                    <!-- Cards Section -->
                    <div class="col-md-9">
                        <div class="row">
                            <?php foreach ($about_us_what_we_do as $item): ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div>
                                                <!-- Image on the left -->
                                                <?php if ($item['image']): ?>
                                                    <div>
                                                        <img src="<?= base_url('images/aboutus/' . $item['image']) ?>"
                                                            alt="<?= esc($item['name']) ?>" class="img-fluid">
                                                    </div>
                                                <?php endif; ?>

                                                <!-- Title on the right -->
                                                <div>
                                                    <h5 class="mb-1"><?= esc($item['name']) ?></h5>
                                                </div>
                                            </div>

                                            <!-- Description at the bottom with Read More / Read Less toggle -->
                                            <div>
                                                <?php
                                                $fullDescription = strip_tags($item['description']);
                                                $shortDescription = substr($fullDescription, 0, 100); // Limit text to 100 chars
                                                ?>
                                                <p>
                                                    <span class="short-description"><?= esc($shortDescription) ?>...</span>
                                                    <span class="full-description"
                                                        style="display: none;"><?= esc($fullDescription) ?></span>
                                                    <a href="javascript:void(0);" class="read-more-toggle">Read
                                                        More</a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Toggle function for both "Choose Us" and "What We Do"
        document.querySelectorAll('.toggle-text').forEach(button => {
            button.addEventListener('click', function () {
                const cardBody = this.closest('.card-body');
                const shortText = cardBody.querySelector('.short-text');
                const fullText = cardBody.querySelector('.full-text');

                if (fullText.style.display === 'none') {
                    fullText.style.display = 'inline';
                    shortText.style.display = 'none';
                    this.textContent = 'Read less';
                } else {
                    fullText.style.display = 'none';
                    shortText.style.display = 'inline';
                    this.textContent = 'Read more';
                }
            });
        });

        document.querySelectorAll('.read-more-toggle').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const shortDesc = this.previousElementSibling.previousElementSibling;
                const fullDesc = this.previousElementSibling;

                if (fullDesc.style.display === 'none') {
                    fullDesc.style.display = 'inline';
                    shortDesc.style.display = 'none';
                    this.textContent = 'Read Less';
                } else {
                    fullDesc.style.display = 'none';
                    shortDesc.style.display = 'inline';
                    this.textContent = 'Read More';
                }
            });
        });
    });
</script>

<?= $this->endSection() ?>