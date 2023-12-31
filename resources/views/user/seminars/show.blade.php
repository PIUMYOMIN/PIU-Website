<x-layout>
  <section class="c-all p-semi">
        <div class="semi-inn">
            <div class="semi-com semi-left">
                <div class="all-title quote-title qu-new semi-text">
                    <h2>Seminar 2018</h2>
                    <p>{{ $seminar->description }}</p>
                    <div class="semi-deta">
                        <ul>
                            <li>DATE:<span>{{ $seminar->date }}</span></li>
                            <li>Time:<span>{{ $seminar->time }}</span></li>
                            <li>Time:<span>{{ $seminar->seat }}</span></li>
                            <li>Topic:<span>{{ $seminar->name }}</span></li>
                            <li>Location:<span>{{ $seminar->location }}, {{ $seminar->city }}, {{ $seminar->country }}</span></li>
                        </ul>
                    </div>
                    <p class="help-line">Join this for free!</p>
                </div>
            </div>
            <div class="semi-com semi-right">
                <div class="n-form-com semi-form">
                    <div class="col s12">
                        <form class="form-horizontal" action="{{ route('admin.seminar.enroll.submit') }}" method="POST">
                          @csrf
                          @method('POST')
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" name="name" class="form-control" placeholder="Name" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="number" name="phone" class="form-control" placeholder="Phone number" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" name="city" class="form-control" placeholder="City">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" name="country" class="form-control" placeholder="Country">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    {!! NoCaptcha::display() !!}
                                </div>
                            </div>
                            <input type="hidden" name="seminar_id" value="{{ $seminar->id }}">
                            <div class="form-group mar-bot-0">
                                <div class="col-md-12">
                                    <i class="waves-effect waves-light light-btn waves-input-wrapper" style=""><input type="submit" value="APPLY NOW" class="waves-button-input"></i>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>