<!-- solid sales graph -->
<div class="card bg-gradient-info">
    <div class="card-header border-0">
        <h3 class="card-title">
            <i class="fas fa-th mr-1"></i>
            Sales Graph
        </h3>

        <div class="card-tools">
            <button type="button" class="btn bg-info btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn bg-info btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body">
        <canvas class="chart" id="line-chart"
            style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
    </div>
    <!-- /.card-body -->
    <div class="card-footer bg-transparent">
        <div class="row">
            <div class="col-4 text-center">
                <input type="text" class="knob" data-readonly="true" value="20"
                    data-width="60" data-height="60" data-fgColor="#39CCCC">

                <div class="text-white">Mail-Orders</div>
            </div>
            <!-- ./col -->
            <div class="col-4 text-center">
                <input type="text" class="knob" data-readonly="true" value="50"
                    data-width="60" data-height="60" data-fgColor="#39CCCC">

                <div class="text-white">Online</div>
            </div>
            <!-- ./col -->
            <div class="col-4 text-center">
                <input type="text" class="knob" data-readonly="true" value="30"
                    data-width="60" data-height="60" data-fgColor="#39CCCC">

                <div class="text-white">In-Store</div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.card-footer -->
</div>
<!-- /.card -->

<script>
    $(function(){
        
        // Sales graph chart
        var salesGraphChartCanvas = $('#line-chart').get(0).getContext('2d')
        // $('#revenue-chart').get(0).getContext('2d');

        var salesGraphChartData = {
            labels: ['2011 Q1', '2011 Q2', '2011 Q3', '2011 Q4', '2012 Q1', '2012 Q2', '2012 Q3', '2012 Q4', '2013 Q1', '2013 Q2'],
            datasets: [
            {
                label: 'Digital Goods',
                fill: false,
                borderWidth: 2,
                lineTension: 0,
                spanGaps: true,
                borderColor: '#efefef',
                pointRadius: 3,
                pointHoverRadius: 7,
                pointColor: '#efefef',
                pointBackgroundColor: '#efefef',
                data: [2666, 2778, 4912, 3767, 6810, 5670, 4820, 15073, 10687, 8432]
            }
            ]
        }

        var salesGraphChartOptions = {
            maintainAspectRatio: false,
            responsive: true,
            legend: {
            display: false
            },
            scales: {
            xAxes: [{
                ticks: {
                fontColor: '#efefef'
                },
                gridLines: {
                display: false,
                color: '#efefef',
                drawBorder: false
                }
            }],
            yAxes: [{
                ticks: {
                stepSize: 5000,
                fontColor: '#efefef'
                },
                gridLines: {
                display: true,
                color: '#efefef',
                drawBorder: false
                }
            }]
            }
        }

        // This will get the first returned node in the jQuery collection.
        // eslint-disable-next-line no-unused-vars
        var salesGraphChart = new Chart(salesGraphChartCanvas, { // lgtm[js/unused-local-variable]
            type: 'line',
            data: salesGraphChartData,
            options: salesGraphChartOptions
        })
    })
</script>