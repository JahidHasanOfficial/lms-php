<!-- Newsletter Section Start -->
<div class="container-fluid py-5 newsletter-section" 
     style="background: linear-gradient(rgba(15, 23, 43, .7), rgba(15, 23, 43, .7)), url(<?php echo $newsletter['background_img']; ?>) center center no-repeat; background-size: cover; margin-top: 5rem;">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <h1 class="text-white mb-4"><?php echo $newsletter['title']; ?></h1>
                <p class="text-white-50 mb-5 p-large"><?php echo $newsletter['subtitle']; ?></p>
                <div class="position-relative w-100 mt-3">
                    <form id="newsletter-form">
                        <input class="form-control border-0 rounded-pill w-100 ps-4 pe-5" type="email" name="email" 
                               id="news-email" placeholder="Your Email Address" style="height: 58px;" required>
                        <button type="submit" class="btn btn-primary rounded-pill py-2 px-4 position-absolute top-0 end-0 m-2" 
                                style="height: 42px;">Subscribe</button>
                    </form>
                    <div id="newsletter-message" class="mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Newsletter Section End -->
