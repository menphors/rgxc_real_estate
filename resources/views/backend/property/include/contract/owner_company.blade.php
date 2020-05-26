<!DOCTYPE html>
<html>
<head>
    <title>Print</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">
    <link href="https://fonts.googleapis.com/css?family=Battabang&display=swap" rel="stylesheet">
    <style>
        @page { size: A4 }
        .top-title article h1     {
            font-family: 'Battabang', cursive; font-size: 22px; line-height: 12mm;
            text-align: center;
        }
        .top-title article h2.second-title{
            font-family: 'Battabang', cursive; font-size: 17px; line-height: 7mm;
            text-align: center;
            margin-top: 10mm;
        }
        .top-title article h2{
            font-family: 'Battabang', cursive; font-size: 17px; line-height: 7mm;
            text-align: center;
        }
        .top-title article p.style {
            text-align: center;
        }
        .top-title article p.style::after {
            content: "__________";
            width: 150px;
            color: white;
            background: url({{url('line-break.svg')}}) no-repeat !important;
        }
        .top-title article p{
            font-family: 'Battabang', cursive; font-size: 14px; line-height: 7mm;
        }
        .align-center {
            text-align: center;
        }
        .padding-l-r-30px {
            padding-left: 30px;
            padding-right: 30px;
        }
        h4     { font-size: 32pt; line-height: 14mm }
        h2 + p { font-size: 18pt; line-height: 7mm }
        h3 + p { font-size: 14pt; line-height: 7mm }
        /*li     { font-size: 11pt; line-height: 5mm }
        h1      { margin: 0 }
        h1 + ul { margin: 2mm 0 5mm }*/
        /*h2, h3  { margin: 0 3mm 3mm 0; float: left }*/
        /*h2 + p,*/
        /*h3 + p  { margin: 0 0 3mm 50mm }*/
        h4      { margin: 2mm 0 0 50mm; border-bottom: 2px solid black }
        h4 + ul { margin: 5mm 0 0 50mm }
        /*article { border: 4px double black; padding: 5mm 10mm; border-radius: 3mm }*/

        #A4 {
            width: 960px;
        }
        .align-right {
            text-align: right;
        }

    </style>
</head>
<body>

