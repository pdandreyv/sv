@extends('layouts.app')

@section('content')
<form id="contact_form" enctype="multipart-formdata" method="post">
    {{ csrf_field() }} 
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>Имя</label>    
            </div>                                                        
        </div>
        <div class="col-md-10">
            <div class="form-group">                    
            <input type="text" class="form-control" name="name"/> 
            </div>                                                              
        </div>
    </div> 
    <div class="row">
        <div class="col-md-12 name-error">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>E-mail</label>
            </div>                                                            
        </div>
        <div class="col-md-10"> 
            <div class="form-group">                   
            <input type="text" class="form-control" name="email"/>
            </div>                                                               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 email-error">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>Телефон</label> 
            </div>                                                           
        </div>
        <div class="col-md-10">
            <div class="form-group">                    
            <input type="text" class="form-control" name="phone"/>
            </div>                                                               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 phone-error">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>Тема</label> 
            </div>                                                           
        </div>
        <div class="col-md-10">
            <div class="form-group">                    
            <input type="text" class="form-control" name="subject"/>
            </div>                                                               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 subject-error">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>Сообщение</label> 
            </div>                                                           
        </div>
        <div class="col-md-10">
            <div class="form-group">                    
            <textarea class="form-control" name="message"></textarea>                            
            </div>                                                               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 message-error">
            
        </div>
    </div>
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">                    
            <label>Файл</label> 
            </div>                                                           
        </div>
        <div class="col-md-10">
            <div class="form-group">                    
            <input type="file" class="form-control" name="file"></textarea>                            
            </div>                                                               
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
        <div class="form-group"><input class="btn btn-primary" type="submit" value="Отправить"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 send-success">
            
        </div>
    </div>
</form>
@endsection