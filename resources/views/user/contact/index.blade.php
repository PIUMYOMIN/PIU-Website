    <x-layout>
    <!--SECTION START-->
    <section>
        <div class="container com-sp pad-bot-70">
            <div class="row">
                <div class="cor about-sp">
                    <div class="ed-about-tit">
                        <div class="con-title">
                            <h2>Contact <span> Us</span></h2>
                            <p>
                                We are available to contact in any time and can reply your contact with a short time as
                                soom as we can.
                            </p>
                        </div>
                    </div>
                    <div class="pg-contact">
                        <div class="col-md-3 col-sm-6 col-xs-12 new-con new-con1">
                            <h2>Phaugn Daw Oo <span>International University</span></h2>
                            <p>We Provide Better Eudcation To Over 2500 students around the Countries.
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 new-con new-con1"> <img src="img/contact/1.html"
                                alt="">
                            <h4>Address</h4>
                            <p>Nanshae,19 block, Between 58/59 and 62 Road, Aungmyaetarzan Tsp, Mandalay, Myanmar
                                <br>: Next to the Mandalay Moat
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 new-con new-con3"> <img src="img/contact/2.html"
                                alt="">
                            <h4>CONTACT INFO:</h4>
                            <p>
                                <a href="tel://793200074" class="contact-icon">Mobile: +09-793200074</a>
                                <br>
                                <a href="tel://09799183631" class="contact-icon">Phone: +09-799183631</a>
                                <br>
                                <a href="mailto:piu.edu2014@gmail.com" class="contact-icon">Email:
                                    piu.edu2014@gmail.com</a>
                            </p>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 new-con new-con4"> <img src="img/contact/3.html"
                                alt="">
                            <h4>Website</h4>
                            <p> <a href="#">Website: piu.edu.mm</a>
                                <br> <a href="#">Blog: piu.edu.mm/university-blogs</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

    <section id="map">
        <div class="row contact-map">
            <!-- IFRAME: GET YOUR LOCATION FROM GOOGLE MAP -->
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d6172.830896809112!2d96.2747935276627!3d22.088415612497066!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x30cb6f89b745f459%3A0x55a960cb1a2c6872!2sPhaung%20Daw%20Oo%20International%20University%20(PIU)!5e0!3m2!1sen!2smm!4v1682138429586!5m2!1sen!2smm"
                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"></iframe>
            <div class="container">
                <div class="overlay-contact footer-part footer-part-form">
                    <div class="map-head">
                        <p>Send Us Now</p>
                        <h2>GetIn Touch</h2> <span class="footer-ser-re">Service Request Form</span> </div>
                    <!-- ENQUIRY FORM -->
                    @if (Session::has('message_sent'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message_sent') }}
                        </div>
                    @endif
                    @if (Session::has('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ Session::get('error') }}
                        </div>
                    @endif
                    <form id="contact_form" name="contact_form" action="{{ route('contact.form.submit') }}" method="POST">
                        @csrf
                        @method('POST')
                        <ul>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f1" name="name" placeholder="Name" required="">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="email" id="f2" name="email" placeholder="Email" required="">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="number" id="f3" name="phone" placeholder="Phone" required="">
                                @error('phone')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </li>
                            <li class="col-md-6 col-sm-6 col-xs-12 contact-input-spac">
                                <input type="text" id="f4" name="country" placeholder="Country" required="">
                                @error('country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </li>
                            <li class="col-md-12 col-sm-12 col-xs-12 contact-input-spac">
                                <textarea id="f5" name="message" required=""></textarea>
                            </li>
                            <li class="col-md-12 col-sm-12 col-xs-12 contact-input-spac">
                                {!! NoCaptcha::display() !!}
                                @error('g-recaptcha-response')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </li>
                            <li class="col-md-6">
                                <input type="submit" value="SUBMIT"> 
                            </li>
                        </ul>
                    </form>
                </div>
            </div>
        </div>
    </section>
    </x-layout>