<div class="A4" id="A4" style="height: 0;margin: 0 auto;">

    <!-- Each sheet element should have the class "sheet" -->
    <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
    <section class="sheet padding-10mm top-title" style="padding-top: 0;">
        <article>
            <h1>{{ __('Kingdom of Cambodia') }}</h1>
            <h1>{{ __('National Religious King') }}</h1>
            <p class="style"></p>
            <h2 class="second-title" style="margin-top: 0;">{{ __('Collective agreement') }}</h2>
            <h2>{{ __('About') }}</h2>
            <h2>{{ __('Authorization to Sell Land or Real Estate') }}</h2>

            <p>- {{ __('Referring to the spirit of all team members') }} {{ __('Day') }} <u>{{ __(Date('d'))}}</u> {{ __('Month') }} <u>{{ __(Date('m'))}}</u> {{ __('Year') }} <u>{{ __("--".Date('Y')) }}</u> {{ __('On the topic') }} {{ __('Deciding to Sell Real Estate') }} {{ __('.') }}</p>

            <p class="align-center">
                {{ __('We are all children as listed below:')}}
            </p>

            <article class="padding-l-r-30px">
                <p>
                    {{ __('1.') }} {{ __('Name') }} ....................................... {{ __('Gender') }} ......... ..... {{ __('Hold ID Card') }}
                    ..................................... {{ __('The Kingdom of Cambodia has a home address') }} ... ............... {{ __('Village') }} ...................... {{ __('Commune') }} ........... ............... {{ __('District') }} ........................................... {{ __('Province') }}.................................................................................
                </p>

                <p>
                    {{ __('2.') }} {{ __('Name') }} ....................................... {{ __('Gender') }} ......... ..... {{ __('Hold ID Card') }}
                    ..................................... {{ __('The Kingdom of Cambodia has a home address') }} ... ............... {{ __('Village') }} ...................... {{ __('Commune') }} ........... ............... {{ __('District') }} ........................................... {{ __('Province') }}.................................................................................
                </p>

                <p>
                    {{ __('3.') }} {{ __('Name') }} ....................................... {{ __('Gender') }} ......... ..... {{ __('Hold ID Card') }}
                    ..................................... {{ __('The Kingdom of Cambodia has a home address') }} ... ............... {{ __('Village') }} ...................... {{ __('Commune') }} ........... ............... {{ __('District') }} ........................................... {{ __('Province') }}.................................................................................
                </p>
            </article>

            <p>
                {{ __("Article 01:") }} {{ __('Ok let') }}  {{ __('Name') }} <u>{{ @$property->owner->name ?? '' }}</u> {{ __('Gender') }} <u>{{ $property->owner->gender ?? '' }}</u> {{ __('Hold ID Card') }} <u>{{ $property->owner->id_card ?? '' }}</u>

            <p class="padding-l-r-30px">
                {{ __('The Kingdom of Cambodia has a home address') }} <u>{{ @$property->owner->home_number ?? '' }}</u>  {{ __('Village') }} <u>{{ $property->owner->village->title ?? '' }}</u> {{ __('Commune') }} <u>{{ $property->owner->commune->title ?? '' }}</u> {{ __('District') }} <u>{{ $property->owner->district->title ?? '' }}</u> {{ __('Province') }} <u>{{ $property->owner->province->title ?? '' }}</u>	{{ __('Must be') }}............................................................ {{ __('Sale of land or house for sale') }}................................ {{ __('Village') }} <u>{{ $property->village->title ?? '' }}</u> {{ __('Commune') }} <u>{{ $property->commune->title ?? '' }}</u> {{ __('District') }} <u>{{ $property->district->title ?? '' }}</u> {{ __('Province') }} <u>{{ $property->province->title ?? '' }}</u>
            </p>
            </p>

            <p class="align-center">
                {{ __('Which has the following boundaries:') }}<br>

                - {{ __('North') }} {{ __('vs') }}. .............................. - {{ __('East') }} {{ __('vs') }}. .......... .....................
                - {{ __('South') }} {{ __('vs') }} ........................... - {{ __('West') }} {{ __('vs') }} ............. ..................
            </p>

            <p class="align-center">
                {{ __('There is a letter of title transfer') }}  {{ __('Day') }}.............. {{ __('Month') }} .............. {{ __('Year') }} .................
            </p>

            <p>
                {{ __("Article 02:") }} {{ __('We guarantee that we do not cause any problems to the sale or sale of this property.') }}
            </p>

            <p>
                {{ __("Article 03:") }} {{ __('This collective agreement is effective from the date of this thumbprint.') }}
            </p>

            <p class="float-right align-right">
                {{ __('Held in Phnom Penh') }}  {{ __('Day') }}.............. {{ __('Month') }} .............. {{ __('Year') }} .................
            </p>

            <p>
            <table width="100%" border="1" cellpadding="5" cellspacing="0">
                <tr>
                    <th width="50" class="align-center" ="center">{!! __("N<sup><u>o</u></sup>") !!}</th>
                    <th class="align-center" ="center">{{ __('Member Name') }}</th>
                    <th class="align-center" ="center">{{ __('Right thumbprint and signature') }}</th>
                    <th class="align-center" ="center">{{ __('Dates') }}</th>
                </tr>

                <tr>
                    <td class="align-center">{{ __('--1') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--2') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--3') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--4') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--5') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--6') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="align-center">{{ __('--7') }}</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </table>
            </p>

        </article>

    </section>

</div>
<script type="text/javascript">
    window.print();
</script>
</body>
</html>