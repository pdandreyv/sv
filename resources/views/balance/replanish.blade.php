@extends('layouts.app')

@section('content')

@include('parts.sidebar')

    <div class="col-md-9">
        <div class="title">
            <h3>Пополнение баланса</h3>
        </div>
        <hr>
        <form method="post" class="form-horizontal" onsubmit="sendPaymentRequest(); return false;">
            {{ csrf_field() }}



            <div class="form-group col-sm-12 col-md-6">
                <label for="insert_sum">Сумма пополнения</label>
                <input type="numbers" name="insert_sum" id="insert_sum" class="form-control" placeholder="Введите сумму пополнения" required>
            </div>

            <div class="form-group col-sm-12 col-md-6">
                <label>Мой баланс</label>
                <div class="form-control balance">
                    <span class="icon"><i class="fas fa-coins"></i></span>
                    <span class="qty">{{Auth::user()->getBalanceDisplay()}}</span>
                </div>
            </div>

            <div class="form-group col-sm-12 col-md-6">
                <button type="submit" class="btn btn-success">Пополнить</button>
            </div>

        </form>

        <div id="lpay_form" style="display:none">

        </div>
        <script type="text/javascript">
            
            function sendPaymentRequest(){

                var insert_sum = $('#insert_sum').val();

                $.ajax({
                    type: "POST",
                    url: "{{route('replenish.balance.post')}}",
                    dataType: "json",
                    data:{
                        'insert_sum':insert_sum,
                    },
                    success: function(data){
                        if (parseInt( data.status ) > 0) {
                            $('#lpay_form').empty().append( data.form );
                            $('#lpay_form form').submit();
                        }
                    },
                });

            }

        </script>
    </div>

@endsection