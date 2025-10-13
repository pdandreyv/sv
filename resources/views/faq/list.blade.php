@extends('layouts.app')
@section('content')

    <div class="panel-group" id="faq-accordion" role="tablist" aria-multiselectable="true">
        @foreach($faq as $question)
            <div class="panel faq panel-info">
                <div class="panel-heading" role="tab" id="heading{{ $loop->index }}">
                    <a class="panel-title collapsed" role="button" data-toggle="collapse" data-parent="#faq-accordion" href="#collapse{{ $loop->index }}" aria-expanded="true" aria-controls="collapse{{ $loop->index }}">
                        <span>{{ $question->faq_title }}</span>
                        <span><i class="icon fas fa-plus"></i></span>
                    </a>
                </div>
                <div id="collapse{{ $loop->index }}" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading{{ $loop->index }}">
                    <div class="panel-body">
                        {{ $question->faq_content }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
<script type="text/javascript">
    $('.faq').on('show.bs.collapse', function () {
         $(this).removeClass('panel-info').addClass('panel-success');
         $(this).find('.icon').removeClass('fa-plus').addClass('fa-minus');
    });

    $('.faq').on('hide.bs.collapse', function () {
         $(this).removeClass('panel-success').addClass('panel-info');
         $(this).find('.icon').removeClass('fa-minus').addClass('fa-plus');
    });
</script>
@endsection