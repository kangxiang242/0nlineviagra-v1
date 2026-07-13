@extends('web::layout')

@section('style')
    @parent
    <link rel="stylesheet" type="text/css" href="{{ assetv('gb-static/less/page.css') }}"/>

@stop

@section('script')
    @parent
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            function debounce(func, wait) {
                let timeout;
                return function() {
                    const context = this;
                    const args = arguments;
                    clearTimeout(timeout);
                    timeout = setTimeout(() => func.apply(context, args), wait);
                };
            }


            const faqItems = document.querySelectorAll('.faq-item');


            function calculateHeights() {
                faqItems.forEach(item => {
                    const question = item.querySelector('.faq-question');
                    const answer = item.querySelector('.faq-answer');


                    const wasOpen = item.hasAttribute('open');
                    if (!wasOpen) {
                        /* item.classList.add('faq-measuring'); */
                        item.setAttribute('open', '');

                        void item.offsetHeight;
                    }


                    const questionHeight = question.offsetHeight;
                    const fullHeight = item.offsetHeight;


                    item.style.setProperty('--collapsed-height', `${questionHeight}px`);
                    item.style.setProperty('--expanded-height', `${fullHeight}px`);


                    if (!wasOpen) {
                        item.removeAttribute('open');
                        /* item.classList.remove('faq-measuring'); */
                    }
                });
            }


            calculateHeights();


            if (faqItems.length > 0) {
                faqItems[0].setAttribute('open', '');
            }


            faqItems.forEach(item => {
                item.addEventListener('toggle', function() {
                    if (this.hasAttribute('open')) {

                        faqItems.forEach(otherItem => {
                            if (otherItem !== this && otherItem.hasAttribute('open')) {
                                otherItem.removeAttribute('open');
                            }
                        });
                    }
                });
            });

            window.addEventListener('resize', debounce(calculateHeights, 250));
        });
    </script>


@stop
@section('breadcrumb')
    <nav aria-label="Breadcrumb">
        <ul class="breadcrumb">
            <li><a href="{{ URL::to('/') }}">首頁</a></li>
            <li class="active">{{ $page->title }}</li>
        </ul>
    </nav>
@stop
@section('title',$page->title)
@section('billboard-title',$page->title)
@section('billboard-desc',$page->desc)
@section('content')
    <section class="page-container">
        @foreach($faqs as $faq)
            <details class="faq-item">
                <summary class="faq-question">
                    <span class="question-text">{{ $faq->questions }}</span>
                    <i class="iconfont faq-icon">&#xeca2;</i>
                </summary>
                <p class="faq-answer">{{ $faq->answers }}</p>
            </details>
        @endforeach
    </section>
@endsection
