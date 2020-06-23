@extends('master')
    @section('content')
        <div class="container">
            <div class=""row">
                <div class="col-md-12">
                    <h1 class="center-text">CV Stefan Elmgren</h1>    
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <p><img class="img-responsive img-fluid rounded mx-auto d-block" src="images/stefan.jpg" width="400" alt="Stefan Elmgren" /></p>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-3 text-sm-left text-md-right stel-key">
                            Adress:
                        </div>
                        <div class="col-md-7 text-sm-right text-md-left stel-val">
                            Sankt Eriksplan 7<br />
                            113 20 Stockholm
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-3 text-sm-left text-md-right stel-key">
                            Tel:
                        </div>
                        <div class="col-md-7 text-sm-right text-md-left stel-val">
                            0737714005
                        </div>
                    </div>
                    <div class="row pt-3">
                        <div class="col-md-3 text-sm-left text-md-right stel-key">
                            Email:
                        </div>
                        <div class="col-md-7 text-sm-right text-md-left stel-val">
                            <a href="mailto:stefan@elmgren.nu">stefan@elmgren.nu</a>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-md-3 text-sm-left text-md-right stel-key">
                            LinkedIn:
                        </div>
                        <div class="col-md-7 text-sm-right text-md-left stel-val">
                            <a href="http://www.linkedin.com\in\stefan-elmgren-b861b8122">stefan-elmgren</a>
                        </div>
                    </div>

                    <div class="row pt-3">
                        <div class="col-md-3 text-sm-left text-md-right stel-key">
                            Personligt brev:
                        </div>
                        <div class="col-md-7 text-sm-right text-md-left stel-val">
                            Jag besitter bred kunskap inom bl.a. Java SE, Javascript, HTML och PHP. Flera språk jag har teknisk kompetens inom kan ni se under fliken <a href='{!! url('/kompetens'); !!}'>teknisk kompetens</a>.<br /><br />
Jag har arbetat med programmering på en professionell nivå tidigare, dock inte den senaste tiden men har då ändå sysslat med det privat samt genom studier. I mitt CV kan ni finna länkar till några utav mina arbetsprov som finns för granskning. Där kan ni se att jag besitter den kompetens och erfarenheten som behövs för att kunna utföra ett bra jobb.<br /><br />
Jag lär mig snabbt, är inte rädd för utmaningar och är öppen för att bevisa min kompetens och styrka inom mitt fält.<br /><br />
God service och kvalité är viktigt för mig därför har jag ett stort engagemang, är positiv och tillmötesgående i mitt arbete.<br /><br />
Det skulle vara väldigt intressant att hitta en spännande roll att utvecklas inom.<br /><br />
Med vänlig hälsning,<br />
Stefan Elmgren
                        </div>
                    </div>

                </div>
            </div>
        </div>

    @endsection
   
