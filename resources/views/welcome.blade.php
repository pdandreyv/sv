<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Светоград</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto" >

        <!--Bootstrap 4 CDN-->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">

        <!-- Custom Styles -->
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="css/media.css">
    </head>
    <body class="landing-page">
        <a class="welcome-contact-open" data-toggle="modal" href="{{route('contact.form')}}"><span class="fa fa-envelope contact-open-icon"></span></a>
        <div class="top">
            @if (Route::has('login'))
                <div class="container hero-top-bar">
                    <div class="top-services">
                        <a href="{{ route('products.goods') }}" class="btn top-service-btn">Наши товары</a>
                        <a href="{{ route('products.services') }}" class="btn top-service-btn">Наши услуги</a>
                    </div>
                    <div class="cabinet-mini">
                        <div class="cabinet-mini-title">Личный кабинет</div>
                        @auth
                            <a href="{{ route('profile.my-page', ['id' => Auth::user()->id]) }}" class="btn cabinet-login-btn">Открыть кабинет</a>
                        @else
                            <form method="POST" action="{{ route('login') }}">
                                {{ csrf_field() }}
                                <input type="text" name="email" class="cabinet-input" placeholder="Логин">
                                <input type="password" name="password" class="cabinet-input" placeholder="Пароль">
                                <button type="submit" class="btn cabinet-login-btn">Войти</button>
                            </form>
                        @endauth
                    </div>
                </div>
            @endif
            <div class="container hero-content">
                <div class="row">
                    <div class="title col-12 text-center">
                        <img src="/images/logo.png" alt="Светоград" class="hero-logo">
                        <div class="hero-brand">Светоград</div>
                    </div>
                    <div class="hero-subtitle col-12 text-center">
                        Экологическое кооперативное пространство<br> здоровья, благополучия и <br>совместного развития
                    </div>
                    <div class="hero-actions col-12 text-center">
                        <a href="{{ route('register') }}" class="btn hero-btn hero-btn-primary">Вступить в кооператив</a>
                        <a href="#about-section" class="btn hero-btn hero-btn-light">Узнать подробнее</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="about" id="about-section">
            <div class="left">
                <div class="title"><span>Кратко о кооперативном движении</span></div>
                <div class="text">
                    <p><b>Кооператив</b> — это объединение людей на добровольной основе с целью удовлетворения своих общих экономических, социальных и культурных потребностей.</p>
                    <p><b>Мы основываемся на таких ценностях</b>, как самоорганизация, самоуправление, взаимопомощь, взаимоподдержка, личная ответственность, честность, открытость, ответственность перед обществом и забота о других людях.</p>
                </div>
            </div>
        </div>
        <div class="items">
            <div class="title">
                <span>Основные принципы кооперации</span>
            </div>
            <ul class="row principles-grid">
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi1.png" alt="Добровольное членство">
                        <h4>Добровольное членство и открытый состав</h4>
                        <p>Кооперативы являются добровольными организациями, открытыми для всех лиц, которые могут использовать их услуги и готовы взять на себя все связанные с членством обязанности без дискриминации по тендерным, социальным, расовым, политическим или религиозным признакам.</p>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi2.png" alt="Демократический контроль">
                        <h4>Демократический контроль со стороны членов</h4>
                        <p>Кооперативы — это демократические организации, контролируемые их членами, которые активно участвуют в разработке политики и принятии решений. Люди, выполняющие функции выборных представителей, отчитываются перед членами кооперативов. Члены имеют равное право голоса.</p>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi3.png" alt="Экономическое участие">
                        <h4>Участие членов в экономической деятельности</h4>
                        <p>Основной капитал кооператива складывается из взносов его членов. Часть такого капитала является общей собственностью кооператива. Члены кооператива выделяют получаемую прибыль для достижения следующих целей: развитие кооператива путем создания резервов, хотя бы часть которых является неделимой; распределение доходов среди членов пропорционально их взносам и поддержка других видов деятельности, утвержденных членами кооператива.</p>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi4.png" alt="Образование и информация">
                        <h4>Образование, профессиональная подготовка и информация</h4>
                        <p>Кооперативы обеспечивают образование и профессиональную подготовку своих членов, выборных представителей, руководителей и работников, с тем чтобы они могли эффективно способствовать развитию их кооперативов. Они информируют представителей широкой общественности, в первую очередь молодежь и лидеров движений, о характере и результатах кооперации.</p>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi5.png" alt="Автономия и независимость">
                        <h4>Автономия и независимость</h4>
                        <p>Кооперативы — это автономные организации, действующие на основе самопомощи под контролем их членов. Если они заключают соглашения с другими организациями, в том числе с правительствами, или изыскивают средства из внешних источников, они делают это на условиях, обеспечивающих демократический контроль со стороны их членов и сохранение автономии кооперативов.</p>
                    </div>
                </li>
                <li class="col-md-4 col-sm-6 col-12 principle-item">
                    <div class="principle-card">
                        <img src="/images/principi6.png" alt="Сотрудничество кооперативов">
                        <h4>Сотрудничество кооперативов</h4>
                        <p>Кооперативы с максимальной эффективностью служат интересам своих членов и укрепляют кооперативное движение путем совместной работы в рамках местных, национальных, региональных и международных структур.</p>
                    </div>
                </li>
                <li class="col-md-4 col-12 principle-item principle-item-last">
                    <div class="principle-card">
                        <img src="/images/principi7.png" alt="Забота об обществе">
                        <h4>Забота об обществе</h4>
                        <p>Кооперативы действуют на основе одобренной их членами политики в целях достижения устойчивого развития своих общин.</p>
                    </div>
                </li>
            </ul>
        </div>
        <section class="mission-footer-section">
            <div class="important">
                <div class="important-card">
                    <div class="title">
                        <span>Наши цели и миссия</span>
                    </div>
                    <ul class="text">
                        <li>
                            <img src="/images/cel1.png" alt="Цель 1">
                            <span>Увеличение благосостояния каждого участника</span>
                        </li>
                        <li>
                            <img src="/images/cel2.png" alt="Цель 2">
                            <span>Развитие малого предпринимательства и индивидуального фермерского хозяйства</span>
                        </li>
                        <li>
                            <img src="/images/cel3.png" alt="Цель 3">
                            <span>Стабильность и независимость нашего общества от негативно воздействующих факторов внешней среды</span>
                        </li>
                        <li>
                            <img src="/images/cel4.png" alt="Цель 4">
                            <span>Здоровый образ жизни, здоровое питание</span>
                        </li>
                        <li>
                            <img src="/images/cel5.png" alt="Цель 5">
                            <span>Активное участие в социально-культурной жизни общества</span>
                        </li>
                    </ul>
                </div>
            </div>
            <footer class="footer-home">
                <div class="container-fluid">
                    @include('parts.footer')
                </div>
            </footer>
        </section>
        <!--div class="bottom row">
            <div class="col-12 title">
                <span>Программы кооператива</span>
            </div>
        </div>
        <div class="bottom row bottom-programs">
            <div class="col-3 pr">
                <div class="number col-12 row">
                    <img src="/images/set.png">
                </div> 
                <div class="text col-12">
                    <span>Потребительская сеть</span>
                </div>
            </div>
            <div class="col-3 pr">
                <div class="number col-12 row">
                    <img src="/images/zdrav.png">
                </div> 
                <div class="text col-12">
                    <span>Здравница</span>
                </div>
            </div>
            <div class="col-3 pr">
                <div class="number col-12 row">
                    <img src="/images/stroit.png">
                </div> 
                <div class="text col-12">
                    <span>Строительство</span>
                </div>
            </div>
            <div class="col-3 pr">
                <div class="number col-12 row">
                    <img src="/images/transp.png">
                </div> 
                <div class="text col-12">
                    <span>Транспорт</span>
                </div>
            </div>
        </div-->
        <div class="modal fade" id="contactFormModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Отправить заявку</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
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
              </div>
            </div>
          </div>
        </div>        
    </body>
</html>
