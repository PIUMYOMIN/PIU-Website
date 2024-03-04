<x-layout>
    <!--SECTION START-->
    <section>
        <div class="container com-sp">
            <div class="row">
                <div class="cor about-sp">
                    <div class="ed-about-tit">
                        <div class="con-title">
                            <h2>University <span> News</span></h2>
                        </div>
                        <div>
                            <div class="ho-event pg-eve-main pg-blog">
                                <ul>
                                  @forelse ($news as $new)
                                    <li>
                                        <div class="ho-ev-date pg-eve-date">
                                            <span>{{ $new->created_at->format('d') }}</span>
                                            <span>&nbsp;{{ $new->created_at->format('M,Y') }}</span>
                                        </div>
                                        <div class="pg-eve-desc pg-blog-desc">
                                            <h4>{{ $new->title }}</h4>
                                            <img src="{{ asset('storage/' . $new->image) }}" alt="">
                                            <div class="share-btn blog-share-btn">
                                                <ul>
                                                    <li>
                                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}"
                                                            onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                            <i class="fa fa-facebook fb1"></i> Share On Facebook
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://twitter.com/intent/tweet?url={{ url()->current() }}&text={{ $new->title }}&via=YourTwitterHandle"
                                                            onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                            <i class="fa fa-twitter tw1"></i> Share On Twitter
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="https://plus.google.com/share?url={{ url()->current() }}"
                                                            onclick="window.open(this.href, '_blank', 'height=500,width=800'); return false;">
                                                            <i class="fa fa-google-plus gp1"></i> Share On Google Plus
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <p>{{ Str::limit(strip_tags($new->body), 300) }}</p>
                                            <span>9:15 am – 5:00 pm</span>
                                        </div>
                                        <div class="pg-eve-reg pg-blog-reg">
                                            <a href="/news/{{ $new->slug }}">Read more</a>
                                        </div>
                                    </li>
                                    @empty
                                    <p class="text-center">No news found.</p>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                        <div class="pg-pagina">
                            <ul class="pagination">
                                <li class="disabled"><a href="#!"><i class="fa fa-angle-left"
                                            aria-hidden="true"></i></a></li>
                                <li class="active"><a href="#!">1</a></li>
                                <li class="waves-effect"><a href="#!">2</a></li>
                                <li class="waves-effect"><a href="#!">3</a></li>
                                <li class="waves-effect"><a href="#!">4</a></li>
                                <li class="waves-effect"><a href="#!">5</a></li>
                                <li class="waves-effect"><a href="#!"><i class="fa fa-angle-right"
                                            aria-hidden="true"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--SECTION END-->
</x-layout>
