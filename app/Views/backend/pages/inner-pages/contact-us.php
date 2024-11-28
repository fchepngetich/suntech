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
                                        <!-- <h4 class="title">Mega sale up to <span>50%</span> off for all</h4> -->
                                        <h5 class="title">Contact Us</h5>

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
                    <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="container mb-3 mt-3">
    <div class="row">
        <div class="col-md-12">
            <h5 class="">Contact Us</h5>
            <div class="contact-info py-3">
                <p>Techwin Limited  </p>
                <p class="py-2"><strong>Head Office | Service Center | Warehouse</strong></p>
                <p class="py-2">Techwin Industrial Park | Industrial Area | Homa bay Road | Off Enterprise Road | P.O.BOX 2768 –
                00200</p>
                <p class="py-2">
                    <strong>Tel:</strong> (254) 020 232 9654
                    <br>
                    <strong>Mobile:</strong> (254) 743 793 878| (254) 715-208 282
                </p>
            </div>
            <div class="showroom-info mt-2 mb-4">
                <h6>Showroom</h6>
                <p class="py-2">Techwin Industrial Park | Industrial Area
                </p>
                <p><strong>Mobile:</strong> (254) 743 793 878
                </p>
            </div>
        </div>
    </div>
</div>



   


</div>


<?= $this->endSection() ?>