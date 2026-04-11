<?php
require_once 'config/session.php';
require_once 'includes/header.php';
?>

<style>
    /* Premium Page Header */
    .contact-header {
        background: linear-gradient(135deg, #111c26 0%, #1a2a3a 100%);
        padding: 100px 0;
        position: relative;
        overflow: hidden;
    }

    .contact-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at 20% 30%, rgba(43, 197, 212, 0.15) 0%, transparent 50%),
                    radial-gradient(circle at 80% 70%, rgba(43, 197, 212, 0.1) 0%, transparent 50%);
        pointer-events: none;
    }

    .contact-header::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-image: radial-gradient(#2bc5d4 0.5px, transparent 0.5px);
        background-size: 30px 30px;
        opacity: 0.1;
    }

    .contact-header h1 {
        font-size: 3.5rem;
        font-weight: 800;
        background: linear-gradient(to right, #fff, #2bc5d4);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-bottom: 1rem;
    }

    .contact-header p {
        color: rgba(255,255,255,0.7);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Contact Info Cards */
    .contact-info-section {
        margin-top: -50px;
        position: relative;
        z-index: 10;
        margin-bottom: 80px;
    }

    .info-card {
        background: #ffffff;
        padding: 30px;
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        border: 1px solid rgba(43, 197, 212, 0.1);
        text-align: center;
        transition: all 0.3s ease;
        height: 100%;
    }

    .info-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(43, 197, 212, 0.1);
        border-color: #2bc5d4;
    }

    .info-icon {
        width: 70px;
        height: 70px;
        background: rgba(43, 197, 212, 0.1);
        color: #2bc5d4;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        border-radius: 50%;
        margin: 0 auto 20px;
        transition: 0.3s;
    }

    .info-card:hover .info-icon {
        background: #2bc5d4;
        color: #fff;
    }

    .info-card h5 {
        font-weight: 700;
        color: #111c26;
        margin-bottom: 10px;
    }

    .info-card p {
        color: #666;
        margin-bottom: 0;
        font-size: 0.95rem;
    }

    /* Contact Form Section */
    .contact-form-section {
        padding-bottom: 100px;
    }

    .form-container {
        background: #fff;
        padding: 50px;
        border-radius: 30px;
        box-shadow: 0 30px 60px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.02);
    }

    .contact-form label {
        font-weight: 600;
        color: #444;
        margin-bottom: 8px;
    }

    .contact-form .form-control {
        border-radius: 12px;
        padding: 15px 20px;
        border: 1.5px solid #edf2f7;
        background: #f8fafc;
        font-size: 1rem;
        transition: 0.3s;
    }

    .contact-form .form-control:focus {
        background: #fff;
        border-color: #2bc5d4;
        box-shadow: 0 0 0 4px rgba(43, 197, 212, 0.1);
    }

    .btn-send {
        background: #2bc5d4;
        color: #fff;
        border: none;
        padding: 18px 40px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 1.1rem;
        transition: 0.3s;
        box-shadow: 0 10px 20px rgba(43, 197, 212, 0.2);
    }

    .btn-send:hover {
        background: #111c26;
        transform: translateY(-2px);
        box-shadow: 0 15px 30px rgba(17, 28, 38, 0.2);
        color: white;
    }

    /* Map Styling */
    .map-container {
        border-radius: 30px;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05);
        height: 100%;
        min-height: 400px;
        border: 1px solid rgba(0,0,0,0.02);
    }
</style>

<?php 
$pageTitle = "Contact Us";
include 'includes/breadcrumb.php'; 
?>

<!-- Info Cards Section -->
<section class="contact-info-section">
    <div class="container">
        <div class="row g-4 justify-content-center">
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.1s">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa fa-map-marker-alt"></i>
                    </div>
                    <h5>Our Office</h5>
                    <p>H-15, Road-04, Block-A,<br>Banani, Dhaka-1213, Bangladesh</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa fa-phone-alt"></i>
                    </div>
                    <h5>Call Us</h5>
                    <p>+880 1700 000 000<br>Mon - Sat (10am - 8pm)</p>
                </div>
            </div>
            <div class="col-md-4 wow fadeInUp" data-wow-delay="0.3s">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="fa fa-envelope"></i>
                    </div>
                    <h5>Email Us</h5>
                    <p>support@interactivecares.com<br>info@interactivecares.com</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact Form & Map Section -->
<section class="contact-form-section">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="form-container">
                    <h3 class="fw-bold mb-4" style="color: #111c26;">Send us a message</h3>
                    <form id="contact-form" class="contact-form">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="subject">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject" placeholder="What is this about?">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" name="message" id="message" rows="5" placeholder="Write your message here..." required></textarea>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <button type="submit" class="btn btn-send w-100" id="submit-btn">
                                    <span class="btn-text">Send Message</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                                </button>
                            </div>
                        </div>
                        <div id="form-response" class="mt-4"></div>
                    </form>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.1s">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14604.424270273766!2d90.39568777174411!3d23.797911438914614!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c70e06000001%3A0xe74e92b8d03099c2!2sBanani%20Model%20Town%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1692186000000!5m2!1sen!2sbd" 
                        width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contact-form');
    const submitBtn = document.getElementById('submit-btn');
    const responseDiv = document.getElementById('form-response');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnSpinner = submitBtn.querySelector('.spinner-border');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Toggle loading state
            submitBtn.disabled = true;
            btnText.textContent = 'Sending...';
            btnSpinner.classList.remove('d-none');
            responseDiv.innerHTML = '';

            const formData = new FormData(this);

            fetch('ajax/submit_contact.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    responseDiv.innerHTML = `<div class="alert alert-success border-0 shadow-sm" style="border-radius: 12px;"><i class="fa fa-check-circle me-2"></i>${data.message}</div>`;
                    contactForm.reset();
                } else {
                    responseDiv.innerHTML = `<div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;"><i class="fa fa-exclamation-circle me-2"></i>${data.message}</div>`;
                }
            })
            .catch(err => {
                responseDiv.innerHTML = `<div class="alert alert-danger border-0 shadow-sm" style="border-radius: 12px;"><i class="fa fa-exclamation-circle me-2"></i>Something went wrong. Please try again.</div>`;
            })
            .finally(() => {
                submitBtn.disabled = false;
                btnText.textContent = 'Send Message';
                btnSpinner.classList.add('d-none');
            });
        });
    }
});
</script>

<?php require_once 'includes/footer.php'; ?>
