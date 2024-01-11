<!DOCTYPE html>
<html lang="en">

<x-layout>
    <x-slot name="title">User Verification Check Completion</x-slot>
    <!-- SLIDER -->

    <!-- QUICK LINKS -->

    <!--SECTION START-->
    <section>
        <div class="full-bot-book">
            <div class="container">
                <div class="row">
                    @if (isset($admission))
                        <div class="bot-book">
                            <div class="col-md-2 bb-img">
                                <img src="images/3.png" alt="">
                            </div>
                            <div class="col-md-7 bb-text">
                                <h4>Application Submitted Successfully.</h4>
                                <p>{{ Session::get('status') }}</p>
                                <!-- Access admission details if needed -->
                                <p>Name: {{ $admission->name }}</p>
                                <p>Email: {{ $admission->email }}</p>
                                <!-- Add other admission details as needed -->
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->

</x-layout>
