<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>LawanBanjir!</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <style>
            body {
                font-family: 'Poppins';
                color: white;
            }

            .bg {
                background-image: url('banjir2.jpg');
                background-size: cover;
                height: 647px;
            }
            h1 {
                font-weight: bold;
                font-size: 50px;

                animation: fadeInDownBig; /* referring directly to the animation's @keyframe declaration */
                animation-duration: 1.5s; /* don't forget to set a duration! */
            }

            .description {
                font-size: 15px;
                animation: fadeInDownBig; /* referring directly to the animation's @keyframe declaration */
                animation-duration: 2.5s; /* don't forget to set a duration! */
            }

            .cta {
                animation: fadeInDownBig; /* referring directly to the animation's @keyframe declaration */
                animation-duration: 3.2s; /* don't forget to set a duration! */
            }
            .garis {
                height: 10px;
                color: aqua;
            }
        </style>
    </head>
    <body style="background-color:white!important">
        <div class="bg">
            <div class="container">
                <div class="row banner">
                    <div class="col-md-12" style="margin-top: 200px">
                        <div class="text-banner text-center ">
                            <h1 class="mb-3">Selamat Datang di LawanBanjir!</h1>
                            <p class="description">
                                Banjir merupakan masalah yang sampai saat masih perlu adanya penanganan khusus dari berbagai pihak, baik dari pihak pemerintah maupun masyarakat. Karena banjir bukan masalah yang mudah diselesaikan.
                                Banjir menyebabkan berbagai macam resiko, di antaranya rumah warga menjadi kotor, adanya korban jiwa, korban materi, warga terserang berbagai macam penyakit (penyakit kulit, diare, dan lain-lain),
                                rusaknya bangunan-bangunan, macetnya kegiatan ekonomi warga, jalan berlubang, bahkan hingga trauma yang dialami oleh warga masyarakat, dan lain-lain. Maka dari itu <span style="font-weight: bold">LawanBanjir!</span>
                                menjadi platform untuk mengantisipasi adanya banjir
                            </p>
                        </div>
                        <div class="cta text-center mx-auto">
                            <a href="{{ url('/addlocation') }}" class="btn btn-primary">Tambah Lokasi Banjir</a>
                            <a href="{{ url('/map') }}" class="btn btn-primary">Semua Data Lokasi Banjir</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
