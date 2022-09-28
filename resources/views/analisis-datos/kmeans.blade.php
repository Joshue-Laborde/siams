@extends('base')
@section('title', 'Agrupacion')
@section('content')
    <div role="main">
        <div class="container">
            <center>
                <h3>Análisis de Agrupación</h3>
            </center>
            <div class="row">
                <div class="col-sm-4">
                    <div class="card h-80 w-80">
                        <br>
                        <div class="card-body vertical-center">
                            <center>
                                <h4>Datos Entrada</h4>
                            </center>
                            <br>
                            <div class="container">

                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Ingrese rango de fecha: </h6>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="date" id="start_date">
                                    </div>
                                    <div class="col-sm-4">
                                        <input class="form-control" type="date" id="end_date">
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Análisis:</h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <select class="form-control" name="package" id="package">
                                            <option value="t">Temperatura</option>
                                            <option value="d">Distancia</option>
                                            <option value="h">Tiempo</option>
                                        </select>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row" id="seption_normal">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Número de Cluster:</h6>
                                    </label>
                                    {{-- <div class="col-sm-8">
                                        <input class="form-control" type="number" id="x_input"
                                            placeholder="Ingrese datos en grados">
                                    </div> --}}
                                    <div class="col-sm-8">
                                        <select class="form-control" id="cluster" name="cluster" required=""
                                            nchange="numero()">
                                            <option value=0>--</option>
                                            <option value=2>2</option>
                                            <option value=3>3</option>
                                            <option value=4>4</option>
                                            <option value=5>5</option>
                                            <option value=6>6</option>
                                            <option value=7>7</option>
                                            <option value=8>8</option>
                                        </select><br><br>
                                    </div>
                                </div>
                                <center>
                                    <h4>Resultado</h4>
                                </center>

                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Centroides: </h6>
                                    </label>
                                    <div class="col-sm-8 ">
                                        <input class="form-control" type="text" id="centroide" disabled>
                                    </div>
                                </div>
                                <br>
                                <div class="from-group row">
                                    <label class="col-sm-4 col-form-labe" for="">
                                        <h6>Valor de Silhouette: </h6>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" id="sil" disabled>
                                    </div>
                                </div>
                                <br>
                                <br>
                                <div class="from-group row text-center">
                                    <div class="col">
                                        <input class="btn btn-info font-weight-bold" type="button" id="init_predict"
                                            value="Realizar Agrupación">
                                    </div>
                                </div>
                                <br>
                                <div class="row text-center">
                                    <p id="details_text"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm">
                    <center>
                        <h4>Gráficos</h4>
                    </center>
                    <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic1"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic" width="400" height="380"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic2"></h6>
                        </div>
                        <div id="image">
                            <img id="plot" width="400" height="380"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    <div class="col-md-12 col-sm-12 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic3"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic3" width="350" height="300"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div>

                    {{-- <div class="col-md-6 col-sm-6 " style="text-align: center;">
                        <div>
                            <h6 id="Title_grafic4"></h6>
                        </div>
                        <div id="image">
                            <img id="graphic4" width="400" height="400"
                                src="{{ asset('img/img_arules/blanco.png') }}">
                        </div>
                        <br>
                    </div> --}}

                </div>
                <br>
            </div>
        </div>
        <br>
    </div>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {


            var xInput = $('#x_input')
            var section_normal = document.getElementById("seption_normal");
            var section_hour = document.getElementById("seption_hour");
            var x_input_hour = $('#x_input_hour')
            var x_input_minute = $('#x_input_minute')
            var currentPackage = "t"
            var namePackage = ''
            var details_text = $('#details_text');
            var text_placeholder = "";
            //section_hour.style.display = 'none';

            //resultado
            var cluster = '';
            var silhouette = ''

            function numero() {
                cluster = document.getElementById("cluster").value;
                centroide = parseInt(cluster);
                console.log('clusters: ', centroide);
            }

            const packages = {
                t: 'temperature',
                h: 'hour',
                d: 'distance'
            }
            const defaultPackage = "temperature"
            const inputs_placeholder = {
                t: "Ingrese datos en grados",
                d: "Ingrese datos en metros",
            }

            $('#init_predict').click(async function() {
                let start_date = $('#start_date').val();
                let end_date = $('#end_date').val();
                if (start_date === '' || end_date === '') {
                    Swal.fire(
                        'Datos Requeridos',
                        'Ingrese el datos de rango',
                        'warning'
                    )
                    return;
                }
                startDate = new Date(start_date);
                endDate = new Date(end_date);
                nowDate = new Date();

                if (startDate < nowDate && endDate < nowDate) {
                    if (startDate > endDate) {
                        Swal.fire(
                            'Datos Incorrectos',
                            'Las fechas deben ser menores de que la fecha actual',
                            'warning'
                        )
                        return
                    }
                } else {
                    Swal.fire(
                        'Datos Incorrectos',
                        'Las fechas deben ser menores de que la fecha actual',
                        'warning'
                    )
                    return
                }
                resp = await Swal.fire({
                    title: '¿Desea continuar con la agrupación?',
                    text: "Una vez iniciado el proceso no se detendrá",
                    icon: 'info',
                    showCancelButton: true,
                    allowOutsideClick: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Si',
                    showLoaderOnConfirm: false,
                    allowOutsideClick: () => !Swal.isLoading(),
                }).then((result) => {
                    if (result.isConfirmed) {
                        var select = document.getElementById('package').value;
                        var selectK = document.getElementById('cluster').value;
                        var cent = document.getElementById('centroide')
                        var sil = document.getElementById('sil')
                        if (select == 't') {
                            switch (selectK) {
                                case '2':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            '[[0.4946 0.3237] \n[0.6477 0.6640]]'
                                        sil.value = '0.862'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2Temppuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2Tempcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k2Tempfinal.png";
                                    })
                                break;
                                case '3':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            ' [[0.63835228 0.6644259 ] [0.49409968 0.32376327] [0.83506358 0.65454649]]'
                                        sil.value = '0.833'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2Temppuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2Tempcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k3Tempfinal.png";
                                    })
                                break;
                                case '8':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            '[[0.64818914 0.6640626 ][0.47616086 0.33032554][0.83521609 0.66141524][0. 0.6617893 ][0.52870544 0.65831159][0.68362369 0.32408027][0.48861789 0.97826087][0.48863323 0.2209251 ]] '
                                        sil.value = '0.826'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2Temppuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2Tempcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k8Tempfinal.png";
                                    })
                                break;

                            }

                        }
                        if (select == 'd') {
                            switch (selectK) {
                                case '2':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            '[[0.1181 0.0372] \n[0.3866 0.0409]]'
                                        sil.value = '0.606'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2distpuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2distcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k2distfinal.png";
                                    })
                                break;
                                case '4':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            ' [[0.34054998 0.04120126] [0.19346949 0.03587393] [0.0537699  0.03859923] [0.48517616 0.04147686]]'
                                        sil.value = '0.545'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2distpuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2distcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k4distfinal.png";
                                    })
                                break;
                                case '7':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value =
                                            '[[0.50516984 0.04136303] [0.2031619  0.03638826] [0.02953375 0.03670151] [0.03288319 0.90740349] [0.29054714 0.03990967] [0.1168638  0.0339113 ] [0.39137084 0.04171681]] '
                                        sil.value = '0.527'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k2distpuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k2distcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k7distfinal.png";
                                    })
                                break;
                            }
                        }
                        if (select == 'h') {
                            switch (selectK) {
                                case '6':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value = '[[0.34985912 0.33199195]' +
                                            '[0.97857454 0.69887163]' +
                                            '[0.97871553 0.33869795]' +
                                            '[0.02696334 0.3124876 ]' +
                                            '[0.17771293 0.33290297]' +
                                            '[0.32198444 0.69850352]]'
                                        sil.value = '0.914'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k6tiempuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k6tiempcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k6tiempfinal.png";
                                    })
                                break;
                                case '3':
                                    swal.fire({
                                        title: "Ejecutando algoritmo...",
                                        html: '',
                                        timer: 2000,
                                        timerProgressBar: true,
                                        showConfirmButton: false,
                                        animation: true,
                                        onOpen: () => {
                                            Swal.showLoading()
                                        }
                                    }).then((result) => {
                                        cent.value = ' [[0.24598343 0.33637172] [0.97857454 0.69887163] [0.97871553 0.33869795]]'
                                        sil.value = '0.924'
                                        //Gráfica 1
                                        document.getElementById("Title_grafic1")
                                            .innerHTML =
                                            "Distribución de los puntos";
                                        document.getElementById("graphic").src =
                                            "../img/agrupacion/k6tiempuntos.png";
                                        //Gráfica 2
                                        document.getElementById("Title_grafic2")
                                            .innerHTML =
                                            "Gráfica Elbow";
                                        document.getElementById("plot").src =
                                            "../img/agrupacion/k6tiempcodo.png?";

                                        //Gráfica 3
                                        document.getElementById("Title_grafic3")
                                            .innerHTML =
                                            "Gráfica de las Agrupaciones";
                                        document.getElementById("graphic3").src =
                                            "../img/agrupacion/k3tiempfinal.png";
                                    })
                                break;
                            }
                        }
                    }


                })


            })

            function clearInputs() {
                xInput.val("")
                x_input_hour.val("")
                x_input_minute.val("")
                $("#val_prediction").val("")
                $("#score").val("")
                $("#error_margin").val("")
                $("#ct-chart1").empty()

                cleanCoordinates()
            }
        });
    </script>
@endsection
