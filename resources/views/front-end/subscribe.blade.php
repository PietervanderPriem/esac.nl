@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" type="text/css" href="{{mix("css/vendor/tempusdominus.css")}}">
@endpush

@section('title')
{{$curPageName}}
@endsection

@section('content')
<div class="container intro-container">
    <div class="card">
        <div class="card-body">
            <h2 class="card-title">{{$curPageName}}</h2>
            {!! $content !!}
        </div>
    </div>
</div>
<div class="container">
    @if(Session::has('message'))
        <div class="alert alert-success alert-dismissable" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            {{Session::get('message')}}
        </div>
    @endif

    @if ($errors->any())
        <ul class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li class="ml-2">{{ $error}}</li>
            @endforeach
        </ul>
    @endif

    {!! Form::open(['url' => 'lidworden']) !!}
    <div class="card mt-4" id="personal-info">
        <div class="card-header">
            <h3>{{trans('user.personal')}}</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-5">
                    {!! Form::label('firstname', trans('user.firstname')) !!}
                    {!! Form::text('firstname', '', ['class' => 'form-control','required' => 'required']) !!}                    
                </div>
                <div class="form-group col-md-2">
                    {!! Form::label('preposition', trans('user.preposition')) !!}
                    {!! Form::text('preposition', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-5">
                    {!! Form::label('lastname', trans('user.lastname')) !!}
                    {!! Form::text('lastname', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('emaillbl', trans('user.email')) !!}
                    {!! Form::text('email', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('password', trans('user.password')) !!}
                    {!! Form::password('password',  ['class' => 'form-control','required' => 'required', 'minlength' => 8]) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('street', trans('user.street')) !!}
                    {!! Form::text('street', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('houseNumber', trans('user.housenumber')) !!}
                    {!! Form::text('houseNumber', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('zipcode', trans('user.zipcode')) !!}
                    {!! Form::text('zipcode', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('city', trans('user.city')) !!}
                    {!! Form::text('city', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('country', trans('user.country')) !!}
                    {!! Form::select('country', trans("countries"), 'NL', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('phonenumber', trans('user.phonenumber')) !!}
                    {!! Form::text('phonenumber', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('phonenumber_alt', trans('user.phonenumber_alt')) !!}
                    {!! Form::text('phonenumber_alt', '', ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('birthDay', trans('user.birthDay')) !!}
                    <div class="input-group date" id="birthDayBox" data-target-input="nearest">
                        <input type='text' class="form-control datetimepicker-input" id="birthDay" name="birthDay" data-target="#birthDayBox" value="" required="required">
                        <div class="input-group-append" data-target="#birthDayBox" data-toggle="datetimepicker">
                            <div class="input-group-text"><i class="ion-calendar"></i></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('gender', trans('user.gender')) !!}
                    {!! Form::select('gender',["man" => trans('user.man'), "female" => trans('user.female')], '', ['class' => 'form-control','required' => 'required','id' => 'gender']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('kind_of_member', trans('user.kind_of_member')) !!}
                    {!! Form::select('kind_of_member',trans('kind_of_member'), 'member', ['class' => 'form-control', 'required' => 'required', 'readonly' => 'readonly']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h3>{{trans('user.financial')}}</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('BIC', trans('user.BIC')) !!}
                    {!! Form::text('BIC', '', ['class' => 'form-control']) !!}
                </div>
                <div class="form-group col-md-8">
                    {!! Form::label('IBAN', trans('user.IBAN')) !!}
                    {!! Form::text('IBAN', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-4">
        <div class="card-header">
            <h3>{{trans('user.emergencyInfo')}}</h3>
        </div>
        <div class="card-body">
            <div class="form-row">
                <div class="form-group col-md-6">
                    {!! Form::label('emergencystreet', trans('user.emergencystreet')) !!}
                    {!! Form::text('emergencystreet', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-6">
                    {!! Form::label('emergencyHouseNumber', trans('user.emergencyHouseNumber')) !!}
                    {!! Form::text('emergencyHouseNumber', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    {!! Form::label('emergencyzipcode', trans('user.emergencyzipcode')) !!}
                    {!! Form::text('emergencyzipcode', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('emergencycity', trans('user.emergencycity')) !!}
                    {!! Form::text('emergencycity', '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
                <div class="form-group col-md-4">
                    {!! Form::label('emergencycountry', trans('user.emergencycountry')) !!}
                    {!! Form::select('emergencycountry',trans("countries"), '', ['class' => 'form-control','required' => 'required']) !!}
                </div>
            </div>
            <div class="form-group">
                {!! Form::label('emergencyNumber', trans('user.emergencyNumber')) !!}
                {!! Form::text('emergencyNumber', '', ['class' => 'form-control','required' => 'required']) !!}
            </div>
        </div>
    </div>

     @if($showIntroPackageForm)
         @include('front-end.intro-package-form')
     @endif

    <div class="card mt-4">
        <div class="card-header">
            <h3>{{trans('user.privacy_and_incasso')}}</h3>
        </div>
        <div class="card-body">
            <div class="accordion" id="accordion-1" data-children=".accordion-item">
                <div class="accordion-item">
                    <a data-toggle="collapse" data-parent="#accordion-1" href="#accordion-panel-1" aria-expanded="false" aria-controls="accordion-1">
                        <h5>Terms and Conditions</h5>
                        <i class="h5 ion-chevron-right"></i>
                    </a>
                    <div id="accordion-panel-1" class="collapse" role="tabpanel">
                        <p>By signing this form, you subscribe to the ESAC up until termination of your membership. Without notice, your membership of the ESAC is continued annually. Termination of membership should happen before the 1st of January by sending a letter to the address mentioned above or by sending an email to secretaris@esac.nl.</p>
                        <p>The annual contribution will be taken from your bank account via direct debit. The amount of the contribution is determined by the general members’ assembly (GMA / ALV). If you subscribe on or after the 1st of August, you have to pay a reduced contribution (of which the amount is also determined by the GMA) for the rest of that calendar year.</p>
                        <p>Being a student and being in the possession of a sports card of the Student Sports Centre Eindhoven are mandatory for all new members of the ESAC.</p>
                        <p>If you participate in mountain sports activities, having an insurance which covers (extreme) mountain sports is mandatory. NKBV membership and insurance are strongly recommended. Other insurances are also possible, but you should thoroughly check the policy. You can’t hold the ESAC liable for any possible damage or injuries.</p>
                    </div>
                </div>
                <div class="accordion-item">
                    <a data-toggle="collapse" data-parent="#accordion-1" href="#accordion-panel-2" aria-expanded="false" aria-controls="accordion-1">
                        <h5>Privacy Policy</h5>
                        <i class="h5 ion-chevron-right"></i>
                    </a>
                    <div id="accordion-panel-2" class="collapse" role="tabpanel">
                        @include('includes.privacyPolicy')
                    </div>
                </div>
                <div class="accordion-item">
                    <a data-toggle="collapse" data-parent="#accordion-1" href="#accordion-panel-3" aria-expanded="false" aria-controls="accordion-1">
                    <h5>Agreement Direct Debit SEPA</h5>
                    <i class="h5 ion-chevron-right"></i>
                    </a>
                    <div id="accordion-panel-3" class="collapse" role="tabpanel">
                        <p>
                        Collector: Eindhovense Studenten Alpen Club<br>
                        Collector ID: NL75ZZZ402360760000</span>
                        </p>
                        <p>
                            The ESAC has a direct debit agreement with Rabobank. This way, the ESAC and its members can easily handle payments of contribution and other activities, such as climbing weekends. Cash payments or manual transfers won’t be necessary, since the amount can now be automatically cashed with your written or verbal permission. The rules are listed below. These primarily contain the rights of the payee and the obligations for the ESAC.
                        </p>
                        <ul>
                            <li>You can always retain your money without giving a reason if you do not agree with the deduction from your bank account. You have 56 days (8 weeks) to order your bank office to refund the money.</li>
                            <li>The treasurer will announce the collection at least two weeks and up to two months before the money is deducted from your account.</li>
                            <li>The ESAC may only deduct an amount other than the annual subscription from your account after you have given oral or written permission.</li>
                            <li>No money will be deducted if the funds in your account are not sufficient.</li>
                            <li>If you want to terminate the contract, report this to the treasurer by sending a letter to the address included at the top of the page or by sending an email to penningmeester@esac.nl.</li>
                        </ul>
                        <p>By signing this form you authorise your bank to debit your account in accordance with the instructions from the ESAC. As is part of your rights, you are entitled to a refund from your bank under the terms and conditions with your bank. A refund must be claimed within 8 weeks starting from the date your account was debited.</p>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="form-check">
                    {!! Form::checkbox("privacy_policy",true,'',["class" => "form-check-input", "id" => "privacy_policy"]) !!}
                    {!! Form::label("privacy_policy", trans("user.privacy_policy"), ["class" => "form-check-label"]) !!}
                </div>
                <div class="form-check">
                    {!! Form::checkbox("incasso",true,'',["class" => "form-check-input", "id" => "incasso"]) !!}
                    {!! Form::label("incasso", trans("user.incasso"), ["class" => "form-check-label"]) !!}
                </div>
                <div class="form-check">
                    {!! Form::checkbox("termsconditions",true,'',["class" => "form-check-input", "id" => "termsconditions"]) !!}
                    {!! Form::label("termsconditions", trans("user.termsconditions"), ["class" => "form-check-label"]) !!}
                </div>
                <div class="g-recaptcha" data-sitekey="{{config('custom.google_recaptcha_key')}}"></div>
            </div>
        </div>
    </div>
    <div class="my-4">
        {!! Form::submit(trans('front-end/subscribe.submit'), ['class'=> 'btn btn-primary'] ) !!}
    </div>
    {!! Form::close() !!}
</div>
@endsection

@push('scripts')
    <script src="{{mix("js/vendor/moment.js")}}"></script>
    <script src="{{mix("js/vendor/tempusdominus.js")}}"></script>
    <script>
        $('#birthDayBox').datetimepicker({
            locale: 'nl',
            format: 'L',
            icons: {
                time: 'ion-clock',
                date: 'ion-calendar',
                up: 'ion-android-arrow-up',
                down: 'ion-android-arrow-down',
                previous: 'ion-chevron-left',
                next: 'ion-chevron-right',
                today: 'ion-calendar',
                clear: 'ion-trash-a',
                close: 'ion-close'
            }
        });
        $(function(){
            $('#birthDayBox').datetimepicker();
        })
        $(function () {
            $('#datetimepicker1').datetimepicker();
        });
    </script>
    <script src='https://www.google.com/recaptcha/api.js'></script>
@endpush