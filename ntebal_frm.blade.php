@extends('layouts.coloradmin')
<!-- ------------------------------------------------------------------------------- -->
@section('title')Thickness Monitoring @stop
<!-- ------------------------------------------------------------------------------- -->
@section('title-small') @stop
<!-- ------------------------------------------------------------------------------- -->
@section('breadcrumb')
    <span ng-show="f.tab=='list'">Data List</span>
<span ng-show="f.tab=='frm'">Form Entry</span> @stop
<!-- ------------------------------------------------------------------------------- -->

@section('content')
    <div class="panel panel-success">
        <div class="panel-heading">
            @component('layouts.common.coloradmin.panel_button')
            @endcomponent @yield('breadcrumb')
        </div>
        <div class="panel-body">
            <div class="m-b-5 form-inline">
                <div class="pull-right">
                    <div ng-show="f.tab=='list'">
                        @component('layouts.common.coloradmin.guide', ['tag' => 'trs_local_ntebal'])
                        @endcomponent
                        <div class="input-group">
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm" ng-click="oPrintTable()"><i
                                        class="fa fa fa-print"></i></button>
                                <button type="button" class="btn btn-success btn-sm" ng-click="oSearch(1)"><i
                                        class="fa fa fa-recycle"></i></button>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form-control input-sm" ng-model="f.q" ng-enter="oSearch()"
                                placeholder="Search">
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success btn-sm" ng-click="oSearch()"><i
                                        class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div ng-show="f.tab=='frm'">
                        <button type="button" class="btn btn-sm" style="background-color:#8479E1;color:white"
                            ng-click="oPrint()" ng-show="f.crud=='u' && f.trash!=1"><i class="fa fa fa-print"></i>
                            Print</button>
                        <button type="button" class="btn btn-sm btn-success" ng-click="oSave()"
                            ng-show="f.crud=='c' && f.trash!=1"><i class="fa fa-save"></i> Create</button>
                        <button type="button" class="btn btn-sm btn-success" ng-click="oSave()"
                            ng-show="f.crud=='u' && f.trash!=1"><i class="fa fa-save"></i> Update</button>
                        <button type="button" class="btn btn-sm btn-warning" ng-click="oCopy()" ng-show="f.crud=='u'"><i
                                class="fa fa-copy"></i> Copy</button>
                        <button type="button" class="btn btn-sm btn-danger" ng-click="oDel()"
                            ng-show="f.crud=='u'&& f.trash!=1"><i class="fa fa-trash"></i> Delete</button>
                        <button type="button" class="btn btn-sm btn-warning" ng-click="oRestore()"
                            ng-show="f.crud=='u' && f.trash==1"><i class="fa fa-recycle"></i> Restore</button>
                        <button type="button" class="btn btn-sm btn-info" ng-click="oLog()" ng-show="f.crud=='u'"><i
                                class="fa fa-clock-o"></i> Log</button>
                        <span ng-if="f.crud!='c'"> @component('layouts.common.coloradmin.chat', ['route' => 'trs_local_ntebal', 'id' => 'h.id'])
                            @endcomponent </span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-inverse" ng-click="oNew()" ng-attr-title="Buat Baru"
                    ng-show="f.tab=='list' && f.trash!=1"><i class="fa fa-plus"></i> New</button>
                <button type="button" class="btn btn-sm btn-inverse" ng-click="f.tab='list'"
                    ng-attr-title="Kembali ke Halaman Awal" ng-show="f.tab=='frm'"><i class="fa fa-arrow-left"></i>
                    Back</button>
            </div>
            <br>
            <div ng-show="f.tab=='list'">
                <div class="alert alert-warning" ng-show="f.trash==1"><i class="fa fa-warning fa-2x"></i> This is deleted
                    item<br>Trashed</div>
                <div class="row ">
                    <div class="col-sm-4" style="padding: 10px;">
                        <label>Date Start</label>
                        <input type="date" ng-model="f.date1" class="form-control input-sm">
                    </div>
                    <div class="col-sm-4" style="padding: 10px;">
                        <label>Date To</label>
                        <input type="date" ng-model="f.date2" class="form-control input-sm">
                    </div>
                    <div class="col-sm-4" style="padding: 10px;">
                        <label>&nbsp;</label>
                        <button type="button" class="btn btn-sm btn-success btn-block" ng-click="oSearch()"><i
                                class="fa fa-refresh"></i> Refresh</button>
                    </div>
                </div>

                <div id="div1" class="table-responsive">

                    <table ng-table="tableList" show-filter="false" class="table table-condensed table-bordered tbl-list"
                        style="white-space: nowrap;">
                        <tbody ng-repeat="(k,v) in $data">
                            <tr>
                                <td title="'#'">@{{ $index + 1 }}</td>

                                <td title="'Item'" style="width: 5%;">
                                    <i class="fa fa-eye text-info pointer" style="font-size: 14px;"
                                        ng-show="v.show !== 1" ng-click="v.show = 1"></i>
                                    <i class="fa fa-eye-slash text-danger pointer" style="font-size: 14px;"
                                        ng-show="v.show == 1" ng-click="v.show = 0"></i>
                                </td>
                                <td title="'Tanggal'" filter="{tanggal: 'text'}" sortable="'tanggal'" class="pointer"
                                    ng-click="oShow(v.token)">
                                    @{{ v.tanggal }}
                                </td>
                                <td title="'Nama Material'" filter="{nama_material: 'text'}" sortable="'nama_material'"
                                    class="pointer" ng-click="oShow(v.token)">
                                    @{{ v.nama_material }}</td>
                                <td title="'Supplier'" filter="{supplier: 'text'}" sortable="'supplier'" class="pointer"
                                    ng-click="oShow(v.token)">
                                    @{{ v.supplier }}</td>
                                <td title="'Volume (m2)'" filter="{volume: 'text'}" sortable="'volume'" class="pointer"
                                    ng-click="oShow(v.token)" style="width: 5%;">
                                    @{{ v.volume }}</td>

                                <td title="'Maximal (mm)'" class="pointer" ng-click="oShow(v.token)" style="width: 5%;">
                                    @{{ v.xmax }}
                                </td>
                                <td title="'Minimal (mm)'" class="pointer" ng-click="oShow(v.token)" style="width: 5%;">
                                    @{{ v.xmin }}
                                </td>
                                <td title="'Average (mm)'" class="pointer" ng-click="oShow(v.token)" style="width: 5%;">
                                    @{{ v.xavg }}
                                </td>
                                <td title="'Range (mm)'" class="pointer" ng-click="oShow(v.token)" style="width: 5%;">
                                    @{{ v.xrange }}
                                </td>

                            </tr>

                            <tr ng-show="v.show == 1" ng-init="initializeHighcharts(k, $data)">
                                <td class="p-5" colspan="12" style="background-color: whitesmoke;">
                                    <h3 style="margin-top: 3px">Detail</h3>
                                    <div id="bellCurveChart-@{{ k }}" chart-directive="$data"></div>
                                    <table class="table table-bordered table-condensed tbl-det" width="100%"
                                        style="border-collapse: collapse;margin-bottom: 0px;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>X1</th>
                                                <th>X2</th>
                                                <th>X3</th>
                                                <th>X4</th>
                                                <th>X5</th>
                                                <th>X6</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="v1 in v.rel_d1">
                                                <td class="text-bold"> @{{ $index + 1 }}
                                                <td class="text-bold">@{{ v1.x1 }}</td>
                                                <td class="text-bold">@{{ v1.x2 }}</td>
                                                <td class="text-bold">@{{ v1.x3 }}</td>
                                                <td class="text-bold">@{{ v1.x4 }}</td>
                                                <td class="text-bold">@{{ v1.x5 }}</td>
                                                <td class="text-bold">@{{ v1.x6 }}</td>

                                            </tr>

                                        </tbody>
                                    </table>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div ng-show="f.tab=='frm'">
                <form action="#" name="frm" id="frm">
                    <div class="vertical-box" style="min-height: 500px">
                        <div class="vertical-box-column bg-white" style="border:1px solid #e2e7eb">
                            <div data-scrollbar="true" data-height="100%" class="wrapper">
                                <div class="panel-group" id="accordion">
                                    <div class="panel panel-primary overflow-hidden">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled" data-toggle="collapse"
                                                    data-parent="#accordion" href="#collapseOne">
                                                    <i class="fa fa-plus-circle pull-right"></i>
                                                    Header Mitutoyo <span ng-if="h.no_impr"
                                                        style="padding: 2px 6px; margin-left: 5px; border: 2px solid #fff;"><b>@{{ h.no_impr }}</b></span>
                                                </a> 
                                            </h3>
                                        </div>
                                        <div>
                                            <div class="panel-body">
                                                <div class="col-sm-4">
                                                    <label title='id'>Id</label>
                                                    <input type="text" ng-model="h.id" id="h_id"
                                                        class="form-control input-sm" readonly maxlength=""
                                                        ng-readonly="f.crud!='c' || true " placeholder="auto">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label title='tanggal'>Tanggal</label>
                                                    <input type="date" ng-model="h.tanggal" id="h_tanggal"
                                                        class="form-control input-sm" maxlength="">
                                                </div>
                                                <div class="col-sm-4">
                                                    <label title='nama_material'>Nama Material</label>
                                                    <input type="text" ng-model="h.nama_material" id="h_nama_material"
                                                        class="form-control input-sm" maxlength="30">
                                                </div>
                                                <div class="col-sm-4" style="margin-top: 10px">
                                                    <label title='supplier'>Supplier</label>
                                                    <input type="text" ng-model="h.supplier" id="h_supplier"
                                                        class="form-control input-sm" maxlength="30">
                                                </div>
                                                <div class="col-sm-4" style="margin-top: 10px">
                                                    <label title='volume'>Volume (m2)</label>
                                                    <input type="text" ng-model="h.volume" id="h_volume"
                                                        class="form-control input-sm" maxlength="30">
                                                </div>
                                                <div class="col-sm-2" style="margin-top: 10px">
                                                    <label title='usl'>USL</label>
                                                    <input type="text" ng-model="h.usl" id="h_usl"
                                                        class="form-control input-sm" maxlength="30">
                                                </div>
                                                <div class="col-sm-2" style="margin-top: 10px">
                                                    <label title='lsl'>LSL</label>
                                                    <input type="text" ng-model="h.lsl" id="h_lsl"
                                                        class="form-control input-sm" maxlength="30">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="panel panel-primary overflow-hidden">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                <a class="accordion-toggle accordion-toggle-styled collapsed"
                                                    data-toggle="collapse" data-parent="#accordion" href="#collapseFour">
                                                    <i class="fa fa-plus-circle pull-right"></i>
                                                    Detail</span>
                                                </a>
                                            </h3>
                                        </div>
                                        <div id="collapseFour" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <div class="row">
                                                    <div class="col-xs-2">
                                                        <label title='x1'><b>X1</b></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label title='x2'><b>X2</b></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label title='x3'><b>X3</b></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label title='x4'><b>X4</b></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label title='x5'><b>X5</b></label>
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <label title='x6'><b>X6</b></label>
                                                    </div>
                                                </div>

                                                <div class="row" ng-repeat="(key, item) in h.rel_d1">
                                                    <div class="col-xs-2">
                                                        <input id="row-@{{key}}-x1" type="text" ng-keyup="bebas(key, 'x1')"
                                                            ng-model="item.x1" class="form-control input-xs"
                                                            maxlength="30">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input id="row-@{{key}}-x2" type="text" ng-change="bebas(key, 'x2')"
                                                            ng-model="item.x2" class="form-control input-xs"
                                                            maxlength="30">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="text" ng-change="bebas(key)" ng-model="item.x3"
                                                            class="form-control input-xs" maxlength="30">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="text" ng-change="bebas(key)" ng-model="item.x4"
                                                            class="form-control input-xs" maxlength="30">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="text" ng-change="bebas(key)" ng-model="item.x5"
                                                            class="form-control input-xs" maxlength="30">
                                                    </div>
                                                    <div class="col-xs-2">
                                                        <input type="text" ng-change="bebas(key)" ng-model="item.x6"
                                                            class="form-control input-xs" maxlength="30">
                                                    </div>
                                                    <div class="col-xs-1" style="margin-left: 5px">
                                                        <button type="button" ng-click="removeRow($index)"
                                                            class="btn btn-xs btn-danger" style="margin-top: 0px;"><i
                                                                class="fa fa-trash"></i></button>
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <button type="button" ng-click="addRow()"
                                                            class="btn btn-sm btn-inverse"
                                                            style="margin-top: 20px;">Tambah Baris</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                {{-- <form action="#" name="frm" id="frm">
                    <div class="row">
                        <div class="col-sm-4">
                            <label title='id'>Id</label>
                            <input type="text" ng-model="h.id" id="h_id" class="form-control input-sm" readonly
                                maxlength="" ng-readonly="f.crud!='c' || true " placeholder="auto">
                        </div>
                        <div class="col-sm-4">
                            <label title='tanggal'>Tanggal</label>
                            <input type="date" ng-model="h.tanggal" id="h_tanggal" class="form-control input-sm"
                                maxlength="">
                        </div>
                        <div class="col-sm-4">
                            <label title='nama_material'>Nama Material</label>
                            <input type="text" ng-model="h.nama_material" id="h_nama_material"
                                class="form-control input-sm" maxlength="30">
                        </div>

                        <div class="row">
                            <div class="col-sm-2">
                                <label title='x1'>X1</label>
                            </div>
                            <div class="col-sm-2">
                                <label title='x2'>X2</label>
                            </div>
                            <div class="col-sm-2">
                                <label title='x3'>X3</label>
                            </div>
                            <div class="col-sm-2">
                                <label title='x4'>X4</label>
                            </div>
                            <div class="col-sm-2">
                                <label title='x5'>X5</label>
                            </div>
                            <div class="col-sm-2">
                                <label title='x6'>X6</label>
                            </div>
                        </div>

                        <div class="row" ng-repeat="item in h.rel_d1">
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x1" class="form-control input-sm" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x2" class="form-control input-sm" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x3" class="form-control input-sm" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x4" class="form-control input-sm" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x5" class="form-control input-sm" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <input type="text" ng-model="item.x6" class="form-control input-sm" maxlength="30">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-sm-12">
                                <button type="button" ng-click="addRow()" class="btn btn-sm btn-inverse">Tambah Baris</button>
                            </div>
                        </div>

                    </div>

                </form> --}}
            </div>
        </div>
    </div>
    <style type="text/css">
        .tbl-list>thead>tr>th {
            background-color: #008a8a !important;
            color: white !important;
            padding: 5px 10px;
        }

        .tbl-list>tbody>tr>td {
            padding: 5px 10px;
        }

        .tbl-det>thead>tr>th {
            background-color: gray !important;
            color: white !important;
            padding: 5px 10px;
        }

        .tbl-det>tbody>tr>td {
            padding: 5px 10px;
        }

        .row>[class*="col-"] {
            padding: 5px;
        }

        .col-xs-2 {
            flex: 0 0 15.0%;
            max-width: 15.0%;

        }
    </style>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/histogram-bellcurve.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script>
        app.directive('chartDirective', ['$timeout', function($timeout) {
            return {
                link: function(scope, element, attrs) {
                    // Dapatkan ID dari elemen
                    var chartId = attrs.id;

                    // Gunakan $timeout untuk memastikan elemen DOM sudah ada
                    $timeout(function() {
                        // Dapatkan data langsung dari atribut directive
                        var dataX = scope.$eval(attrs.chartDirective);

                        // Inisialisasi grafik di sini
                        scope.initializeHighcharts(chartId, dataX);
                    });
                }
            };
        }]);

        app.controller('mainCtrl', ['$scope', '$http', '$timeout', 'NgTableParams', 'SfService', 'FileUploader', function(
            $scope, $http, $timeout,
            NgTableParams, SfService, FileUploader) {
            SfService.setUrl("{{ url('trs_local_ntebal') }}");
            $scope.f = {
                crud: 'c',
                tab: 'list',
                trash: 0,
                userid: "{{ Auth::user()->userid }}",
                plant: "{{ Session::get('plant') }}",
                date1: moment().startOf('month').toDate(),
                date2: moment().endOf('month').toDate(),
                req_date1: moment().subtract(3, 'd').toDate(),
                req_date2: moment().toDate(),
            };
            $scope.h = {};
            $scope.m = [];
            $scope.ntebald1Data = {!! json_encode($ntebald1Data) !!};
            // console.log($scope.ntebald1Data);
            $scope.chartElements = {};
            $scope.initializeHighcharts = function(id, dataX) {
                $timeout(function() {
                    // Get the DOM element by ID
                    var bellCurveChartElement = document.getElementById(`bellCurveChart-${id}`);
                    // console.log("Element ID:", bellCurveChartElement ? bellCurveChartElement.id :
                    //     "Not found");
                    // console.log("ahdfioa;", dataX);
                    const data = dataX[id]?.dataMerge;
                    // const data = [
                    //     10.3, 10.3, 10.3, 4.1, 4.3, 5.1,10.1, 10.2, 10.2, 4, 5.1, 4.4, 10.6, 10.4, 10.2, 3.7, 3.4, 4.6, 10.2,
                    //     10, 10, 4.5, 3, 3.7, 10.4, 10.3, 10.4,  10.2, 10.1, 10, 4.8,
                    //     10.2, 10, 10.1, 3.1, 3.7, 3.3, 9.9, 9.9, 9.9, 9.7,
                    //     9.7, 9.6, 9.8, 9.7, 9.8, 10.8, 10.5, 10.3,
                    //      10.6, 10.5, 10.4, 10.3, 10.4, 10.3, 
                    //     10.6, 10.4, 10.3, 7, 5.7, 6.8, 10.5, 10.3, 10.5, 10.3,
                    //     10.3, 10.3, 6.8, 7.1, 6.8, 10.1, 10.2, 10.2, 7.1, 7.1, 7.1, 10.6, 10.4,
                    //     10.2, 5.1, 6.8, 5.8, 10.2, 10, 10, 3.7, 4.9, 5.6, 10.4, 10.3, 10.4, 3.7,

                    // ];
                    // console.log("ahdfioa;",data);
                    // Batas USL dan LSL berdasarkan x-axis
                    const uslX = dataX[id]?.usl; // Upper Specification Limit
                    const lslX = dataX[id]?.lsl; // Lower Specification Limit
                    // Check if Highcharts is not already initialized for the container
                    if (bellCurveChartElement && !Highcharts.charts[bellCurveChartElement
                            .chartIndex]) {
                        Highcharts.chart(`bellCurveChart-${id}`, {
                            title: {
                                text: "Bell curve",
                            },
                            xAxis: [{
                                    title: {
                                        text: "Data"
                                    },
                                    alignTicks: false,
                                    opposite: true,
                                    visible: false,
                                },
                                {
                                    title: {
                                        text: "Bell curve"
                                    },
                                    alignTicks: false,
                                    opposite: false,
                                    plotLines: [{
                                            color: "red", // Warna garis
                                            dashStyle: "dash", // Gaya garis (dashed)
                                            width: 2, // Lebar garis
                                            value: uslX, // Nilai x untuk USL
                                            zIndex: 3, // Layer garis
                                        },
                                        {
                                            color: "red",
                                            dashStyle: "dash",
                                            width: 2,
                                            value: lslX,
                                            zIndex: 3,
                                        },
                                    ],
                                },
                            ],
                            yAxis: [{
                                    title: {
                                        text: "Data"
                                    },
                                    labels: {
                                        format: "{value}%",
                                    },
                                    max: 100,
                                    tickInterval: 5,
                                },
                                {
                                    title: {
                                        text: "Bell curve"
                                    },
                                    opposite: true,
                                },
                            ],
                            series: [{
                                    name: "Bell curve",
                                    type: "bellcurve",
                                    xAxis: 1,
                                    yAxis: 1,
                                    baseSeries: 1,
                                    zIndex: -1,
                                },
                                {
                                    name: "Data",
                                    type: "scatter",
                                    data: data,
                                    visible: false,
                                    accessibility: {
                                        exposeAsGroupOnly: true,
                                    },
                                    marker: {
                                        radius: 1.5,
                                    },
                                },

                            ],
                        });
                    }
                });

            };


            $scope.addRow = function() {
                if (!$scope.h.rel_d1 || $scope.h.rel_d1.length == 0) {
                    // If rel_d1 is empty, add a new item
                    $scope.h.rel_d1 = [{
                        x1: '',
                        x2: '',
                        x3: '',
                        x4: '',
                        x5: '',
                        x6: ''
                    }];
                } else {
                    // If rel_d1 is not empty, add a new row to the existing rel_d1
                    $scope.h.rel_d1.push({
                        x1: '',
                        x2: '',
                        x3: '',
                        x4: '',
                        x5: '',
                        x6: ''
                    });
                }
            };
            $scope.removeRow = function(index) {
                // Pastikan index valid dan tidak melebihi panjang array
                if (index !== undefined && index >= 0 && index < $scope.h.rel_d1.length) {
                    // Hapus baris dari array rel_d1
                    $scope.h.rel_d1.splice(index, 1);
                }
            };
            var uploader = $scope.uploader = new FileUploader({
                url: "{{ url('upload_file') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                onBeforeUploadItem: function(item) {
                    //s pattern : t : text, i : image,a : audio, v : video, p : application, x : all mime
                    item.formData = [{
                        id: $scope.h.id,
                        path: 'trs_local_ntebal',
                        s: 'i',
                        userid: $scope.f.userid,
                        plant: $scope.f.plant
                    }];
                },
                onSuccessItem: function(fileItem, response, status, headers) {
                    $scope.oGallery();
                }
            });

            $scope.oGallery = function() {
                SfGetMediaList('trs_local_ntebal/' + $scope.h.id, function(jdata) {
                    $scope.m = jdata.files;
                    $scope.$apply();
                });
            }

            $scope.oNew = function() {
                $scope.f.tab = 'frm';
                $scope.f.crud = 'c';
                $scope.h = {};
                $scope.m = [];
                SfFormNew("#frm");
            }

            $scope.oCopy = function() {
                $scope.f.crud = 'c';
                $scope.h.id = null;
            }


            $scope.oSearch = function(trash, order_by) {
                $scope.f.tab = "list";
                $scope.f.trash = trash;
                $scope.tableList = new NgTableParams({}, {
                    getData: function($defer, params) {
                        var $btn = $('button').button('loading');
                        return $http.get(SfService.getUrl("_list"), {
                            params: {
                                page: $scope.tableList.page(),
                                limit: $scope.tableList.count(),
                                order_by: $scope.tableList.orderBy(),
                                q: $scope.f.q,
                                trash: $scope.f.trash,
                                plant: $scope.f.plant,
                                userid: $scope.f.userid,
                                date1: $scope.f.date1,
                                date2: $scope.f.date2,

                            }
                        }).then(function(jdata) {
                            // console.log(jdata, 'data!!');
                            // nambahin arrDataChart => data [arrDataChart: [merge rel_d1]]
                            // let filterArrayd1 = [];  
                            // Object.entries(jdata.data.data.data).map(([k2, v], k) => {
                            //     // harus ambil data yang berawalan x, lalu di merge
                            //     filterArrayd1.push(v.rel_d1)
                            //     // lalu looping v
                            // })

                            const dataArray = Object.entries(jdata.data.data.data);

                            // dataArray.forEach(([k2, v]) => {
                            //     const xValues = v.rel_d1.map(item => [item.x1, item.x2, item.x3, item.x4, item.x5, item.x6].join(','));
                            //     const data = {
                            //         xValues: xValues.join(','),
                            //     };

                            //     filterArrayd1.push(data);
                            // });
                            const filterArrayd1 = dataArray.map(([k2, v]) => {
                                return v.rel_d1.map(item => [item.x1, item.x2,
                                    item.x3, item.x4, item.x5, item.x6
                                ]);
                            });
                            const combinedArray = filterArrayd1.map(subArray => subArray
                                .reduce((acc, arr) => acc.concat(arr), []));

                            // console.log(combinedArray);

                            combinedArray.map((v, k) => {
                                jdata.data.data.data[k] = {
                                    ...jdata.data.data.data[k],
                                    dataMerge: v
                                }

                            })
                            // console.log(filterArrayd1);
                            // const lsl = jdata.data.data.data.map(item => item.lsl);
                            // const usl = jdata.data.data.data.map(item => item.usl);
                            // $scope.initializeHighcharts(0, jdata.data.data.data[0]
                            //     .dataMerge, lsl[0], usl[0]);

                            $btn.button('reset');
                            // console.log('Data from API:', jdata.data);
                            $scope.tableList.total(jdata.data.data.total);
                            // Ambil rel_d1 dari setiap objek dalam data
                            const relD1Array = jdata.data.data.data.map(item => item
                                .rel_d1);


                            // Menggabungkan semua rel_d1 menjadi satu array tunggal
                            const flattenedRelD1 = relD1Array.flat();

                            // Tampilkan di console
                            // console.log('flattenedRelD1:', flattenedRelD1);
                            return jdata.data.data.data;
                        }, function(error) {
                            $btn.button('reset');
                            swal('', error.data, 'error');
                        });
                    }
                });
            }

            $scope.oSave = function() {
                SfService.save("#frm", SfService.getUrl(), {
                    h: $scope.h,
                    f: $scope.f
                }, function(jdata) {
                    $scope.oSearch();
                });
            }

            $scope.oShow = function(token) {
                SfService.show(SfService.getUrl("/" + encodeURI(token) + "/edit"), {}, function(jdata) {
                    $scope.oNew();
                    $scope.h = jdata.data.h;
                    // console.log($scope.h);
                    $scope.h.tanggal = moment(jdata.data.h.tanggal).toDate();
                    $scope.f.crud = 'u';
                    $scope.oGallery();
                    if (chatCtrl() != undefined) {
                        chatCtrl().listChat();
                    }
                });
            }

            $scope.oDel = function(token, isRestore) {
                if (token == undefined) {
                    var token = $scope.h.token;
                }
                SfService.delete(SfService.getUrl("/" + encodeURI(token)), {
                    restore: isRestore
                }, function(jdata) {
                    $scope.oSearch();
                });
            }

            $scope.oRestore = function(id) {
                $scope.oDel(id, 1);
            }

            $scope.oLookup = function(id, selector, obj) {
                switch (id) {
                    /*case 'parent':
                        SfLookup(SfService.getUrl("_lookup"), function(id, name, jsondata) {
                            $("#" + selector).val(id).trigger('input');;
                        });
                        break;*/
                    default:
                        swal('Sorry', 'Under construction', 'error');
                        break;
                }
            }

            $scope.oLog = function() {
                SfLog('trs_local_ntebal', $scope.h.id);
            }

            $scope.oPrint = function() {
                window.open(SfService.getUrl('_print') + "/" + '?token=' + $scope.h.token);
            }

            $scope.bebas = function(key, field) {
                // // Clear any existing timeout
                // if ($scope.timer) {
                //     $timeout.cancel($scope.timer);
                // }

                // // Set a new timeout for 1000 milliseconds (1 second)
                // $scope.timer = $timeout(function() {
                //     if (field === 'x1') {
                //         console.log($scope.h.rel_d1[key].x1);
                //         var currentInput = angular.element(document.querySelector(`row-${key}-x1`));
                //         console.log(currentInput, 'current');
                //         // var nextInput = currentInput.next('input');

                //         // if (nextInput.length > 0) {
                //         //     nextInput[0].focus();
                //         // }
                //     }
                // }, 1000);
            };

            $scope.oSearch();
        }]);
    </script>
@endsection
