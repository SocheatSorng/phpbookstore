<footer id="footer" class="pt-5">
    <div class="container">
        <div class="row">
            <div class="footer-top-area">
                <div class="row d-flex flex-wrap justify-content-between">
                    <div class="col-lg-3 col-sm-6 pb-3">
                        <div class="footer-menu">
                            <img src="<?=ASSETS?>images/main-logo.png" alt="logo" class="img-fluid mb-2">

                            <div class="social-links">
                                <ul class="d-flex list-unstyled">
                                    <li>
                                        <a href="#">
                                            <svg class="facebook">
                                                <use xlink:href="#facebook" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg class="instagram">
                                                <use xlink:href="#instagram" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg class="twitter">
                                                <use xlink:href="#twitter" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg class="linkedin">
                                                <use xlink:href="#linkedin" />
                                            </svg>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <svg class="youtube">
                                                <use xlink:href="#youtube" />
                                            </svg>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-sm-6 pb-3">
                        <div class="footer-menu text-capitalize">
                            <h5 class="widget-title pb-2">Quick Links</h5>
                            <ul class="menu-list list-unstyled text-capitalize">
                                <li class="menu-item mb-1">
                                    <a href="home">Home</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="about">About</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="shop">Shop</a>
                                </li>
                                <!-- <li class="menu-item mb-1">
                                    <a href="blog">Blogs</a>
                                </li> -->
                                <li class="menu-item mb-1">
                                    <a href="contact">Contact</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- <div class="col-lg-3 col-sm-6 pb-3">
                        <div class="footer-menu text-capitalize">
                            <h5 class="widget-title pb-2">Help & Info Help</h5>
                            <ul class="menu-list list-unstyled">
                                <li class="menu-item mb-1">
                                    <a href="#">Track Your Order</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="#">Returns Policies</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="#">Shipping + Delivery</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="#">Contact Us</a>
                                </li>
                                <li class="menu-item mb-1">
                                    <a href="#">Faqs</a>
                                </li>
                            </ul>
                        </div>
                    </div> -->
                    <div class="col-lg-3 col-sm-6 pb-3">
                        <div class="footer-menu contact-item">
                            <h5 class="widget-title text-capitalize pb-2">Contact Us</h5>
                            <p>Do you have any queries or suggestions? <a href="mailto:"
                                    class="text-decoration-underline">socheat@gmail.com & sastra@gmail.com</a></p>
                            <p>If you need support? Just give us a call. <a href="#"
                                    class="text-decoration-underline">+855 123 45678</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="floating-icon" id="chat-trigger">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
        stroke-linecap="round" stroke-linejoin="round">
        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
    </svg>
</div>

<div class="chat-widget">
    <div class="chat-header">
        <span>Chat with AI</span>
        <button class="chat-close">&times;</button>
    </div>
    <div class="chat-messages"></div>
    <div class="chat-input-container">
        <textarea placeholder="Type your message..." rows="3"></textarea>
        <button type="button" class="send-button">Send</button>
    </div>
</div>

<link rel="stylesheet" href="<?=ASSETS?>css/floating-chat.css">
<script src="<?=ASSETS?>js/jquery-1.11.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
<script type="text/javascript" src="<?=ASSETS?>js/script.js"></script>
<script src="<?=ASSETS?>js/floating-chat.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    new FloatingChat();
});
</script>
</body>

</html>