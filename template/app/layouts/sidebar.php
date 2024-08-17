<div class="col-lg-4">
                        <div class="sidebars-area">
                            <div class="single-sidebar-widget editors-pick-widget">
                                <h6 class="title">انتخاب سردبیر</h6>
                                <?php if (isset($topSelectedPosts [0])) { ?>
                                <div class="editors-pick-post">
                                    <div class="feature-img-wrap relative">
                                        <div class="feature-img relative">
                                            <div class="overlay overlay-bg"></div>
                                            <img class="img-fluid" src="<?= asset($topSelectedPosts[0]['image']) ?>" alt="">
                                        </div>
                                        <ul class="tags">
                                            <li><a href="#"><?= $topSelectedPosts[0]['category'] ?></a></li>
                                        </ul>
                                    </div>
                                    <div class="details">
                                        <a href="<?=url('show/'.$topSelectedPosts[0]['id']) ?>">
                                            <h4 class="mt-20">
                                                <?= $topSelectedPosts[0]['title'] ?>
                                            </h4>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><span class="lnr lnr-user"><?= $topSelectedPosts[0]['username'] ?></span></a></li>
                                            <li><a href="#"><?= jalaliDate($topSelectedPosts[0]['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $topSelectedPosts[0]['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>

                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                            <?php if (isset($sideBarBanner)) { ?>
                            <div class="single-sidebar-widget ads-widget">
                                <a href=" <?=   $sideBarBanner['url'] ?>">
                                    <img class="img-fluid" src="<?=     $sideBarBanner['image'] ?>" alt="">
                                </a>

                            </div>
                             <?php  }?>
                            <div class="single-sidebar-widget most-popular-widget">
                                <h6 class="title">پر بحث ترین ها</h6>
                                  <?php  foreach ($mostCommentPosts as $mostCommentPost)      {  ?>
                                <div class="single-list flex-row d-flex">
                                    <div class="thumb" >
                                        <img src="<?= asset($mostCommentPost['image']) ?>" alt="" style=" width: 100px ; height: 70px">
                                    </div>
                                    <div class="details">
                                        <a href="<?=url('show/'.$mostCommentPost['id']) ?>">
                                            <h6><?= $mostCommentPost['title'] ?></h6>
                                        </a>
                                        <ul class="meta">
                                            <li><a href="#"><?= jalaliDate($mostCommentPost['created_at']) ?><span class="lnr lnr-calendar-full"></span></a></li>
                                            <li><a href="#"><?= $mostCommentPost['comments_count'] ?><span class="lnr lnr-bubble"></span></a></li>
                                        </ul>
                                    </div>
                                </div>
                                <?php } ?>

                            </div>

                        </div>
                    </div>