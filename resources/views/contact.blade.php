@extends('layouts.master')

@section('title', 'Contact')

@section('content')

 {{-- <!-- Page Header Start -->
 <div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Pages</a></li>
                <li class="breadcrumb-item text-white" aria-current="page">Contact Us</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End --> --}}


{{-- <!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Contact Us</h4>
                <h1 class="display-3">Contact For Any Query</h1>
                <p class="mb-5">The contact form is currently inactive. Get a functional and working contact form with Ajax & PHP in a few minutes. Just copy and paste the files, add a little code and you're done. <a href="https://htmlcodex.com/contact-form">Download Now</a>.</p>
            </div>
            <div class="row g-5 mb-5">
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                    <div class="d-flex w-100 border border-primary p-4 rounded bg-white">
                        <i class="fas fa-map-marker-alt fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Address</h4>
                            <p class="mb-2">104 North tower New York, USA</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                    <div class="d-flex w-100 border border-primary p-4 rounded bg-white">
                        <i class="fas fa-envelope fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Mail Us</h4>
                            <p class="mb-2">info@example.com</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                    <div class="d-flex w-100 border border-primary p-4 rounded bg-white">
                        <i class="fa fa-phone-alt fa-2x text-primary me-4"></i>
                        <div class="">
                            <h4>Telephone</h4>
                            <p class="mb-2">(+012) 3456 7890 123</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                    <form action="">
                        <input type="text" class="w-100 form-control py-3 mb-5 border-primary" placeholder="Your Name">
                        <input type="email" class="w-100 form-control py-3 mb-5 border-primary" placeholder="Enter Your Email">
                        <textarea class="w-100 form-control mb-5 border-primary" rows="8" cols="10" placeholder="Your Message"></textarea>
                        <button class="w-100 btn btn-primary form-control py-3 border-primary text-white bg-primary" type="submit">Submit</button>
                    </form>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="border border-primary h-100 rounded">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d387191.0360649959!2d-74.3093289654168!3d40.69753996411732!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c24fa5d33f083b%3A0xc80b8f06e177fe62!2sNew%20York%2C%20NY%2C%20USA!5e0!3m2!1sen!2sbd!4v1691911295047!5m2!1sen!2sbd" 
                        class="w-100 h-100 rounded" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End --> --}}





<!-- Page Header Start -->
<div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-2 text-white mb-4">Contact Us</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a> </li>
                <li class="breadcrumb-item text-white" aria-current="page">Contact Us</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->

<!-- Contact Start -->
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="p-5 bg-light rounded">
            <div class="mx-auto text-center wow fadeIn" data-wow-delay="0.1s" style="max-width: 700px;">
                <h4 class="text-primary mb-4 border-bottom border-primary border-2 d-inline-block p-2 title-border-radius">Contact Us</h4>
                <h1 class="display-3">Contact For Any Query</h1>
                <p class="mb-5">
                    Have a question or an idea to share? We're excited to hear from you! Our support team is always ready to listen and assist you as quickly as possible. Reach out now — we're here to help!
                </p>
                            </div>
            <div class="row g-5">
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.3s">
                    <form action="{{ route('contact.store') }}" method="POST">
                        @csrf
                        <input type="text" class="w-100 form-control py-3 mb-5 border-primary" placeholder="Your Name" name="name" required>
                        <input type="email" class="w-100 form-control py-3 mb-5 border-primary" placeholder="Enter Your Email" name="email" required>
                        <textarea class="w-100 form-control mb-5 border-primary" rows="8" cols="10" placeholder="Your Message" name="message" required></textarea>
                        <button class="w-100 btn btn-primary form-control py-3 border-primary text-white bg-primary" type="submit">Submit</button>
                    </form>
                </div>
                <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                    <div class="border border-primary h-100 rounded">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2689.8900905798477!2d35.93907111559772!3d31.95590327864671!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x151c7e698feff431%3A0xd9830ca46cbe0f4d!2sAbdali%2C%20Amman%2C%20Jordan!5e0!3m2!1sen!2sus!4v1691911295047!5m2!1sen!2sus"
                        class="w-100 h-100 rounded shadow-lg" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" style="border:0; border-radius: 15px;">
                    </iframe>
                    
                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact End -->

@endsection




















