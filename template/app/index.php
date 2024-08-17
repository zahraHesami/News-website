<?php
require_once BASE_PATH . '/template/app/layouts/header.php';
?>

    <div class="site-main-container">
        <!-- Start top-post Area -->
        <section class="top-post-area pt-10">
            <div class="container no-padding">
                <div class="row small-gutters">
                    <div class="col-lg-8 top-post-left">
                        <?php if (isset($topSelectedPosts[0])) { ?>
                        <div class="feature-image-thumb relative">
                            <div class="overlay overlay-bg"></div>
                            <img class="img-fluid" src="<?= asset($topSelectedPosts[0]['image']) ?>" alt="">
                        </div>
                        <div class="top-post-details">
                            <ul class="tags">
                                <li><a href="<?=url('show-category/'.$topSelectedPosts[0]['cat_id']) ?>"><?= $topSelectedPosts[0]['category'] ?></a></li>
                            </ul>
                            <a href="<?= url('show/' . $topSelectedPosts[0]['id']) ?>">
                                <h3><?= $topSelectedPosts[0]['title'] ?></h3>
                            </a>
                            <ul class="meta">
                                <li><a href="#"><span
                                                class="lnr lnr-user"></span><?= $topSelectedPosts[0]['username'] ?></a>
                                </li>
                                <li><a href="#"><?= jalaliDate($topSelectedPosts[0]['created_at']) ?><span
                                                class="lnr lnr-calendar-full"></span></a></li>
                                <li><a href="#"><?= $topSelectedPosts[0]['comments_count'] ?><span
                                                class="lnr lnr-bubble"></span></a></li>
                            </ul>
                        </div>
                    </div>
                    <?php }
                    ?>
                    <div class="col-lg-4 top-post-right">
                        <?php if (isset($topSelectedPosts[1])) { ?>
                            <div class="single-top-post">
                                <div class="feature-image-thumb relative">
                                    <div class="overlay overlay-bg"></div>
                                    <img class="img-fluid" src="<?= asset($topSelectedPosts[1]['image']) ?>" alt="">
                                </div>
                                <div class="top-post-details">
                                    <ul class="tags">
                                        <li><a href="<?=url('show-category/'.$topSelectedPosts[1]['cat_id']) ?>"><?= $topSelectedPosts[1]['category'] ?></a></li>
                                    </ul>
                                    <a href="<?= url('show/' . $topSelectedPosts[1]['id']) ?>">
                                        <h4><?= $topSelectedPosts[1]['title'] ?></h4>
                                    </a>
                                    <ul class="meta">
                                        <li><a href="#"><span
                                                        class="lnr lnr-user"></span><?= $topSelectedPosts[1]['username'] ?>
                                            </a></li>
                                        <li><a href="#"><?= jalaliDate($topSelectedPosts[1]['created_at']) ?><span
                                                        class="lnr lnr-calendar-full"></span></a></li>
                                        <li><a href="#"><?= $topSelectedPosts[1]['comments_count'] ?><span
                                                        class="lnr lnr-bubble"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        <?php }
                        if (isset($topSelectedPosts[2])) {
                            ?>
                            <div class="single-top-post mt-10">
                                <div class="feature-image-thumb relative">
                                    <div class="overlay overlay-bg"></div>
                                    <img class="img-fluid" src="<?= asset($topSelectedPosts[2]['image']) ?>" alt="">
                                </div>
                                <div class="top-post-details">
                                    <ul class="tags">
                                        <li><a href="<?=url('show-category/'.$topSelectedPosts[2]['cat_id']) ?>"><?= $topSelectedPosts[2]['category'] ?></a></li>
                                    </ul>
                                    <a href="<?= url('show/' . $topSelectedPosts[2]['id']) ?>">
                                        <h4><?= $topSelectedPosts[2]['title'] ?></h4>
                                    </a>
                                    <ul class="meta">
                                        <li><a href="#"><span
                                                        class="lnr lnr-user"></span><?= $topSelectedPosts[2]['username'] ?>
                                            </a></li>
                                        <li><a href="#"><?= jalaliDate($topSelectedPosts[2]['created_at']) ?><span
                                                        class="lnr lnr-calendar-full"></span></a></li>
                                        <li><a href="#"><?= $topSelectedPosts[2]['comments_count'] ?><span
                                                        class="lnr lnr-bubble"></span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <?php
                        } ?>
                    </div>
                    <div class="col-lg-12">
                        <div class="news-tracker-wrap">
                            <h6><span>خبر فوری:</span> <a href="#">مربی تیم ایران اخراج شد</a></h6>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End top-post Area -->
        <!-- Start latest-post Area -->
        <section class="latest-post-area pb-120">
            <div class="container no-padding">
                <div class="row">
                    <div class="col-lg-8 post-list">
                        <!-- Start latest-post Area -->
                        <div class="latest-post-wrap">
                            <h4 class="cat-title">آخرین اخبار</h4>
                            <?php foreach ($lastPosts as $lastPost) { ?>
                                <div class="single-latest-post row align-items-center">
                                    <div class="col-lg-5 post-left">
                                        <div class="feature-img relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="<?= asset($lastPost['image']) ?>" alt="">
                                        </div>
                                        <ul class="tags">
                                            <li><a href="<?=url('show-category/'.$lastPost['cat_id']) ?>"><?= $lastPost['category'] ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="col-lg-7 post-right">
                                        <a href="<?= url('show/' . $lastPost['id']) ?>">
                                            <h4><?= $lastPost['title'] ?></h4>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span
                                                            class="lnr lnr-user"></span><?= $lastPost['username'] ?></a>
                                            </li>
                                            <li><a href="#"><?= jalaliDate($lastPost['created_at']) ?><span
                                                            class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $lastPost['comments_count'] ?> <span
                                                            class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                        <p class="excert">
                                            <?= $lastPost['summary'] ?>
                                        </p>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- End latest-post Area -->
                        <?php if (!empty($bodyBanner)) { ?>
                            <!-- Start banner-ads Area -->
                            <div class="col-lg-12 ad-widget-wrap mt-30 mb-30">
                                <img class="img-fluid" src="<?= asset($bodyBanner['image']) ?>" alt="">
                            </div>
                        <?php } ?>
                        <!-- End banner-ads Area -->
                        <!-- Start popular-post Area -->
                        <div class="popular-post-wrap">
                            <h4 class="title">اخبار پربازدید</h4>
                            <?php if (isset ($popularPost[0])) { ?>
                                <div class="feature-post relative">

                                    <div class="feature-img relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid" src="<?= asset($popularPost[0]['image']) ?>" alt="">

                                    </div>
                                    <div class="details">
                                        <ul class="tags">
                                            <li><a href="<?=url('show-category/'.$popularPost[0]['cat_id']) ?>"><?= $popularPost[0]['category'] ?></a></li>
                                        </ul>
                                        <a href="<?=url('show/'.$popularPost[0]['id']) ?>">
                                            <h3><?= $popularPost[0]['title'] ?></h3>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span
                                                            class="lnr lnr-user"></span><?= $popularPost[0]['username'] ?>
                                                </a></li>
                                            <li><a href="#"><?= jalaliDate($popularPost[0]['created_at']) ?><span
                                                            class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $popularPost[0]['comments_count'] ?><span
                                                            class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset ($popularPost[1])) { ?>
                                <div class="feature-post relative">

                                    <div class="feature-img relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid" src="<?= asset($popularPost[1]['image']) ?>" alt="">

                                    </div>
                                    <div class="details">
                                        <ul class="tags">
                                            <li><a href="<?=url('show-category/'.$popularPost[1]['cat_id']) ?>"><?= $popularPost[1]['category'] ?></a></li>
                                        </ul>
                                        <a href="<?=url('show/'.$popularPost[1]['id']) ?>">
                                            <h3><?= $popularPost[1]['title'] ?></h3>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span
                                                            class="lnr lnr-user"></span><?= $popularPost[1]['username'] ?>
                                                </a></li>
                                            <li><a href="#"><?= jalaliDate($popularPost[1]['created_at']) ?><span
                                                            class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $popularPost[1]['comments_count'] ?><span
                                                            class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if (isset ($popularPost[2])) { ?>
                                <div class="feature-post relative">

                                    <div class="feature-img relative">
                                        <div class="overlay overlay-bg"></div>
                                        <img class="img-fluid" src="<?= asset($popularPost[2]['image']) ?>" alt="">

                                    </div>
                                    <div class="details">
                                        <ul class="tags">
                                            <li><a href="<?=url('show-category/'.$popularPost[2]['cat_id']) ?>"><?= $popularPost[2]['category'] ?></a></li>
                                        </ul>
                                        <a href="<?=url('show/'.$popularPost[0]['id']) ?>">
                                            <h3><?= $popularPost[2]['title'] ?></h3>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span
                                                            class="lnr lnr-user"></span><?= $popularPost[2]['username'] ?>
                                                </a></li>
                                            <li><a href="#"><?= jalaliDate($popularPost[2]['created_at']) ?><span
                                                            class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $popularPost[2]['comments_count'] ?><span
                                                            class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <!-- End popular-post Area -->
                    </div>

                    <?php
                    require_once BASE_PATH . '/template/app/layouts/sidebar.php';
                    ?>
                </div>
            </div>
        </section>
        <!-- End latest-post Area -->
    </div>


<?php
require_once BASE_PATH . '/template/app/layouts/footer.php';
?>